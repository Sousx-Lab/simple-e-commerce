<?php
namespace App\Entity\Products;



use App\Entity\Media\Picture;
use App\Entity\Categories\Category;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Products\ProductsRepository")
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private string $tags;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled = false;

    /**
     * @var Picture|null
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Media\Picture", mappedBy="products", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;

    /**
     * @Assert\All({
     *   @Assert\Image(mimeTypes="image/jpeg")})
     */
    private $pictureFiles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categories\Category", inversedBy="products")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttributs::class, mappedBy="product")
     */
    private $productAttributs;
    
    
    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->productAttributs = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (null === $this->created_at) {
            $this->setCreatedAt(new \DateTime('now'));
        }
        if (null === $this->updated_at) {
            $this->setUpdatedAt(new \DateTime('now'));
        }
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime('now');
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ') .' €';
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function getPicture(): ?Picture
    {
        if($this->pictures->isEmpty()){
            return null;
        }

        return $this->pictures->first();
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProducts($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getProducts() === $this) {
                $picture->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * Set the value of picture
     * @param Picture|null
     * @return self
     */ 
    public function setPicture(Picture $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return mixed
     */ 
    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }

    /**
     * @param mixed $pictureFiles
     */ 
    public function setPictureFiles($pictureFiles)
    {
        foreach($pictureFiles as $pictureFile){
                $picture = new Picture();
                $picture->setImgfile($pictureFile);
            $this->addPicture($picture);
           
        }
        $this->pictureFiles = $pictureFiles;
        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|ProductAttributs[]
     */
    public function getProductAttributs(): Collection
    {
        return $this->productAttributs;
    }

    public function addProductAttribut(ProductAttributs $productAttribut): self
    {
        if (!$this->productAttributs->contains($productAttribut)) {
            $this->productAttributs[] = $productAttribut;
            $productAttribut->setProduct($this);
        }

        return $this;
    }

    public function removeProductAttribut(ProductAttributs $productAttribut): self
    {
        if ($this->productAttributs->removeElement($productAttribut)) {
            // set the owning side to null (unless already changed)
            if ($productAttribut->getProduct() === $this) {
                $productAttribut->setProduct(null);
            }
        }

        return $this;
    }
}
