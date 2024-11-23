<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Event;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api')]
class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $events_repository = $entityManager->getRepository(Event::class);
        
        $data = [];

        foreach ($events_repository->findAll() as $event) {
            $reg = $event->getRegion();
            if (is_null($reg)) $reg = "";
            else $reg = $reg->getName();
            $tags = [];
            foreach($event->getTags() as $tag) {
                $tags[] = $tag->getValue();
            }
            $data[] = [
                'ekp_id' => $event->getEkpId(),
                'title' => $event->getTitle(),
                'from_date' => $event->getFromDate(),
                'to_date' => $event->getToDate(),
                'amount' => $event->getAmount(),
                'sport' => $event->getSport()->getTitle(),
                'division' => $event->getDivision()->getTitle(),
                'country' => $event->getCountry()->getName(),
                'region' => $reg,
                'place' => $event->getPlace()->getName(),
                'tags' => $tags
            ];
        }

        return $this->json($data);
    }

    #[Route('/sports', name: 'app_sports')]
    public function getSports(EntityManagerInterface $entityManager): JsonResponse
    {
        $sports_repository = $entityManager->getRepository(Sport::class);
        
        $data = [];

        foreach ($sports_repository->findAll() as $sport) {
            $data[] = $sport->getTitle();
        }

        return $this->json([
            'ok' => true,
            'data' => $data
        ]);
    }
}
