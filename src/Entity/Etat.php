<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
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
    private $Reference;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrevoie;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="etats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=Votant::class, mappedBy="Etat")
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

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getNbrevoie(): ?int
    {
        return $this->nbrevoie;
    }

    public function setNbrevoie(int $nbrevoie): self
    {
        $this->nbrevoie = $nbrevoie;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }
    public function setNombre($taille): self
    {
        if($taille > $this->getNbrevoie() || $taille < $this->getNbrevoie() ){
            throw new \Exception("Nombre de voie Anormale");
        }
    
        return $this;

    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

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
            $votant->setEtat($this);
        }

        return $this;
    }

    public function removeVotant(Votant $votant): self
    {
        if ($this->votants->removeElement($votant)) {
            // set the owning side to null (unless already changed)
            if ($votant->getEtat() === $this) {
                $votant->setEtat(null);
            }
        }

        return $this;
    }
}
