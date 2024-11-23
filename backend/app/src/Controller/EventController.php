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
        $startDate = isset($data['start_date']) ? new \DateTimeImmutable($data['start_date']) : new \DateTimeImmutable('-30 days');
        $endDate = isset($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : new \DateTimeImmutable('now');
        $sportId = isset($data['sport']) ? $data['sport'] : null; // null будет означать "без фильтра по спорту"
        $countryId = isset($data['country']) ? $data['country'] : null; // если не передан, фильтровать по всем странам
        $divisionId = isset($data['division']) ? $data['division'] : null; // если не передан, фильтровать по всем дивизионам
        $tags = isset($data['tags']) ? $data['tags'] : []; // если не передан, фильтровать по всем тегам

        // Применяем фильтры (если параметр не передан, не добавляем фильтр по нему)
        $filters = [];
        if ($sportId) {
            $filters['sport'] = $sportId;
        }
        if ($countryId) {
            $filters['country'] = $countryId;
        }
        if ($divisionId) {
            $filters['division'] = $divisionId;
        }
        if ($tags) {
            $filters['tags'] = $tags;
        }

        // Получаем события с применением фильтров
        $events = $eventRepository->findByDateRange($startDate, $endDate, $filters);

        // Преобразуем полученные события в массив данных для ответа
        $result = [];
        foreach ($events as $event) {
            $result[] = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'start_date' => $event->getStartDate()->format('Y-m-d H:i:s'),
                'end_date' => $event->getEndDate()->format('Y-m-d H:i:s'),
                'sport' => $event->getSport() ? $event->getSport()->getTitle() : null,
                'country' => $event->getCountry() ? $event->getCountry()->getName() : null,
                'division' => $event->getDivision() ? $event->getDivision()->getName() : null,
                'tags' => array_map(fn($tag) => $tag->getValue(), $event->getTags()->toArray())
            ];
        }

        // Возвращаем результат в формате JSON
        return new JsonResponse($result);
    }
}
