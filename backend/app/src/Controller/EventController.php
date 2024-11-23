<?php
namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{

    #[Route('/api/events', name: 'api_events', methods: ['POST'])]
    public function getFilteredEvents(Request $request, EventRepository $eventRepository): JsonResponse
    {
        // Получаем данные фильтров из тела запроса (JSON)
        $data = json_decode($request->getContent(), true);

        // Проверяем, что JSON был корректно декодирован
        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }

        // Извлекаем параметры фильтров или задаем значения по умолчанию
        $filters = [];

        // Фильтр по датам (если заданы start_date и end_date)
        if (isset($data['start_date']) && isset($data['end_date'])) {
            $startDate = new \DateTimeImmutable($data['start_date']);
            $endDate = new \DateTimeImmutable($data['end_date']);
            $filters['date'] = ['start' => $startDate, 'end' => $endDate];
        }

        // Добавляем фильтры по другим параметрам
        if (isset($data['sport'])) {
            $filters['sport'] = $data['sport'];
        }
        if (isset($data['country'])) {
            $filters['country'] = $data['country'];
        }
        if (isset($data['division'])) {
            $filters['division'] = $data['division'];
        }
        if (isset($data['tags'])) {
            $filters['tags'] = $data['tags'];
        }

        // Получаем события с применением фильтров
        $events = $eventRepository->findByFilters($filters);

        // Преобразуем полученные события в массив данных для ответа
        $result = [];
        foreach ($events as $event) {
            $result[] = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'from_date' => $event->getFromDate()->format('Y-m-d H:i:s'),
                'to_date' => $event->getToDate()->format('Y-m-d H:i:s'),
                'sport' => $event->getSport() ? $event->getSport()->getTitle() : null, // Выводим title спорта
                'country' => $event->getCountry() ? $event->getCountry()->getName() : null, // Выводим name страны
                'division' => $event->getDivision() ? $event->getDivision()->getTitle() : null,
// Выводим name дивизиона
                'region' => $event->getRegion() ? $event->getRegion()->getName() : null, // Выводим name региона
                'place' => $event->getPlace() ? $event->getPlace()->getName() : null, // Выводим name места
                'tags' => array_map(fn($tag) => $tag->getValue(), $event->getTags()->toArray())
            ];
        }

        // Возвращаем результат в формате JSON
        return new JsonResponse($result);
    }
}
