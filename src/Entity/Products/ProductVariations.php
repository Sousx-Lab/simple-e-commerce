<?php

namespace App\Entity\Products;

use App\Entity\Products\Size;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Products\ProductVariationsRepository;
use App\Entity\Products\Color;

/**
 * @ORM\Entity(repositoryClass=ProductVariationsRepository::class)
 */
class ProductVariations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="productVariations")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Products\Size", mappedBy="productVariations", orphanRemoval=true, cascade={"persist"})
     */
    private $size;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Products\Color", mappedBy="productVariations", orphanRemoval=true, cascade={"persist"})
     */
    private $color;

    public function __construct()
    {
        $this->size = new ArrayCollection();
        $this->color = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Size[]
     */
    public function getSize(): Collection
    {
        return $this->size;
    }

    public function addSize(Size $size): self
    {
        if (!$this->size->contains($size)) {
            $this->size[] = $size;
            $size->setProductVariations($this);
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->size->removeElement($size)) {
            // set the owning side to null (unless already changed)
            if ($size->getProductVariations() === $this) {
                $size->setProductVariations(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    public function addColor(Color $color): self
    {
        if (!$this->color->contains($color)) {
            $this->color[] = $color;
            $color->setProductVariations($this);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->color->removeElement($color)) {
            // set the owning side to null (unless already changed)
            if ($color->getProductVariations() === $this) {
                $color->setProductVariations(null);
            }
        }

        return $this;
    }
}
