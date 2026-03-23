<?php

namespace App\Entity;

use App\Repository\PictureElementRepository;
use App\Types\PictureElementType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureElementRepository::class)]
class PictureElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: PictureElementType::class)]
    private ?PictureElementType $type = null;

    #[ORM\Column]
    private ?int $sorting = null;

    #[ORM\ManyToOne(inversedBy: 'pictureElements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'pictureElements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StoryLine $storyLine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?PictureElementType
    {
        return $this->type;
    }

    public function setType(PictureElementType $type): static
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

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
