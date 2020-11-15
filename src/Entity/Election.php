<?php

namespace App\Entity;

use App\Repository\ElectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElectionRepository::class)
 */
class Election
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $DateElection;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="elections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Pays;

    /**
     * @ORM\OneToMany(targetEntity=President::class, mappedBy="Election")
     */
    private $presidents;

    /**
     * @ORM\OneToMany(targetEntity=Votant::class, mappedBy="Election")
     */
    private $votants;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat;

    public function __construct()
    {
        $this->presidents = new ArrayCollection();
        $this->votants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateElection(): ?\DateTimeInterface
    {
        return $this->DateElection;
    }

    public function setDateElection(\DateTimeInterface $DateElection): self
    {
        $this->DateElection = $DateElection;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->Pays;
    }
    public function StringtoDates(){
        $date2=$this->getDateElection();
        dump($date2);
        $tableau=\explode('.',$date2->date);
        $date = new \DateTime($tableau[0]);
        $result = $date->format('Y-m-d H:i:s');
        return $result;

    }

    public function setPays(?Pays $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    /**
     * @return Collection|President[]
     */
    public function getPresidents(): Collection
    {
        return $this->presidents;
    }

    public function addPresident(President $president): self
    {
        if (!$this->presidents->contains($president)) {
            $this->presidents[] = $president;
            $president->setElection($this);
        }

        return $this;
    }

    public function removePresident(President $president): self
    {
        if ($this->presidents->removeElement($president)) {
            // set the owning side to null (unless already changed)
            if ($president->getElection() === $this) {
                $president->setElection(null);
            }
        }

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
            $votant->setElection($this);
        }

        return $this;
    }

    public function removeVotant(Votant $votant): self
    {
        if ($this->votants->removeElement($votant)) {
            // set the owning side to null (unless already changed)
            if ($votant->getElection() === $this) {
                $votant->setElection(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(?int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
