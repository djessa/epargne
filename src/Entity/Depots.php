<?php

namespace App\Entity;

use App\Repository\DepotsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepotsRepository::class)
 */
class Depots
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity=Persons::class, inversedBy="depots")
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity=Funds::class, inversedBy="depots", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fund;

    /**
     * @ORM\ManyToOne(targetEntity=Corporations::class, inversedBy="depots")
     */
    private $corporation;


    public function __construct()
    {
        $this->person = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Persons[]
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Persons $person): self
    {
        if (!$this->person->contains($person)) {
            $this->person[] = $person;
        }

        return $this;
    }

    public function removePerson(Persons $person): self
    {
        $this->person->removeElement($person);

        return $this;
    }

    public function getFund(): ?Funds
    {
        return $this->fund;
    }

    public function setFund(Funds $fund): self
    {
        $this->fund = $fund;

        return $this;
    }

    public function getCorporation(): ?Corporations
    {
        return $this->corporation;
    }

    public function setCorporation(?Corporations $corporation): self
    {
        $this->corporation = $corporation;

        return $this;
    }
    
}
