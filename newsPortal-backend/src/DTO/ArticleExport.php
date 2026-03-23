<?php
declare(strict_types=1);

namespace App\DTO;

use DateTimeInterface;

class ArticleExport extends AbstractJson
{
    private ?int $id = null;
    private ?string $storyType = null;
    private ?string $headline = null;
    private ?Image $image = null;
    private ?string $kicker = null;
    private ?string $summary = null;
    private ?bool $paidContent = null;
    private ?string $category = null;
    private ?string $author = null;
    private ?DateTimeInterface $publishingDate = null;
    private ?DateTimeInterface $modificationDate = null;
    private ?array $storyLine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ArticleExport
    {
        $this->id = $id;
        return $this;
    }

    public function getStoryType(): ?string
    {
        return $this->storyType;
    }

    public function setStoryType(?string $storyType): ArticleExport
    {
        $this->storyType = $storyType;
        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(?string $headline): ArticleExport
    {
        $this->headline = $headline;
        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): ArticleExport
    {
        $this->image = $image;
        return $this;
    }

    public function getKicker(): ?string
    {
        return $this->kicker;
    }

    public function setKicker(?string $kicker): ArticleExport
    {
        $this->kicker = $kicker;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): ArticleExport
    {
        $this->summary = $summary;
        return $this;
    }

    public function getPaidContent(): ?bool
    {
        return $this->paidContent;
    }

    public function setPaidContent(?bool $paidContent): ArticleExport
    {
        $this->paidContent = $paidContent;
        return $this;
    }

    public function getPublishingDate(): ?DateTimeInterface
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(?DateTimeInterface $publishingDate): ArticleExport
    {
        $this->publishingDate = $publishingDate;
        return $this;
    }

    public function getModificationDate(): ?DateTimeInterface
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?DateTimeInterface $modificationDate): ArticleExport
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    public function getStoryLine(): ?array
    {
        return $this->storyLine;
    }

    public function setStoryLine(?array $storyLine): ArticleExport
    {
        $this->storyLine = $storyLine;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): ArticleExport
    {
        $this->author = $author;
        return $this;
    }

    public function setCategory(?string $category): ArticleExport
    {
        $this->category = $category;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $attribute) {
            if (!empty($attribute)) {
                if ($attribute instanceof AbstractJson) {
                    $attribute->toJsonArray();
                }
                $data[$key] = $attribute;
            }
        }
        return $data;
    }

    public function toJsonArray(): void
    {
        parent::setup(get_object_vars($this));
    }
}