<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups("user:read")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    // Геттер для поля id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Геттер для поля email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    // Сеттер для поля email
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    // Геттер для поля password (требуется PasswordAuthenticatedUserInterface)
    public function getPassword(): ?string
    {
        return $this->password;
    }

    // Сеттер для поля password
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    // Реализация метода getRoles из UserInterface
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Гарантируем, что ROLE_USER всегда присутствует
        return array_unique($roles);
    }

    // Сеттер для поля roles
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    // Реализация метода getUserIdentifier из UserInterface
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    // Реализация метода getSalt из UserInterface (не используется)
    public function getSalt(): ?string
    {
        return null;
    }

    // Реализация метода eraseCredentials из UserInterface
    public function eraseCredentials(): void
    {
        // Удалите временные данные, если они есть
    }
}
