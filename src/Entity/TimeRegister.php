<?php

namespace App\Entity;

use App\Repository\TimeRegisterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimeRegisterRepository::class)
 */
class TimeRegister
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $start;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $finish;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalHours;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="timeRegisters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $invoicable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getFinish(): ?\DateTimeInterface
    {
        return $this->finish;
    }

    public function setFinish(?\DateTimeInterface $finish): self
    {
        $this->finish = $finish;

        return $this;
    }

    public function getTotalHours(): ?float
    {
        return $this->totalHours;
    }

    public function setTotalHours(?float $totalHours): self
    {
        $this->totalHours = $totalHours;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getInvoicable(): ?bool
    {
        return $this->invoicable;
    }

    public function setInvoicable(bool $invoicable): self
    {
        $this->invoicable = $invoicable;

        return $this;
    }
}
