<?php

namespace App\Controller;

use App\Entity\UserFilter;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user-filter', name: 'api_user_filter_')]
class UserFilterController extends AbstractController
{
    #[Route('/save', name: 'save', methods: ['POST'])]
    public function saveFilter(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['user_id'], $data['filters'])) {
            return $this->json(['error' => 'User ID and Filters are required'], 400);
        }

        $user = $entityManager->getRepository(User::class)->find($data['user_id']);
        if (!$user) {
            return $this->json(['error' => 'Invalid User'], 404);
        }

        // Save the filters
        $userFilter = new UserFilter();
        $userFilter->setUser($user);
        $userFilter->setFilters($data['filters']);

        $entityManager->persist($userFilter);
        $entityManager->flush();

        return $this->json(['message' => 'Filters successfully saved']);
    }

    #[Route('/get-filters', name: 'get_filters', methods: ['POST'])]
    public function getFilters(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['user_id'])) {
            return $this->json(['error' => 'User ID is required'], 400);
        }

        $userId = $data['user_id'];
        $filters = $entityManager->getRepository(UserFilter::class)->findBy(['user' => $userId]);

        $response = [];
        foreach ($filters as $filter) {
            $response[] = [
                'id' => $filter->getId(),
                'filters' => $filter->getFilters(),
            ];
        }

        return $this->json($response);
    }

}

