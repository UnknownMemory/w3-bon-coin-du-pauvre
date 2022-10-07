<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\ManyToOne(inversedBy: 'idImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonces $idAnnonces = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getIdAnnonces(): ?Annonces
    {
        return $this->idAnnonces;
    }

    public function setIdAnnonces(?Annonces $idAnnonces): self
    {
        $this->idAnnonces = $idAnnonces;

        return $this;
    }
}
