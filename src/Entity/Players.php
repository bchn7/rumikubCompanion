<?php

namespace App\Entity;

use App\Repository\PlayersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayersRepository::class)]
class Players
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $Name = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $Score = 0;  // Initialize Score to 0

    #[ORM\Column(type: 'json', nullable: true)]  // Store as JSON
    private ?array $LastGames = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;
        return $this;
    }

    public function getScore(): ?int
    {
        return $this->Score;
    }

    public function setScore(?int $Score): static
    {
        $this->Score = $Score;
        return $this;
    }

    public function getLastGames(): ?array
    {
        return $this->LastGames;
    }

    public function setLastGames(?array $LastGames): static
    {
        $this->LastGames = $LastGames;
        return $this;
    }
}