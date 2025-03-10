<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "text")]
    private string $text;

    #[ORM\Column(type: "string", length: 255)]
    private string $author;

    #[ORM\Column(type: "datetime")]
    private \DateTime $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created;
    }

    public function __toString(): string
    {
        return sprintf('%s (by %s on %s)',
            $this->getText(),
            $this->getAuthor(),
            $this->getCreatedAt()->format('Y-m-d H:i')
        );
    }
}
