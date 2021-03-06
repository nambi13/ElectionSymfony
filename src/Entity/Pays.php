<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 * @UniqueEntity(
 *     fields={"nompays"},
 *     errorPath="nompays",
 *     message="Pays deja existant."
 * )
 */
class Pays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Regex(
     * pattern="/^[A-Z]{1}[a-z]{1,}/",
     * message="les Lettres doit commencer par Majuscule et pas de chiffre"
     * )
     * @ORM\Column(type="string", length=40)
     */
    private $nompays;

    /**
     * @ORM\OneToMany(targetEntity=Election::class, mappedBy="Pays", orphanRemoval=true)
     */
    private $elections;

    /**
     * @ORM\OneToMany(targetEntity=Etat::class, mappedBy="pays")
     */
    private $etats;

    public function __construct()
    {
        $this->elections = new ArrayCollection();
        $this->etats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNompays(): ?string
    {
        return $this->nompays;
    }

    public function setNompays(string $nompays): self
    {
        if($nompays=="0"){
            throw new \Exception("Nom Pays_Anormale");

        }
        $this->nompays = $nompays;

        return $this;
    }

    /**
     * @return Collection|Election[]
     */
    public function getElections(): Collection
    {
        return $this->elections;
    }

    public function addElection(Election $election): self
    {
        if (!$this->elections->contains($election)) {
            $this->elections[] = $election;
            $election->setPays($this);
        }

        return $this;
    }

    public function removeElection(Election $election): self
    {
        if ($this->elections->removeElement($election)) {
            // set the owning side to null (unless already changed)
            if ($election->getPays() === $this) {
                $election->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etat[]
     */
    public function getEtats(): Collection
    {
        return $this->etats;
    }

    public function addEtat(Etat $etat): self
    {
        if (!$this->etats->contains($etat)) {
            $this->etats[] = $etat;
            $etat->setPays($this);
        }

        return $this;
    }

    public function removeEtat(Etat $etat): self
    {
        if ($this->etats->removeElement($etat)) {
            // set the owning side to null (unless already changed)
            if ($etat->getPays() === $this) {
                $etat->setPays(null);
            }
        }

        return $this;
    }
}
