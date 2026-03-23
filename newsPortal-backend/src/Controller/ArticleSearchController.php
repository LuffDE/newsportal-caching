<?php

namespace App\Controller;

use App\DTO\Factory\ArticleExportFactory;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ArticleSearchController extends AbstractController
{
    private const int MIN_QUERY_CHARS = 3;
    #[Route('api/article/search/{query}', name: 'article_search')]
    public function search(EntityManagerInterface $entityManager, ?string $query = null): JsonResponse
    {
        if ($query === null  || strlen($query) < self::MIN_QUERY_CHARS) {
            return new JsonResponse([]);
        }

        $results = $entityManager->getRepository(Article::class)->findBySearchTerm(urldecode($query));

        $export = [];
        foreach ($results as $result) {
            $export[] = ArticleExportFactory::create($result, $this->getUser(), $entityManager);
        }
        return new JsonResponse($export);
    }
}