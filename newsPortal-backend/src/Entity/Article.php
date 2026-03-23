<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use App\Types\StoryType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StoryType::class)]
    private ?StoryType $storyType = null;

    #[ORM\Column(length: 255)]
    private ?string $headline = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $kicker = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column]
    private ?bool $paidContent = null;

    #[ORM\Column]
    private ?DateTime $publishingDate = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $modificationDate = null;

    /**
     * @var Collection<int, Bookmark>
     */
    #[ORM\OneToMany(targetEntity: Bookmark::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $bookmarks;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Image $image = null;

    /**
     * @var Collection<int, UserReadArticle>
     */
    #[ORM\OneToMany(targetEntity: UserReadArticle::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $userReadArticles;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'articles')]
    private Collection $authors;

    #[ORM\Column(length: 400, nullable: true)]
    private ?string $originalUrl = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?ArticleSource $articleSource = null;

    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
        $this->userReadArticles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoryType(): ?StoryType
    {
        return $this->storyType;
    }

    public function setStoryType(StoryType $storyType): static
    {
        $this->storyType = $storyType;

        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): static
    {
        $this->headline = $headline;

        return $this;
    }

    public function getKicker(): ?string
    {
        return $this->kicker;
    }

    public function setKicker(?string $kicker): static
    {
        $this->kicker = $kicker;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function isPaidContent(): ?bool
    {
        return $this->paidContent;
    }

    public function setPaidContent(bool $paidContent): static
    {
        $this->paidContent = $paidContent;

        return $this;
    }

    public function getPublishingDate(): ?DateTime
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(DateTime $publishingDate): static
    {
        $this->publishingDate = $publishingDate;

        return $this;
    }

    public function getModificationDate(): ?DateTime
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?DateTime $modificationDate): static
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * @return Collection<int, Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): static
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks->add($bookmark);
            $bookmark->setArticle($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): static
    {
        // set the owning side to null (unless already changed)
        if ($this->bookmarks->removeElement($bookmark) && $bookmark->getArticle() === $this) {
            $bookmark->setArticle(null);
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, UserReadArticle>
     */
    public function getUserReadArticles(): Collection
    {
        return $this->userReadArticles;
    }

    public function addUserReadArticle(UserReadArticle $userReadArticle): static
    {
        if (!$this->userReadArticles->contains($userReadArticle)) {
            $this->userReadArticles->add($userReadArticle);
            $userReadArticle->setArticle($this);
        }

        return $this;
    }

    public function removeUserReadArticle(UserReadArticle $userReadArticle): static
    {
        // set the owning side to null (unless already changed)
        if ($this->userReadArticles->removeElement($userReadArticle) && $userReadArticle->getArticle() === $this) {
            $userReadArticle->setArticle(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        // set the owning side to null (unless already changed)
        if ($this->comments->removeElement($comment) && $comment->getArticle() === $this) {
            $comment->setArticle(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addArticle($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeArticle($this);
        }

        return $this;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(?string $originalUrl): static
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getArticleSource(): ?ArticleSource
    {
        return $this->articleSource;
    }

    public function setArticleSource(?ArticleSource $articleSource): static
    {
        $this->articleSource = $articleSource;

        return $this;
    }
}
