<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Smalot\PdfParser\Parser;


class ParserController extends AbstractController
{
    /**
     * Находит индекс, соответствующий началу перечисления видов спорта.
     * Предполагается, что у каждого вида спорта имеется запись "Основной состав".
     * @param mixed $content
     * @return int
     */
    private function findStartPosition(array $content): int
    {
        for ($i = 0; $i < count($content); $i++) {
            if ($content[$i] == "Основной состав") {
                return $i - 1;  // Вид спорта будет перед найденной строкой
            }
        }
        return 0;
    }

    private function isIdString(string $stringToCheck): bool
    {
        return ctype_digit($stringToCheck) && strlen($stringToCheck) === 16;
    }

    private function isSportTitle(array $content, int $indexToCheck): bool
    {
        // Если после строки есть "Основной состав" и начинается перечисление соревнований, то это название спорта
        try {
            return $content[$indexToCheck+1] == "Основной состав" && $this->isIdString(explode(" ", $content[$indexToCheck+2])[0]);
        } catch (\ErrorException $e) {  // Может выскочить в конце файла
            return false;
        }
    }

    private function getEmptySportObject(): array
    {
        return [
            "title" => "",
            "mainDivision" => [],
            "ReserveDivision" => []
        ];
    }

    private function getEmptyEventObject(): array
    {
        return [
            "id" => 0,
            "title" => "",
            "tags" => [],
            "from_date" => "",
            "to_date" => "",
            "country" => "",
            "region" => "",
            "city" => "",
            "amount" => 0
        ];
    }

    private function isEventObjectReady(array $e): bool
    {
        return $e["id"] != 0 && $e["amount"] != 0 && !empty($e["title"]) && 
        !empty($e["from_date"]) && !empty($e["to_date"]) && !empty($e["country"]) && !empty($e["city"]);
    }

    private function makeSexAndAgeTags(string $stringToTag): array
    {
        $sexWords = ["мужчины", "юноши", "мальчики", "юниоры", "женщины", "девушки", "девочки", "юниорки"];
        $pattern_from_age = '/от\s+(\d{1,2})\s+лет/';
        $pattern_to_age = '/до\s+(\d{1,2})\s+лет/';
        $pattern_between_age = '/(\d{1,2})-(\d{1,2})\s+лет/';

        $tags = [];

        foreach ($sexWords as $word) {
            if (str_contains($stringToTag, $word)) {
                $tags[] = $word;
            }
        }

        // Обработка совпадений для формата "от N лет"
        if (preg_match_all($pattern_from_age, $stringToTag, $matches)) {
            foreach ($matches[1] as $age) {
                $tags[] = "от $age лет";
            }
        }

        // Обработка совпадений для формата "до N лет"
        if (preg_match_all($pattern_to_age, $stringToTag, $matches)) {
            foreach ($matches[1] as $age) {
                $tags[] = "до $age лет";
            }
        }

        // Обработка совпадений для формата "N-M лет"
        if (preg_match_all($pattern_between_age, $stringToTag, $matches)) {
            foreach ($matches[0] as $index => $range) {
                $ageStart = $matches[1][$index];
                $ageEnd = $matches[2][$index];
                $tags[] = "$ageStart-$ageEnd лет";
            }
        }

        return $tags;
    }

    // Для дисциплин
    private function makeTags(string $stringToTag): array
    {
        $tags = [];

        $temp = preg_replace_callback(
            '/\(([^()]*?)(,)([^()]*?)\)/',
            function ($matches) {
                return str_replace(',', '&', $matches[0]);
            },
            $stringToTag
        );
        
        $temp = preg_replace('/(\d+),(?=\d+)/', '$1&', $temp);
        
        $temp = explode(",", $temp);
        
        foreach($temp as $t) {
            if (str_contains($t, "дисциплины")) $t = str_replace("дисциплины", "", $t);
            $tags[] = trim(str_replace("&", ",", $t));
        }

        return $tags;
    }

    private function isDate(string $stringToCheck): bool
    {
        $dateObject = \DateTime::createFromFormat('d.m.Y', $stringToCheck);
        return $dateObject && $dateObject->format('d.m.Y') === $stringToCheck;
    }

