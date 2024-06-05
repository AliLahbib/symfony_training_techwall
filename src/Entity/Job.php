<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $designation = null;


    #[ORM\OneToMany(targetEntity: Person::class, mappedBy: 'job')]
    private Collection $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPerson(Person $person): static
    {
        if (!$this->personnes->contains($person)) {
            $this->personnes->add($person);
            $person->setJob($this);
        }

        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->personnes->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getJob() === $this) {
                $person->setJob(null);
            }
        }

        return $this;
    }


}
