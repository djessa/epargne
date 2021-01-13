<?php

namespace App\Entity;

use App\Repository\RatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatesRepository::class)
 */
class Rates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $month;

    /**
     * @ORM\Column(type="float")
     */
    private $value_of_one;

    /**
     * @ORM\Column(type="float")
     */
    private $value_of_two;

    /**
     * @ORM\Column(type="float")
     */
    private $value_of_three;

    /**
     * @ORM\OneToMany(targetEntity=Funds::class, mappedBy="rate")
     */
    private $funds;

    public function __construct()
    {
        $this->funds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getValueOfOne(): ?float
    {
        return $this->value_of_one;
    }

    public function setValueOfOne(float $value_of_one): self
    {
        $this->value_of_one = $value_of_one;

        return $this;
    }

    public function getValueOfTwo(): ?float
    {
        return $this->value_of_two;
    }

    public function setValueOfTwo(float $value_of_two): self
    {
        $this->value_of_two = $value_of_two;

        return $this;
    }

    public function getValueOfThree(): ?float
    {
        return $this->value_of_three;
    }

    public function setValueOfThree(float $value_of_three): self
    {
        $this->value_of_three = $value_of_three;

        return $this;
    }

    /**
     * @return Collection|Funds[]
     */
    public function getFunds(): Collection
    {
        return $this->funds;
    }

    public function addFund(Funds $fund): self
    {
        if (!$this->funds->contains($fund)) {
            $this->funds[] = $fund;
            $fund->setRate($this);
        }

        return $this;
    }

    public function removeFund(Funds $fund): self
    {
        if ($this->funds->removeElement($fund)) {
            // set the owning side to null (unless already changed)
            if ($fund->getRate() === $this) {
                $fund->setRate(null);
            }
        }

        return $this;
    }
}
