<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
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
    public $name_classe;

    /**
     * @ORM\OneToMany(targetEntity=Etudient::class, mappedBy="classe")
     */
    private $etudients;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="classes")
     */
    private $departments;

   
    /**
     * @ORM\OneToMany(targetEntity=Matiere::class, mappedBy="classe")
     */
    private $matieres;

    /**
     * @ORM\ManyToMany(targetEntity=Professeur::class, mappedBy="classes")
     */
    private $professeurs;

   
    public function __construct()
    {
        $this->etudients = new ArrayCollection();
       
        $this->matieres = new ArrayCollection();
        $this->professeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameClasse(): ?string
    {
        return $this->name_classe;
    }

    public function setNameClasse(string $name_classe): self
    {
        $this->name_classe = $name_classe;

        return $this;
    }

    /**
     * @return Collection|Etudient[]
     */
    public function getEtudients(): Collection
    {
        return $this->etudients;
    }

    public function addEtudient(Etudient $etudient): self
    {
        if (!$this->etudients->contains($etudient)) {
            $this->etudients[] = $etudient;
            $etudient->setClasse($this);
        }

        return $this;
    }

    public function removeEtudient(Etudient $etudient): self
    {
        if ($this->etudients->removeElement($etudient)) {
            // set the owning side to null (unless already changed)
            if ($etudient->getClasse() === $this) {
                $etudient->setClasse(null);
            }
        }

        return $this;
    }

    public function getDepartments(): ?Departement
    {
        return $this->departments;
    }

    public function setDepartments(?Departement $departments): self
    {
        $this->departments = $departments;

        return $this;
    }

    

    /**
     * @return Collection|Matiere[]
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres[] = $matiere;
            $matiere->setClasse($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getClasse() === $this) {
                $matiere->setClasse(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->getNameClasse();
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
            $professeur->addClass($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->removeElement($professeur)) {
            $professeur->removeClass($this);
        }

        return $this;
    }

   
}
