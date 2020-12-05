<?php

namespace App\Entity;

use App\Repository\CorporationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=CorporationsRepository::class)
 * @Vich\Uploadable
 */
class Corporations
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
    private $social_reason;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $piece_person;
    /**
     * @var File
     * @Vich\UploadableField (mapping="piece_person_image", fileNameProperty="piece_person")
     */
    private $piece_person_file;

    /**
     * @return File
     */
    public function getPiecePersonFile(): ?File
    {
        return $this->piece_person_file;
    }

    /**
     * @param File $piece_person_file
     */
    public function setPiecePersonFile(File $piece_person_file): void
    {
        $this->piece_person_file = $piece_person_file;
        if ($this->piece_person_file instanceof UploadedFile){
            $this->setUpdatedAt(new \DateTime());
        }
    }
    /**
     * @ORM\ManyToOne(targetEntity=Persons::class, inversedBy="corporations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;


    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Depots::class, mappedBy="corporations")
     */
    private $depots;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialReason(): ?string
    {
        return $this->social_reason;
    }

    public function setSocialReason(string $social_reason): self
    {
        $this->social_reason = $social_reason;

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

    public function getPiecePerson(): ?string
    {
        return $this->piece_person;
    }

    public function setPiecePerson(string $piece_person): self
    {
        $this->piece_person = $piece_person;

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


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            $depot->setCorporations($this);
        }

        return $this;
    }

    public function removeDepot(Depots $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCorporations() === $this) {
                $depot->setCorporations(null);
            }
        }

        return $this;
    }
}
