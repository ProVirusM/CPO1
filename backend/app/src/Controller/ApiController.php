<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Division;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Region;
use App\Entity\Sport;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/events', name: 'app_events2')]
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
            'len' => count($sports_repository->findAll()),
            'data' => $data
        ]);
    }

    #[Route('/countries', name: 'app_countries')]
    public function getCountries(EntityManagerInterface $entityManager): JsonResponse
    {
        $countries_repository = $entityManager->getRepository(Country::class);
        
        $data = [];

        foreach ($countries_repository->findAll() as $country) {
            $data[] = $country->getName();
        }

        return $this->json([
            'ok' => true,
            'len' => count($countries_repository->findAll()),
            'data' => $data
        ]);
    }

    #[Route('/regions', name: 'app_regions')]
    public function getRegions(EntityManagerInterface $entityManager): JsonResponse
    {
        $regions_repository = $entityManager->getRepository(Region::class);
        
        $data = [];

        foreach ($regions_repository->findAll() as $region) {
            $data[] = $region->getName();
        }

        return $this->json([
            'ok' => true,
            'len' => count($regions_repository->findAll()),
            'data' => $data
        ]);
    }

    #[Route('/places', name: 'app_places')]
    public function getPlaces(EntityManagerInterface $entityManager): JsonResponse
    {
        $places_repository = $entityManager->getRepository(Place::class);
        
        $data = [];

        foreach ($places_repository->findAll() as $place) {
            $data[] = $place->getName();
        }

        return $this->json([
            'ok' => true,
            'len' => count($places_repository->findAll()),
            'data' => $data
        ]);
    }

    #[Route('/divisions', name: 'app_divisions')]
    public function getDivisions(EntityManagerInterface $entityManager): JsonResponse
    {
        $divisions_repository = $entityManager->getRepository(Division::class);
        
        $data = [];

        foreach ($divisions_repository->findAll() as $division) {
            $data[] = $division->getTitle();
        }

        return $this->json([
            'ok' => true,
            'data' => $data
        ]);
    }

    #[Route('/tags', name: 'app_tags')]
    public function getTags(EntityManagerInterface $entityManager): JsonResponse
    {
        $tags_repository = $entityManager->getRepository(Tag::class);
        
        $data = [];

        foreach ($tags_repository->findAll() as $tag) {
            $data[] = $tag->getValue();
        }

        return $this->json([
            'ok' => true,
            'len' => count($tags_repository->findAll()),
            'data' => $data
        ]);
    }
}
