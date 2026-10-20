<?php

namespace App\Entity;

use Symfony\Component\Serializer\Attribute\Groups;
use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['livre:lecture'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre:lecture'])]
    private ?string $titre = null;

    #[ORM\Column(length: 13)]
    #[Groups(['livre:lecture'])]
    private ?string $isbn = null;

    #[ORM\Column]
    #[Groups(['livre:lecture'])]
    private ?int $anneePublication = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['livre:lecture'])]
    private ?string $resume = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['livre:lecture'])]
    private ?auteur $auteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAnneePublication(): ?int
    {
        return $this->anneePublication;
    }

    public function setAnneePublication(int $anneePublication): static
    {
        $this->anneePublication = $anneePublication;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getAuteur(): ?auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }
}
