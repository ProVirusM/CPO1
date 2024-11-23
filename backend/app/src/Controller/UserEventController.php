<?php


namespace App\Controller;

use App\Entity\UserEvent;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user-event', name: 'user_event_')]
class UserEventController extends AbstractController
{
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function addUserEvent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['user_id'], $data['event_id'])) {
            return $this->json(['error' => 'User ID and Event ID are required'], 400);
        }

        $user = $entityManager->getRepository(User::class)->find($data['user_id']);
        $event = $entityManager->getRepository(Event::class)->find($data['event_id']);

        if (!$user || !$event) {
            return $this->json(['error' => 'Invalid User or Event'], 404);
        }

        // Create UserEvent entry
        $userEvent = new UserEvent();
        $userEvent->setUser($user);
        $userEvent->setEvent($event);

        $entityManager->persist($userEvent);
        $entityManager->flush();

        return $this->json(['message' => 'User successfully linked to Event']);
    }

    #[Route('/get', name: 'get_user_events', methods: ['POST'])]
    public function getUserEvents(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['user_id'])) {
            return $this->json(['error' => 'User ID is required'], 400);
        }

        $userId = $data['user_id'];
        $userEvents = $entityManager->getRepository(UserEvent::class)->findBy(['user' => $userId]);

        $events = [];
        foreach ($userEvents as $userEvent) {
            $event = $userEvent->getEvent();
            $events[] = [
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

        return $this->json($events);
    }

}
