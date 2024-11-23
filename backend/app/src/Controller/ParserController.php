<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Smalot\PdfParser\Parser;
use App\Entity\Country;
use App\Entity\Division;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Region;
use App\Entity\Sport;
use App\Entity\Tag;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

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
            "reserveDivision" => []
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
    private function parse(string $url)
    {
        set_time_limit(300); // Увеличиваем лимит времени выполнения
        ini_set('memory_limit', '-1');

        $opt=array(
            "ssl" => array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );


        $response = file_get_contents($url, 
        // use_include_path: false,
        context: stream_context_create($opt));

        if ($response === false) {
            return [];
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'pdf'); // без этого падает и ругается
        file_put_contents($tempFile, $response);

        $parser = new Parser();
        // $pdf = $parser->parseFile($url);
        $pdf = $parser->parseFile($tempFile);

        unlink($tempFile);

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
                    $sport['reserveDivision'][] = $event;
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
        // $url = 'file:///home/anatoly/Загрузки/Telegram Desktop/test-1-44.pdf';
        // $url = '/home/anatoly/hah/pp_50308_tsfo_lip_notfive_lipetskaya_oblast_58/test-1-44.pdf';
        $url = 'https://storage.minsport.gov.ru/cms-uploads/cms/II_chast_EKP_2024_14_11_24_65c6deea36.pdf';
        return $url;
    }

    #[Route('/api/parser', name: 'app_parser')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $urlToParse = $this->checkFilePathToParse();

        // отрабатывает не меньше минуты и требует выделения дополнительной памяти
        $parsed = $this->parse($urlToParse);

        // return $this->json(['ok'=>$parsed]);

        // сразу проходим по составам, они нам известны
        $division_titles = ['Основной состав', 'Молодежный (резервный) состав'];
        $division_repository = $entityManager->getRepository(Division::class);
        foreach($division_titles as $div) {
            if (!$division_repository->findOneBy(['title' => $div])) {
                $division = new Division();
                $division->setTitle($div);
                $entityManager->persist($division);
            }
        }

        // первый проход - заполняем все таблицы кроме соревнований
        // обеспечит наличие всех нужных записей для создания записей соревнований
        $sport_repository = $entityManager->getRepository(Sport::class);
        $tag_repository = $entityManager->getRepository(Tag::class);
        $country_repository = $entityManager->getRepository(Country::class);
        $region_repository = $entityManager->getRepository(Region::class);
        $place_repository = $entityManager->getRepository(Place::class);    // поле city в парсере

        $countries = [];
        $tags = [];
        $regions = [];
        $places = [];

        // return $this->json(['ok'=>true]);
        foreach($parsed as $sport_obj) {
            if ($sport_repository->findOneBy(['title' => trim($sport_obj['title'])]) === null) {
                $sport = new Sport();
                $sport->setTitle(trim($sport_obj['title']));
                $entityManager->persist($sport);
            }
            if (!empty($sport_obj['mainDivision'])) {
                foreach($sport_obj['mainDivision'] as $comp) {
                    if ($country_repository->findOneBy(['name' => trim($comp['country'])]) === null) {
                        $country = new Country();
                        $country->setName(trim($comp['country']));
                        $entityManager->persist($country);
                    }
                    if (!empty($comp['region']) && $region_repository->findOneBy(['name' => trim($comp['region'])]) === null) {
                        $region = new Region();
                        $region->setName(trim($comp['region']));
                        $entityManager->persist($region);
                    }
                    if ($place_repository->findOneBy(['name' => trim($comp['city'])]) === null) {
                        $place = new Place();
                        $place->setName(trim($comp['city']));
                        $entityManager->persist($place);
                    }
                    foreach($comp['tags'] as $tag_item) {
                        if ($tag_repository->findOneBy(['value' => trim($tag_item)]) === null) {
                            if (strlen(trim($tag_item)) < 255) {
                                $tag = new Tag();
                                $tag->setValue(trim($tag_item));
                                $entityManager->persist($tag);
                            }
                        }
                    }
                }
            }
            // if (!empty($sport_obj['reserveDivision'])) {
            //     foreach($sport_obj['reserveDivision'] as $comp) {
            //         if ($country_repository->findOneBy(['name' => trim($comp['country'])]) === null) {
            //             $country = new Country();
            //             $country->setName(trim($comp['country']));
            //             $entityManager->persist($country);
            //         }
            //         if (!empty($comp['region']) && $region_repository->findOneBy(['name' => trim($comp['region'])]) === null) {
            //             $region = new Region();
            //             $region->setName(trim($comp['region']));
            //             $entityManager->persist($region);
            //         }
            //         if ($place_repository->findOneBy(['name' => trim($comp['city'])]) === null) {
            //             $place = new Place();
            //             $place->setName(trim($comp['city']));
            //             $entityManager->persist($place);
            //         }
            //         foreach($comp['tags'] as $tag_item) {
            //             if ($tag_repository->findOneBy(['value' => trim($tag_item)]) === null) {
            //                 if (strlen(trim($tag_item)) < 255) {
            //                     $tag = new Tag();
            //                     $tag->setValue(trim($tag_item));
            //                     $entityManager->persist($tag);
            //                 }
            //             }
            //         }
            //     }
            // }
        }
        $entityManager->flush();
        return $this->json(['ok'=>true]);
        // $cnt = 0;
        // второй проход - заполняем/обновляем соревнования
        $event_repository = $entityManager->getRepository(Event::class);
        foreach($parsed as $sport_obj) {
            $sport = $sport_repository->findOneBy(['title' => trim($sport_obj['title'])]);
            if (!empty($sport_obj['mainDivision'])) {
                foreach($sport_obj['mainDivision'] as $comp) {
                    // $cnt++;
                    $event = $event_repository->findOneBy(['ekp_id' => trim($comp['id'])]);
                    
                    if (is_null($event)) {
                        $event = new Event();
                        $event->setEkpId(trim($comp['id']));
                    }

                    $event->setSport($sport);
                    $event->setDivision($division_repository->findOneBy(['title' => 'Основной состав']));
                    $event->setTitle(trim($comp['title']));
                    $event->setFromDate(DateTimeImmutable::createFromFormat('d.m.Y', trim($comp['from_date'])));
                    $event->setToDate(DateTimeImmutable::createFromFormat('d.m.Y', trim($comp['to_date'])));
                    $event->setAmount($comp['amount']);

                    $country = $country_repository->findOneBy(['name' => trim($comp['country'])]);
                    $region = $region_repository->findOneBy(['name' => trim($comp['region'])]); // м.б. null
                    $place = $place_repository->findOneBy(['name' => trim($comp['city'])]);

                    $event->setCountry($country);
                    $event->setRegion($region);
                    $event->setPlace($place);

                    while (!$event->getTags()->isEmpty()) {
                        $tag = $event->getTags()->first();
                        $event->removeTag($tag);
                    }
                    foreach($comp['tags'] as $tag_item) {
                        $tag = $tag_repository->findOneBy(['value' => trim($tag_item)]);
                        if (!is_null($tag)) {
                            $event->addTag($tag);
                        }
                    }

                    $entityManager->persist($event);

                    // if ($cnt > 3) {
                    //     $entityManager->flush();
                    //     return $this->json(['ok' => true]);
                    // }
                }
            }
            if (!empty($sport_obj['reserveDivision'])) {
                foreach($sport_obj['reserveDivision'] as $comp) {
                    $event = $event_repository->findOneBy(['ekp_id' => trim($comp['id'])]);
                    
                    if (is_null($event)) {
                        $event = new Event();
                        $event->setEkpId(trim($comp['id']));
                    }

                    $event->setSport($sport);
                    $event->setDivision($division_repository->findOneBy(['title' => 'Молодежный (резервный) состав']));
                    $event->setTitle(trim($comp['title']));
                    $event->setFromDate(DateTimeImmutable::createFromFormat('d.m.Y', trim($comp['from_date'])));
                    $event->setToDate(DateTimeImmutable::createFromFormat('d.m.Y', trim($comp['to_date'])));
                    $event->setAmount($comp['amount']);

                    $country = $country_repository->findOneBy(['name' => trim($comp['country'])]);
                    $region = $region_repository->findOneBy(['name' => trim($comp['region'])]); // м.б. null
                    $place = $place_repository->findOneBy(['name' => trim($comp['city'])]);

                    $event->setCountry($country);
                    $event->setRegion($region);
                    $event->setPlace($place);

                    while (!$event->getTags()->isEmpty()) {
                        $tag = $event->getTags()->first();
                        $event->removeTag($tag);
                    }
                    foreach($comp['tags'] as $tag_item) {
                        $tag = $tag_repository->findOneBy(['value' => trim($tag_item)]);
                        if (!is_null($tag)) {
                            $event->addTag($tag);
                        }
                    }

                    $entityManager->persist($event);
                }
            }
        }

        $entityManager->flush();    // сохранение всех изменений в бд

        return $this->json([
            'success' => true
        ]);
    }
}