<?php

namespace App\Entity;

use App\Repository\EmbedElementRepository;
use App\Types\EmbedElementType;
use App\Types\EmbedResourceType;
use App\Types\EmbedType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmbedElementRepository::class)]
class EmbedElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: EmbedElementType::class)]
    private ?EmbedElementType $type = null;

    #[ORM\Column(enumType: EmbedResourceType::class)]
    private ?EmbedResourceType $resourceType = null;

    #[ORM\Column(enumType: EmbedType::class)]
    private ?EmbedType $embedType = null;

    #[ORM\Column]
    private ?int $sorting = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $html = null;

    #[ORM\ManyToOne(inversedBy: 'embedElements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StoryLine $storyLine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?EmbedElementType
    {
        return $this->type;
    }

    public function setType(EmbedElementType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getResourceType(): ?EmbedResourceType
    {
        return $this->resourceType;
    }

    public function setResourceType(EmbedResourceType $resourceType): static
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getEmbedType(): ?EmbedType
    {
        return $this->embedType;
    }

    public function setEmbedType(EmbedType $embedType): static
    {
        $this->embedType = $embedType;

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

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(string $html): static
    {
        $this->html = $html;

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
