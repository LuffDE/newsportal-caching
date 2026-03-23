<?php

namespace App\Entity;

use App\Repository\TextElementRepository;
use App\Types\TextElementType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TextElementRepository::class)]
class TextElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: TextElementType::class)]
    private ?TextElementType $type = null;

    #[ORM\Column]
    private ?int $sorting = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'textElements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StoryLine $storyLine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TextElementType
    {
        return $this->type;
    }

    public function setType(TextElementType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSorting(): ?int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): static
    {
        $this->sorting = $sorting;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStoryLine(): ?StoryLine
    {
        return $this->storyLine;
    }

    public function setStoryLine(?StoryLine $storyLine): static
    {
        $this->storyLine = $storyLine;

        return $this;
    }
}
