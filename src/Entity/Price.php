<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $original = null;

    #[ORM\Column(nullable: true)]
    private ?int $final = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $discount_percentage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginal(): ?int
    {
        return $this->original;
    }

    public function setOriginal(?int $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function getFinal(): ?int
    {
        return $this->final;
    }

    public function setFinal(?int $final): self
    {
        $this->final = $final;

        return $this;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discount_percentage;
    }

    public function setDiscountPercentage(?string $discount_percentage): self
    {
        $this->discount_percentage = $discount_percentage;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
