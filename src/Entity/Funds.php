<?php

namespace App\Entity;

use App\Repository\FundsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FundsRepository::class)
 */
class Funds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $piece_obtaining;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity=Rates::class, inversedBy="funds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rate;

    /**
     * @ORM\OneToOne(targetEntity=Depots::class, mappedBy="fund", cascade={"persist", "remove"})
     */
    private $depots;

    /**
     * @ORM\OneToOne(targetEntity=Retraits::class, mappedBy="fund", cascade={"persist", "remove"})
     */
    private $retraits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPieceObtaining(): ?string
    {
        return $this->piece_obtaining;
    }

    public function setPieceObtaining(string $piece_obtaining): self
    {
        $this->piece_obtaining = $piece_obtaining;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRate(): ?Rates
    {
        return $this->rate;
    }

    public function setRate(?Rates $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDepots(): ?Depots
    {
        return $this->depots;
    }

    public function setDepots(Depots $depots): self
    {
        $this->depots = $depots;

        // set the owning side of the relation if necessary
        if ($depots->getFund() !== $this) {
            $depots->setFund($this);
        }

        return $this;
    }

    public function getRetraits(): ?Retraits
    {
        return $this->retraits;
    }

    public function setRetraits(Retraits $retraits): self
    {
        $this->retraits = $retraits;

        // set the owning side of the relation if necessary
        if ($retraits->getFund() !== $this) {
            $retraits->setFund($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
