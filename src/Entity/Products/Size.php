<?php

namespace App\Entity\Products;

use App\Repository\Products\SizeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SizeRepository::class)
 */
class Size
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $sizeValue;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariations::class, inversedBy="size")
     */
    private $productVariations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSizeValue(): ?string
    {
        return $this->sizeValue;
    }

    public function setSizeValue(?string $sizeValue): self
    {
        $this->sizeValue = $sizeValue;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getSizeValue();
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
}
