<?php
declare(strict_types=1);

namespace App\DTO\Factory;

use App\DTO\ArticleExport;
use App\DTO\Image;
use App\Entity\Article;
use App\Entity\StoryLine;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ArticleExportFactory
{
    private function __construct()
    {
        // This class should not be instantiated
    }
    public static function create(Article $article, ?User $user, EntityManagerInterface $entityManager): ArticleExport
    {
        $premiumUser = $user instanceof User && in_array('ROLE_PREMIUM', $user->getRoles());

        // Generated Test Data to long for realistic title length
        $randomHeadlineLength = rand(15, 35);

        $dto = new ArticleExport();
        $dto->setId($article->getId());
        $dto->setHeadline(substr($article->getHeadline(), 0, $randomHeadlineLength));
        $dto->setSummary($article->getSummary());
        $dto->setKicker($article->getKicker());
        $dto->setModificationDate($article->getModificationDate());
        $dto->setPublishingDate($article->getPublishingDate());
        $dto->setPaidContent($article->isPaidContent());
        $dto->setStoryType($article->getStoryType()->value);
        $dto->setCategory($article->getCategory()?->getName());
        if (false !== $article->getAuthors()?->first()) {
            $dto->setAuthor($article->getAuthors()?->first()?->getName());
        } else {
            $dto->setAuthor('');
        }

        $image = new Image();
        $image->setUrl($article->getImage()?->getUrl());
        $image->setCaption($article->getImage()?->getCaption());
        $image->setCopyright($article->getImage()?->getCopyright());
        $image->setAlt($article->getImage()?->getDescription());

        $dto->setImage($image);

        if ($article->isPaidContent() && !$premiumUser) {
            return $dto;
        }
        $dto->setStoryLine(self::getStoryLine($article, $entityManager));
        return $dto;
    }


    private static function getStoryLine(Article $article, EntityManagerInterface $entityManager): array
    {
        $storyLine = $entityManager->getRepository(StoryLine::class)->findOneBy(['article' => $article]);
        if (empty($storyLine)) {
            return [];
        }
        $textElements = $storyLine->getTextElements();
        $imageElements = $storyLine->getPictureElements();
        $embeddedElements = $storyLine->getEmbedElements();
        $combined = [];
        foreach ($textElements as $textElement) {
            $combined[$textElement->getSorting()] = [
                'type' => $textElement->getType(),
                'content' => $textElement->getContent()
            ];
        }
        foreach ($imageElements as $imageElement) {
            $image = new Image();
            $image->setUrl($imageElement->getImage()?->getUrl());
            $image->setCaption($imageElement->getImage()?->getCaption());
            $image->setCopyright($imageElement->getImage()?->getCopyright());
            $image->setAlt($imageElement->getImage()?->getDescription());
            $image->toJsonArray();
            $combined[$imageElement->getSorting()] = [
                'type' => $imageElement->getType(),
                'content' => $image->jsonSerialize()
            ];
        }

        foreach ($embeddedElements as $embeddedElement) {
            $combined[$embeddedElement->getSorting()] = [
                'type' => $embeddedElement->getType(),
                'content' => $embeddedElement->getContent()
            ];
        }
        return $combined;
    }
}