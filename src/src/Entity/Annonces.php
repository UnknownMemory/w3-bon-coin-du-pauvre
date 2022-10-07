<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'idAnnonces', targetEntity: Images::class, orphanRemoval: true)]
    private Collection $idImages;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'idAnnonces')]
    private Collection $idTags;

    #[ORM\ManyToOne(inversedBy: 'idAnnonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUsers = null;

    #[ORM\OneToMany(mappedBy: 'idAnnonces', targetEntity: Commentaires::class, orphanRemoval: true)]
    private Collection $idCommentaires;

    public function __construct()
    {
        $this->idImages = new ArrayCollection();
        $this->idTags = new ArrayCollection();
        $this->idCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getIdImages(): Collection
    {
        return $this->idImages;
    }

    public function addIdImage(Images $idImage): self
    {
        if (!$this->idImages->contains($idImage)) {
            $this->idImages->add($idImage);
            $idImage->setIdAnnonces($this);
        }

        return $this;
    }

    public function removeIdImage(Images $idImage): self
    {
        if ($this->idImages->removeElement($idImage)) {
            // set the owning side to null (unless already changed)
            if ($idImage->getIdAnnonces() === $this) {
                $idImage->setIdAnnonces(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getIdTags(): Collection
    {
        return $this->idTags;
    }

    public function addIdTag(Tags $idTag): self
    {
        if (!$this->idTags->contains($idTag)) {
            $this->idTags->add($idTag);
        }

        return $this;
    }

    public function removeIdTag(Tags $idTag): self
    {
        $this->idTags->removeElement($idTag);

        return $this;
    }

    public function getIdUsers(): ?User
    {
        return $this->idUsers;
    }

    public function setIdUsers(?User $idUsers): self
    {
        $this->idUsers = $idUsers;

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getIdCommentaires(): Collection
    {
        return $this->idCommentaires;
    }

    public function addIdCommentaire(Commentaires $idCommentaire): self
    {
        if (!$this->idCommentaires->contains($idCommentaire)) {
            $this->idCommentaires->add($idCommentaire);
            $idCommentaire->setIdAnnonces($this);
        }

        return $this;
    }

    public function removeIdCommentaire(Commentaires $idCommentaire): self
    {
        if ($this->idCommentaires->removeElement($idCommentaire)) {
            // set the owning side to null (unless already changed)
            /*   if ($idCommentaire->getIdAnnonces() === $this) {
                $idCommentaire->setIdAnnonces(null);
            } */
        }

        return $this;
    }
}
