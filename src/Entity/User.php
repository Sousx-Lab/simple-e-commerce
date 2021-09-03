<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="L'adresse email est déja utilisée")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=30, maxMessage="The first name must not exceed 30 characters!")
     * @ORM\Column(type="string", length=30)
     */
    private string $firstName;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=30, maxMessage="The last name must not exceed 30 characters!")
     * @ORM\Column(type="string", length=30)
     */
    private string $lastName;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank
     * @Assert\Length(min=4, minMessage="Le mot de passe doit faire au moins 4 caractères", max=250)
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\EqualTo(propertyPath="password", message="Veuillez confirmer le même mot de passe")
     */
    private string $confirmPassword;

    /**
     * @var string|null
     */
    private ?string $plainPassword = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $uuid = null;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private bool $isEnabled = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phoneNumber;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */

    public function getUsername()
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }
 
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of confirmPassword
     * @return string
     */ 
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confirmPassword
     *
     * @param string $confirmPassword
     *
     * @return self
     */ 
    public function setConfirmPassword(string $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;        
        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if(!$this->getUuid()){
            $this->setUuid(Uuid::uuid4()->__toString());
        }
        
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

    public function __toString(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

}
