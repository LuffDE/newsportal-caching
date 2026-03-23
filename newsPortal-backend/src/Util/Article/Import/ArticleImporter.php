<?php /** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace App\Util\Article\Import;

use App\Entity\Article;
use App\Entity\ArticleSource;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\PictureElement;
use App\Entity\StoryLine;
use App\Entity\Tag;
use App\Entity\TextElement;
use App\Exception\ImportException;
use App\Types\PictureElementType;
use App\Types\StoryType;
use App\Types\TagType;
use App\Types\TextElementType;
use App\Util\Image\RandomImageLoader;
use DateMalformedStringException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Loads Articles from Demo JSON. Unoptimized class due to known input.
 */
class ArticleImporter
{
    private EntityManagerInterface $manager;
    private RandomImageLoader $imageLoader;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->imageLoader = new RandomImageLoader();
    }

    /**
     * @throws DateMalformedStringException
     */
    public function import(): void
    {
        $demoDirectory = __DIR__ . '/../../../../demo/';
        $files = glob($demoDirectory . '*.json');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $data = json_decode($content);
            foreach ($data as $article) {
                $this->createArticle($article);
            }
        }
    }

    /**
     * @throws DateMalformedStringException
     */
    private function createArticle(object $rawData): void
    {
        $article = new Article();
        $article->setStoryType(StoryType::tryFrom($rawData->storyType));
        $article->setHeadline(substr($rawData->headline, 0, 250));
        $article->setKicker(substr($rawData->kicker, 0, 250));
        $article->setSummary($rawData->summary);
        $article->setPaidContent($rawData->paidContent);
        $article->setPublishingDate(new DateTime($rawData->publishingDate));
        $article->setModificationDate(new DateTime($rawData->modificationDate));
        $this->manager->persist($article);
        $this->addCategories($article, $rawData);
        $this->manager->flush();
//        $this->addTags($article, $rawData);
        $this->addAuthors($article, $rawData);
        $this->addMainImage($article);
        $this->addStoryline($article, $rawData);
        $this->addSource($article, $rawData);
    }

    private function addCategories(Article $article, object $rawData): void
    {
        foreach ($rawData->category as $rawCategory) {
            $category = $this->manager->getRepository(Category::class)->findOneBy(['name' => $rawCategory->name]);
            if (empty($category)) {
                $category = new Category();
                $category->setUrl($rawCategory->url);
                $category->setName($rawCategory->name);
            }
            $category->addArticle($article);
            $this->manager->persist($category);
            $this->manager->flush();
        }
        $this->manager->persist($article);
        $this->manager->flush();
    }

    private function addTags(Article $article, object $rawData): void
    {
        foreach ($rawData->tags as $rawTag) {
            $tag = $this->manager->getRepository(Tag::class)->findOneBy(['name' => $rawTag->name]);
            if (empty($tag)) {
                $tag = new Tag();
                $tag->setName($rawTag->name);
                $tag->setWeight($rawTag->weight);
                $tag->setType(TagType::tryFrom($rawTag->type));
            }
            $this->manager->persist($tag);
            $this->manager->flush();
        }
        $this->manager->persist($article);
        $this->manager->flush();
    }

    private function addAuthors(Article $article, object $rawData): void
    {
        $name = $rawData->author;
        $author = $this->manager->getRepository(Author::class)->findOneBy(['name' => $name]);
        if (empty($author)) {
            $author = new Author();
            $author->setName($name);
        }
        $author->addArticle($article);
        $this->manager->persist($author);
        $this->manager->persist($article);
        $this->manager->flush();
    }

    private function addMainImage(Article $article): void
    {
        try {
            $image = $this->imageLoader->loadRandomImage();
        } catch (ImportException) {
            return;
        }
        $this->manager->persist($image);
        $this->manager->flush();
        $article->setImage($image);
        $this->manager->persist($article);
        $this->manager->flush();
    }

    private function addStoryline(Article $article, object $rawData): void
    {
        $storyLine = new StoryLine();
        $storyLine->setArticle($article);
        $this->manager->persist($storyLine);
        $this->manager->flush();
        $sorting = 1;
        foreach ($rawData->storyLine as $rawStoryLineElement) {
            if ($rawStoryLineElement->type === 'IMAGE') {
                try {
                    $image = $this->imageLoader->loadRandomImage();
                    $this->manager->persist($image);
                    $this->manager->flush();

                    $pictureElement = new PictureElement();
                    $pictureElement->setType(PictureElementType::PICTURE_STORY_ELEMENT);
                    $pictureElement->setImage($image);
                    $pictureElement->setStoryLine($storyLine);
                    $pictureElement->setSorting($sorting);
                    $this->manager->persist($pictureElement);
                    $this->manager->flush();

                } catch (ImportException) {
                    continue;
                }
            } else {
                $textElement = new TextElement();
                $textElement->setSorting($sorting);
                $textElement->setStoryLine($storyLine);
                $textElement->setType(TextElementType::tryFrom($rawStoryLineElement->type));
                $textElement->setContent($rawStoryLineElement->content);
                $this->manager->persist($textElement);
                $this->manager->flush();
            }
            $sorting++;
        }
    }

    private function addSource(Article $article, object $rawData): void
    {
        $name = $rawData->articleSource;
        $source = $this->manager->getRepository(ArticleSource::class)->findOneBy(['name' => $name]);
        if (empty($source)) {
            $source = new ArticleSource();
            $source->setName($name);
        }
        $source->addArticle($article);
        $this->manager->persist($source);
        $this->manager->persist($article);
        $this->manager->flush();
    }
}
