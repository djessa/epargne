<?php

namespace App\Entity;

use App\Repository\PersonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonsRepository::class)
 */
class Persons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin_recto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin_verso;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $certificat;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Corporations::class, mappedBy="person")
     */
    private $corporations;

    /**
     * @ORM\ManyToMany(targetEntity=Depots::class, mappedBy="person")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity=Retraits::class, mappedBy="person")
     */
    private $retraits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __construct()
    {
        $this->corporations = new ArrayCollection();
        $this->depots = new ArrayCollection();
        $this->retraits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getCinRecto(): ?string
    {
        return $this->cin_recto;
    }

    public function setCinRecto(string $cin_recto): self
    {
        $this->cin_recto = $cin_recto;

        return $this;
    }

    public function getCinVerso(): ?string
    {
        return $this->cin_verso;
    }

    public function setCinVerso(string $cin_verso): self
    {
        $this->cin_verso = $cin_verso;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCertificat(): ?string
    {
        return $this->certificat;
    }

    public function setCertificat(string $certificat): self
    {
        $this->certificat = $certificat;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Corporations[]
     */
    public function getCorporations(): Collection
    {
        return $this->corporations;
    }

    public function addCorporation(Corporations $corporation): self
    {
        if (!$this->corporations->contains($corporation)) {
            $this->corporations[] = $corporation;
            $corporation->setPerson($this);
        }

        return $this;
    }

    public function removeCorporation(Corporations $corporation): self
    {
        if ($this->corporations->removeElement($corporation)) {
            // set the owning side to null (unless already changed)
            if ($corporation->getPerson() === $this) {
                $corporation->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depots[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depots $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->addPerson($this);
        }

        return $this;
    }

    public function removeDepot(Depots $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            $depot->removePerson($this);
        }

        return $this;
    }

    /**
     * @return Collection|Retraits[]
     */
    public function getRetraits(): Collection
    {
        return $this->retraits;
    }

    public function addRetrait(Retraits $retrait): self
    {
        if (!$this->retraits->contains($retrait)) {
            $this->retraits[] = $retrait;
            $retrait->setPerson($this);
        }

        return $this;
    }

    public function removeRetrait(Retraits $retrait): self
    {
        if ($this->retraits->removeElement($retrait)) {
            // set the owning side to null (unless already changed)
            if ($retrait->getPerson() === $this) {
                $retrait->setPerson(null);
            }
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
