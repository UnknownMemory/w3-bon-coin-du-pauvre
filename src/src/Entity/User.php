<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'idUsers', targetEntity: Annonces::class, orphanRemoval: true)]
    private Collection $idAnnonces;

    #[ORM\OneToOne(inversedBy: 'idUser', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Votes $idVotes = null;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: Commentaires::class, orphanRemoval: true)]
    private Collection $idCommentaires;

    public function __construct()
    {
        $this->idAnnonces = new ArrayCollection();
        $this->idCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
            $idAnnonce->setIdUsers($this);
        }

        return $this;
    }

    public function removeIdAnnonce(Annonces $idAnnonce): self
    {
        if ($this->idAnnonces->removeElement($idAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($idAnnonce->getIdUsers() === $this) {
                $idAnnonce->setIdUsers(null);
            }
        }

        return $this;
    }

    public function getIdVotes(): ?Votes
    {
        return $this->idVotes;
    }

    public function setIdVotes(Votes $idVotes): self
    {
        $this->idVotes = $idVotes;

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
            $idCommentaire->setIdUser($this);
        }

        return $this;
    }

    public function removeIdCommentaire(Commentaires $idCommentaire): self
    {
        if ($this->idCommentaires->removeElement($idCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($idCommentaire->getIdUser() === $this) {
                $idCommentaire->setIdUser(null);
            }
        }

        return $this;
    }
}
