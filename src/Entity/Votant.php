<?php

namespace App\Entity;

use App\Repository\VotantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotantRepository::class)
 */
class Votant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Nombre;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="votants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Etat;

    /**
     * @ORM\ManyToOne(targetEntity=Election::class, inversedBy="votants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Election;

    /**
     * @ORM\ManyToOne(targetEntity=President::class, inversedBy="votants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $president;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->Nombre;
    }

    public function setNombre(?int $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->Etat;
    }

    public function setEtat(?Etat $Etat): self
    {
        $this->Etat = $Etat;

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

    public function getPresident(): ?President
    {
        return $this->president;
    }

    public function setPresident(?President $president): self
    {
        $this->president = $president;

        return $this;
    }
}
