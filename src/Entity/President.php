<?php

namespace App\Entity;

use App\Repository\PresidentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresidentRepository::class)
 */
class President
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $Nom;

    /**
     * @ORM\ManyToOne(targetEntity=Election::class, inversedBy="presidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Election;

    /**
     * @ORM\OneToMany(targetEntity=Votant::class, mappedBy="president")
     */
    private $votants;

    public function __construct()
    {
        $this->votants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }
    public function setId(int $Nom): self
    {
        $this->Id = $Nom;

        return $this;
    }

    public function getElection(): ?Election
    {
        return $this->Election;
    }

    public function setElection(?Election $Election): self
    {
        $this->Election = $Election;

        return $this;
    }

    /**
     * @return Collection|Votant[]
     */
    public function getVotants(): Collection
    {
        return $this->votants;
    }

    public function addVotant(Votant $votant): self
    {
        if (!$this->votants->contains($votant)) {
            $this->votants[] = $votant;
            $votant->setPresident($this);
        }

        return $this;
    }

    public function removeVotant(Votant $votant): self
    {
        if ($this->votants->removeElement($votant)) {
            // set the owning side to null (unless already changed)
            if ($votant->getPresident() === $this) {
                $votant->setPresident(null);
            }
        }

        return $this;
    }
}
