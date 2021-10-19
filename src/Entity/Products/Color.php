<?php

namespace App\Entity\Products;

use App\Repository\Products\ColorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $colorValue;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariations::class, inversedBy="color")
     */
    private $productVariations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorValue(): ?string
    {
        return $this->colorValue;
    }

    public function setColorValue(?string $colorValue): self
    {
        $this->colorValue = $colorValue;

        return $this;
    }

    public function getProductVariations(): ?ProductVariations
    {
        return $this->productVariations;
    }

    public function setProductVariations(?ProductVariations $productVariations): self
    {
        $this->productVariations = $productVariations;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getColorValue();
    }
}
