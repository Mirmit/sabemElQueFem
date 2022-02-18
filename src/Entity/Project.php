<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TimeRegister::class, mappedBy="project", orphanRemoval=true)
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
            $timeRegister->setProject($this);
        }

        return $this;
    }

    public function removeTimeRegister(TimeRegister $timeRegister): self
    {
        if ($this->timeRegisters->removeElement($timeRegister)) {
            // set the owning side to null (unless already changed)
            if ($timeRegister->getProject() === $this) {
                $timeRegister->setProject(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
