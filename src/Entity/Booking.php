<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $charge_start;

    #[ORM\Column(type: 'datetime')]
    private $charge_end;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $station;

    #[ORM\ManyToOne(targetEntity: Car::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChargeStart(): ?\DateTimeInterface
    {
        return $this->charge_start;
    }

    public function setChargeStart(\DateTimeInterface $charge_start): self
    {
        $this->charge_start = $charge_start;

        return $this;
    }

    public function getChargeEnd(): ?\DateTimeInterface
    {
        return $this->charge_end;
    }

    public function setChargeEnd(\DateTimeInterface $charge_end): self
    {
        $this->charge_end = $charge_end;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCarId(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
