<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'bigint')]
    private int $isbn;

    #[ORM\Column(type: 'boolean')]
    private bool $obliged;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'books')]
    #[ORM\JoinColumn(name: 'course', referencedColumnName: 'id')]
    private ?Course $course;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getIsbn(): int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function isObliged(): bool
    {
        return $this->obliged;
    }

    public function setObliged(bool $obliged): self
    {
        $this->obliged = $obliged;
        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;
        return $this;
    }
}

