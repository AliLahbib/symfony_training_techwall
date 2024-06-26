<?php

namespace App\Entity;

use App\Repository\HobbyRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HobbyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Hobby

{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $designation = null;

    #[ORM\ManyToMany(targetEntity: Person::class, mappedBy: 'hobbies')]
    private Collection $personnes;

    public function __construct()
    {
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

    public function addPersonne(Person $personne): static
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes->add($personne);
            $personne->addHobby($this);
        }

        return $this;
    }

    public function removePersonne(Person $personne): static
    {
        if ($this->personnes->removeElement($personne)) {
            $personne->removeHobby($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation;
    }


}
