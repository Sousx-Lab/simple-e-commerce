<?php

namespace App\Entity\Categories;

use DateTimeInterface;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Products\Products;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"},
     * )
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="picture")
     */
    private $imgfile;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $picture = null;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt = null;
    

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, mappedBy="categories")
     */
    private $products;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $inMenu = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isEnabled = true;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return File|null
     */ 
    public function getImgfile(): ?File
    {
        return $this->imgfile;
    }

    /**
     * Set mimeTypes="image/jpeg"
     * @param File|null $imgfile  mimeTypes="image/jpeg"
     * @return self
     */ 
    public function setImgfile(File $picture = null)
    {
        $this->imgfile = $picture;
        if($picture){
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     * @return self
     */ 
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (null === $this->createdAt) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function getInMenu(): ?bool
    {
        return $this->inMenu;
    }

    public function setInMenu(bool $inMenu): self
    {
        $this->inMenu = $inMenu;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
