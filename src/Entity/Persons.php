<?php

namespace App\Entity;

use App\Repository\PersonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PersonsRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"identity"}, message="Cette numéro d'identité est déjà utilisé dans la base de données" )
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
     * @Assert\Length(min=3, max=255, minMessage="Ce champ doit contenir au moins 3 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255, minMessage="Ce champ doit contenir au moins 3 caractères")
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{12}$/")
     */
    private $identity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin_recto;
    /**
     * @var File
     * @Vich\UploadableField(mapping="cin_recto_image", fileNameProperty="cin_recto")
     * @Assert\Image ()
     */
    private $cin_recto_file;

    /**
     * @return File
     */
    public function getCinRectoFile(): ?File
    {
        return $this->cin_recto_file;
    }

    /**
     * @param File $cin_recto_file
     */
    public function setCinRectoFile(File $cin_recto_file): void
    {
        $this->cin_recto_file = $cin_recto_file;
        if ($this->cin_recto_file instanceof  UploadedFile) {
            $this->setUpdatedAt(new  \DateTime());
        }
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin_verso;
    /**
     * @var File
     * @Vich\UploadableField (mapping="cin_verso_image", fileNameProperty="cin_verso")
     * @Assert\Image ()
     */
    private  $cin_verso_file;

    /**
     * @return File
     */
    public function getCinVersoFile(): ?File
    {
        return $this->cin_verso_file;
    }

    /**
     * @param File $cin_verso_file
     */
    public function setCinVersoFile(File $cin_verso_file): void
    {
        $this->cin_verso_file = $cin_verso_file;
        if ($this->cin_verso_file instanceof UploadedFile) {
            $this->setUpdatedAt(new  \DateTime());
        }
    }
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=255, minMessage="Ce champ doit contenir au moins 3 caractères")
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $certificat;
    /**
     * @var File
     * @Vich\UploadableField (mapping="certificat_image", fileNameProperty="certificat")
     * @Assert\Image ()
     */
    private  $certificat_file;

    /**
     * @return File
     */
    public function getCertificatFile(): ?File
    {
        return $this->certificat_file;
    }

    /**
     * @param File $certificat_file
     */
    public function setCertificatFile(File $certificat_file): void
    {
        $this->certificat_file = $certificat_file;
        if ($this->certificat_file instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Regex ("/^[0-9]{10}$/", message="Cette numéro n'est pas valide")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Corporations::class, mappedBy="person")
     */
    private $corporations;


    /**
     * @ORM\OneToMany(targetEntity=Retraits::class, mappedBy="person")
     */
    private $retraits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Depots::class, mappedBy="persons")
     */
    private $depots;


    public function __construct()
    {
        $this->corporations = new ArrayCollection();
        $this->retraits = new ArrayCollection();
        $this->depots = new ArrayCollection();
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
            $depot->setPersons($this);
        }

        return $this;
    }

    public function removeDepot(Depots $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getPersons() === $this) {
                $depot->setPersons(null);
            }
        }

        return $this;
    }
}
