<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Person
{

    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "donner un prenom")]
    #[Assert\Length(min:4,max:50,minMessage: "veuillez avoir au moins 4 caracteres",maxMessage:"veuillez avoir au puls 50 caracteres" ),]
    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "donner un nom")]
    #[Assert\Length(min:4,max:50,minMessage: "veuillez avoir au moins 4 caracteres",maxMessage:"veuillez avoir au puls 50 caracteres" ),]
    private ?string $lastname = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "donner un age")]
    #[Assert\Positive]
    private ?int $age = null;


    #[ORM\Column(length: 50, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Profile $profile = null;



    #[ORM\ManyToOne(inversedBy: 'personnes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Job $job = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;


    #[ORM\ManyToMany(targetEntity: Hobby::class, inversedBy: 'personnes', cascade: ['remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $hobbies;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hobbiesTitle = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $rs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;








    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }





    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): static
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): static
    {
        $this->hobbies->removeElement($hobby);

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }


    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getHobbiesTitle(): ?string
    {
        return $this->hobbiesTitle;
    }

    public function setHobbiesTitle(?string $hobbiesTitle): static
    {
        $this->hobbiesTitle = $hobbiesTitle;

        return $this;
    }

    public function getRs(): ?string
    {
        return $this->rs;
    }

    public function setRs(?string $rs): static
    {
        $this->rs = $rs;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }










}
