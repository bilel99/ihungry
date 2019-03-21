<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var array
     * @ORM\OneToOne(targetEntity="Restaurant", mappedBy="ville"))
     */
    private $restaurant;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $departement_code;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $insee;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codex;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaphone;

    /**
     * @var Pays
     * @ORM\OneToOne(targetEntity="App\Entity\Pays", inversedBy="ville")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="id", nullable=true)
     */
    private $pays_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartementCode(): ?string
    {
        return $this->departement_code;
    }

    public function setDepartementCode(string $departement_code): self
    {
        $this->departement_code = $departement_code;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getInsee(): ?string
    {
        return $this->insee;
    }

    public function setInsee(string $insee): self
    {
        $this->insee = $insee;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCodex(): ?string
    {
        return $this->codex;
    }

    public function setCodex(?string $codex): self
    {
        $this->codex = $codex;

        return $this;
    }

    public function getMetaphone(): ?string
    {
        return $this->metaphone;
    }

    public function setMetaphone(?string $metaphone): self
    {
        $this->metaphone = $metaphone;

        return $this;
    }

    public function getPaysId(): ?Pays
    {
        return $this->pays_id;
    }

    public function setPaysId(?Pays $pays_id): self
    {
        $this->pays_id = $pays_id;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        // set (or unset) the owning side of the relation if necessary
        $newVille = $restaurant === null ? null : $this;
        if ($newVille !== $restaurant->getVille()) {
            $restaurant->setVille($newVille);
        }

        return $this;
    }
}