    /**
     * ПАРСИТ ФАЙЛ ПО УКАЗАННОМУ ПУТИ, ВОЗВРАЩАЕТ МАССИВ ВИДОВ СПОРТА
     * С СООТВЕТСТВУЮЩИМИ МЕРОПРИЯТИЯМИ
     */
    private function parse(string $url): array
    {
        set_time_limit(300); // Увеличиваем лимит времени выполнения
        ini_set('memory_limit', '-1');

        $parser = new Parser();
        $pdf = $parser->parseFile($url);
        $raw_text = mb_convert_encoding($pdf->getText(), 'UTF-8', 'auto');
        $content = explode("\n", $raw_text);

        $parsed = [];
        $start_index = $this->findStartPosition($content);

        $sport = $this->getEmptySportObject();
        $event = $this->getEmptyEventObject();
        $isMainDivision = true;    // Для отслеживания, основной состав или резервный
        $lastField = "";

        $tagString = "";
        $titleString = "";

        $log = [];

        for ($i = $start_index; $i < count($content); $i++) {

            if ($this->isEventObjectReady($event)) {
                if ($isMainDivision) {
                    $sport['mainDivision'][] = $event;
                } else {
                    $sport['ReserveDivision'][] = $event;
                }
                $event = $this->getEmptyEventObject();
                $log[] = [1, $content[$i], $sport];
            }

            if ($this->isSportTitle($content, $i)) {
                if (!empty($sport['title'])) {
                    $parsed[] = $sport;
                    $sport = $this->getEmptySportObject();
                }
                $sport['title'] = $content[$i];
                $lastField = "title";

                $log[] = [2, $content[$i], $parsed];
            }

            else if ($content[$i] == "Основной состав") {
                $isMainDivision = true;
                $lastField = "division";

                $log[] = [3, $content[$i]];
            }

            else if ($content[$i] == "Молодежный (резервный) состав") {
                $isMainDivision = false;
                $lastField = "division";

                $log[] = [4, $content[$i]];
            }
            
            // Строка с айди и названием соревнования
            else if (($lastField == "amount" || $lastField == "division") && str_contains($content[$i], " ")) {
                $split_string = explode(" ", $content[$i]);
                if ($this->isIdString($split_string[0])) {
                    $event['id'] = trim($split_string[0]);
                    $event['title'] = trim(implode(" ", array_slice($split_string, 1)));
                    $lastField = "id";
                }
                $log[] = [5, $content[$i]];
            }

            // Если название многострочное
            else if ($lastField == "id" && $content[$i] === mb_strtoupper($content[$i])) {
                $event['title'] .= trim($content[$i]);
                $lastField = "id";

                $log[] = [20, $content[$i]];
            }

            // Строка с перечислением пола и возраста
            else if ($lastField == "id") {

                $event['tags'] = array_merge(
                    $event['tags'], 
                    $this->makeSexAndAgeTags($content[$i])
                );
                $lastField = "sex";
                $log[] = [6, $content[$i]];
            }

            // Строка с тегами или продолжением тегов
            else if (($lastField == "sex" || $lastField == "tags") && !$this->isDate($content[$i])) {
                $tagString .= $content[$i];
                $lastField = "tags";
                $log[] = [7, $content[$i]];
            }

            // Строка с датой начала
            else if ($lastField == "tags" && $this->isDate($content[$i])) {
                if (!empty($tagString)) {
                    $event['tags'] = array_merge(
                        $event['tags'],
                        $this->makeTags($tagString)
                    );
                    $tagString = "";
                }
                $event['from_date'] = $content[$i];
                $lastField = "from_date";
                $log[] = [8, $content[$i]];
            }

            // Строка с датой окончания
            else if ($lastField == "from_date" && $this->isDate($content[$i])) {
                $event['to_date'] = $content[$i];
                $lastField = "to_date";
                $log[] = [9, $content[$i]];
            }

            // Строка со страной
            else if ($lastField == "to_date"/* && ctype_upper($content[$i])*/) {
                $event['country'] = mb_convert_case($content[$i], mode: MB_CASE_TITLE, encoding: "UTF-8");
                $lastField = "country";
                $log[] = [10, $content[$i]];
            }

            // Строка с регионом и городом/населенным пунктом
            else if ($lastField == "country" || ($lastField == "region" && !ctype_digit($content[$i]))) {
                $split_string = array_filter(explode(",", $content[$i]));
                if (count($split_string) == 2) {
                    $event['region'] = mb_convert_case(
                        trim($split_string[0]),
                        mode: MB_CASE_TITLE, encoding: "UTF-8"
                    );
                    $event['city'] = mb_convert_case(
                        trim($split_string[1]),
                        mode: MB_CASE_TITLE, encoding: "UTF-8"
                    );
                } else if (count($split_string) == 1) {
                    $event['city'] = mb_convert_case(
                        trim($split_string[0]),
                        mode: MB_CASE_TITLE, encoding: "UTF-8"
                    );
                }
                $lastField = "region";
                $log[] = [11, $content[$i]];
            }

            // Строка с количеством участников
            else if ($lastField == "region" && ctype_digit($content[$i])) {
                $event['amount'] = (int)$content[$i];
                $lastField = "amount";
                $log[] = [12, $content[$i]];
            }
        }

        if (isset($sport)) {
            $parsed[] = $sport;
        }

        return $parsed;

        // return $this->json([
        //     'status' => 'ok',
        //     // 'start' => $start_index,
        //     // 'end' => count($content),
        //     // 'log' => array_slice($log, (int)round(count($log) * 0.95)),
        //     'result' => $parsed,
        //     // 'content' => array_slice($content, (int)count($content) * 0.75),
        // ]);
    }

    // TODO: дописать веб-скрапинг странички, убрать заглушку
    /**
     * Проверяет страницу минспорта и возвращает ссылку на файл который надо распарсить.
     * Если файл не изменился с последней проверки, возвращает пустую строку.
     */
    private function checkFilePathToParse(): string
    {
        // $url = 'file:///C:/Users/pc/Desktop/test-1-44.pdf';
        $url = 'https://storage.minsport.gov.ru/cms-uploads/cms/II_chast_EKP_2024_14_11_24_65c6deea36.pdf';
        // $url = 'https://storage.minsport.gov.ru/cms-uploads/cms/V_Pi_S_Pvs_30_10_2024_na_sajt_5580a63c30.pdf';
        return $url;
    }

    #[Route('/api/parser', name: 'api_parser', methods: ['GET'])]
    public function index(): JsonResponse
    {
        

        return $this->json([
            'success' => true
        ]);
    }
}