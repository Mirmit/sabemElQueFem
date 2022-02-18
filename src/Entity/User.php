<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="plain_password", type="string", nullable=true)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=TimeRegister::class, mappedBy="user", orphanRemoval=true)
     */
    private $timeRegisters;

    public function __construct()
    {
        $this->timeRegisters = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role): bool
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @return Collection|TimeRegister[]
     */
    public function getTimeRegisters(): Collection
    {
        return $this->timeRegisters;
    }

    public function addTimeRegister(TimeRegister $timeRegister): self
    {
        if (!$this->timeRegisters->contains($timeRegister)) {
            $this->timeRegisters[] = $timeRegister;
            $timeRegister->setUser($this);
        }

        return $this;
    }

    public function removeTimeRegister(TimeRegister $timeRegister): self
    {
        if ($this->timeRegisters->removeElement($timeRegister)) {
            // set the owning side to null (unless already changed)
            if ($timeRegister->getUser() === $this) {
                $timeRegister->setUser(null);
            }
        }

        return $this;
    }
}
