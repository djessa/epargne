<?php

namespace App\Entity;

use App\Repository\RetraitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetraitsRepository::class)
 */
class Retraits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Persons::class, inversedBy="retraits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;
    /**
     * @ORM\OneToOne(targetEntity=Funds::class, inversedBy="retraits", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fund;

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

    public function getPerson(): ?Persons
    {
        return $this->person;
    }

    public function setPerson(?Persons $person): self
    {
        $this->person = $person;

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
}
