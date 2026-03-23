<?php

namespace App\Entity;

use App\Repository\StoryLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoryLineRepository::class)]
class StoryLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    /**
     * @var Collection<int, PictureElement>
     */
    #[ORM\OneToMany(targetEntity: PictureElement::class, mappedBy: 'storyLine', orphanRemoval: true)]
    private Collection $pictureElements;

    /**
     * @var Collection<int, EmbedElement>
     */
    #[ORM\OneToMany(targetEntity: EmbedElement::class, mappedBy: 'storyLine', orphanRemoval: true)]
    private Collection $embedElements;

    /**
     * @var Collection<int, TextElement>
     */
    #[ORM\OneToMany(targetEntity: TextElement::class, mappedBy: 'storyLine', orphanRemoval: true)]
    private Collection $textElements;

    public function __construct()
    {
        $this->pictureElements = new ArrayCollection();
        $this->embedElements = new ArrayCollection();
        $this->textElements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Collection<int, PictureElement>
     */
    public function getPictureElements(): Collection
    {
        return $this->pictureElements;
    }

    public function addPictureElement(PictureElement $pictureElement): static
    {
        if (!$this->pictureElements->contains($pictureElement)) {
            $this->pictureElements->add($pictureElement);
            $pictureElement->setStoryLine($this);
        }

        return $this;
    }

    public function removePictureElement(PictureElement $pictureElement): static
    {
        if ($this->pictureElements->removeElement($pictureElement)) {
            // set the owning side to null (unless already changed)
            if ($pictureElement->getStoryLine() === $this) {
                $pictureElement->setStoryLine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmbedElement>
     */
    public function getEmbedElements(): Collection
    {
        return $this->embedElements;
    }

    public function addEmbedElement(EmbedElement $embedElement): static
    {
        if (!$this->embedElements->contains($embedElement)) {
            $this->embedElements->add($embedElement);
            $embedElement->setStoryLine($this);
        }

        return $this;
    }

    public function removeEmbedElement(EmbedElement $embedElement): static
    {
        if ($this->embedElements->removeElement($embedElement)) {
            // set the owning side to null (unless already changed)
            if ($embedElement->getStoryLine() === $this) {
                $embedElement->setStoryLine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TextElement>
     */
    public function getTextElements(): Collection
    {
        return $this->textElements;
    }

    public function addTextElement(TextElement $textElement): static
    {
        if (!$this->textElements->contains($textElement)) {
            $this->textElements->add($textElement);
            $textElement->setStoryLine($this);
        }

        return $this;
    }

    public function removeTextElement(TextElement $textElement): static
    {
        if ($this->textElements->removeElement($textElement)) {
            // set the owning side to null (unless already changed)
            if ($textElement->getStoryLine() === $this) {
                $textElement->setStoryLine(null);
            }
        }

        return $this;
    }
}
