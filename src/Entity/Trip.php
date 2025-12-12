<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TripRepository;
use App\Repository\TripStatusEnum;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

     public $page = 1;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    public ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(length: 255)]
    public ?string $startingPoint = null;

    #[ORM\Column(length: 255)]
    public ?string $destination = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $startingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $endingTime = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?TripStatusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'Trip')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'trip')]
    private Collection $user;

    #[ORM\Column(nullable: true)]
    public ?int $places = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Driver = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStartingPoint(): ?string
    {
        return $this->startingPoint;
    }

    public function setStartingPoint(string $startingPoint): static
    {
        $this->startingPoint = $startingPoint;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getStartingTime(): ?\DateTimeImmutable
    {
        return $this->startingTime;
    }

    public function setStartingTime(\DateTimeImmutable $startingTime): static
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getEndingTime(): ?\DateTime
    {
        return $this->endingTime;
    }

    public function setEndingTime(\DateTime $endingTime): static
    {
        $this->endingTime = $endingTime;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?TripStatusEnum
    {
        return $this->autoStatus();
    }

    
    public function autoStatus(): ?TripStatusEnum
    {
        $now = date_create();

        
        if ($this->startDate && $this->startDate > $now && $this->places && $this->places > 0) {
            return TripStatusEnum::AVAILABLE;
        }

       
        if ($this->endDate && $this->endDate < $now) {
            return TripStatusEnum::PAST;
        }

        if ($this->startDate && $this->endDate && $this->startDate <= $now && $this->endDate >= $now) {
            return TripStatusEnum::ONGOING;
        }


        return $this->status;
    }

    public function setStatus( $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

      /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->addTrip($this);
             $this->setPlaces($this->places - 1);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            $user->removeTrip($this);
        }

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(?int $places): static
    {
        $this->places = $places;

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->Driver;
    }

    public function setDriver(?User $Driver): static
    {
        $this->Driver = $Driver;

        return $this;
    }

  
}
