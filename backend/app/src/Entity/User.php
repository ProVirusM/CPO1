<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("user:read")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups("user:read")]
    private ?string $password = null;

    // Геттер для поля id (аннотация @Groups здесь не обязательна, если она уже указана над свойством)
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
    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // Геттер для поля password
    public function getPassword(): ?string
    {
        return $this->password;
    }

    // Сеттер для поля password
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
}
