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
     * @ORM\OneToOne(targetEntity=Funds::class, inversedBy="depots", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fund;

    /**
     * @ORM\ManyToOne(targetEntity=Persons::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $persons;

    /**
     * @ORM\ManyToOne(targetEntity=Corporations::class, inversedBy="depots")
     */
    private $corporations;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_retired;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getPersons(): ?Persons
    {
        return $this->persons;
    }

    public function setPersons(?Persons $persons): self
    {
        $this->persons = $persons;

        return $this;
    }

    public function getCorporations(): ?Corporations
    {
        return $this->corporations;
    }

    public function setCorporations(?Corporations $corporations): self
    {
        $this->corporations = $corporations;

        return $this;
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
    public function  taux()
    {
        $funds = $this->getFund();
        $taux = $funds->getRate();
        if ($funds->getDuration() == 1)
            return  $taux->getValueOfOne();
        if ($funds->getDuration() == 2)
            return  $taux->getValueOfTwo();
        return $taux->getValueOfThree();
    }
    public function  capitaux()
    {
        $funds = $this->getFund();
        $taux = $funds->getRate();
        if ($funds->getDuration() == 1)
            return  $funds->getValue() + ($funds->getValue() * $taux->getValueOfOne()) / 100;
        if ($funds->getDuration() == 2)
            return  $funds->getValue() + ($funds->getValue() * $taux->getValueOfTwo()) / 100;
        return  $funds->getValue() + ($funds->getValue() * $taux->getValueOfThree()) / 100;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getIsRetired(): ?bool
    {
        return $this->is_retired;
    }

    public function setIsRetired(?bool $is_retired): self
    {
        $this->is_retired = $is_retired;

        return $this;
    }
}
