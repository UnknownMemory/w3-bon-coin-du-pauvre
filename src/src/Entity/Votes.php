<?php

namespace App\Entity;

use App\Repository\VotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VotesRepository::class)]
class Votes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $aVoter = null;

    #[ORM\OneToOne(mappedBy: 'idVotes', cascade: ['persist', 'remove'])]
    private ?User $idUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAVoter(): ?bool
    {
        return $this->aVoter;
    }

    public function setAVoter(bool $aVoter): self
    {
        $this->aVoter = $aVoter;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(User $idUser): self
    {
        // set the owning side of the relation if necessary
        if ($idUser->getIdVotes() !== $this) {
            $idUser->setIdVotes($this);
        }

        $this->idUser = $idUser;

        return $this;
    }
}
