<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Annonces::class, mappedBy: 'idTags')]
    private Collection $idAnnonces;

    public function __construct()
    {
        $this->idAnnonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Annonces>
     */
    public function getIdAnnonces(): Collection
    {
        return $this->idAnnonces;
    }

    public function addIdAnnonce(Annonces $idAnnonce): self
    {
        if (!$this->idAnnonces->contains($idAnnonce)) {
            $this->idAnnonces->add($idAnnonce);
            $idAnnonce->addIdTag($this);
        }

        return $this;
    }

    public function removeIdAnnonce(Annonces $idAnnonce): self
    {
        if ($this->idAnnonces->removeElement($idAnnonce)) {
            $idAnnonce->removeIdTag($this);
        }

        return $this;
    }
}
