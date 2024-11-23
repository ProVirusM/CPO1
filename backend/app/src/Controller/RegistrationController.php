<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        // Получаем данные из запроса
        $data = json_decode($request->getContent(), true);

        // Валидируем входящие данные
        if (!isset($data['email'], $data['password'])) {
            return $this->json(['error' => 'Email and password are required'], 400);
        }

        // Создаем нового пользователя
        $user = new User();
        $user->setEmail($data['email']);

        // Хэшируем пароль
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Устанавливаем роль по умолчанию
        $user->setRoles(['ROLE_USER']);

        // Сохраняем пользователя в базе данных
        $entityManager->persist($user);
        $entityManager->flush();

        // Возвращаем успешный ответ
        return $this->json(['message' => 'User successfully registered'], 201);
    }
}
