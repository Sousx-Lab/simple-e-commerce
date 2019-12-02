<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="Le nom d'utilisateur n'est pas disponible")
 * @UniqueEntity(fields={"email"}, message="L'adresse email est déja utilisée")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=4, max=50)
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank
     * @Assert\Length(min=4, minMessage="Le mot de passe doit faire un minimum 4 caractères", max=250)
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Assert\EqualTo(propertyPath="password", message="Veuillez confirmer le même mot de passe")
     */
    private $confirmPassword;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
     *
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
}