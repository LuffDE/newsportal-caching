<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\Factory\ArticleExportFactory;
use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ArticleListController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ?UserInterface $user;
    private CacheInterface $cache;

    public function __construct(EntityManagerInterface $entityManager, CacheInterface $cache)
    {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    #[Route('/api/articles', name: 'app_articles', methods: ['GET'])]
    public function articles(): JsonResponse
    {
        $this->user = $this->getUser();
        if ($this->user instanceof User && !empty($this->user->getUserCategoryPreferences())) {
            return $this->userPreferenceArticles();
        }
        return $this->defaultArticles();
    }

    #[Route('/api/articles/category/{categoryName}', name: 'app_articles_by_category', methods: ['GET'])]
    public function articlesByCategory(string $categoryName): JsonResponse
    {
        $this->user = $this->getUser();
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => urldecode($categoryName)]);
        if (empty($category)) {
            return new JsonResponse('Category not found', Response::HTTP_NOT_FOUND);
        }

        $articles = $category->getArticles();

        $exportArticles = [];
        foreach ($articles as $article) {
            $exportArticles[] = ArticleExportFactory::create($article, $this->user, $this->entityManager);
        }
        return new JsonResponse($exportArticles);
    }

    #[Route('/api/articles/author/{authorName}', name: 'app_articles_by_author', methods: ['GET'])]
    public function articlesByAuthor(string $authorName): JsonResponse
    {
        $this->user = $this->getUser();
        $author = $this->entityManager->getRepository(Author::class)->findOneByName(urldecode($authorName));
        if (empty($author)) {
            return new JsonResponse('Author not found', Response::HTTP_NOT_FOUND);
        }
        $articles = $author->getArticles();
        $exportArticles = [];
        foreach ($articles as $article) {
            $exportArticles[] = ArticleExportFactory::create($article, $this->user, $this->entityManager);
        }
        return new JsonResponse($exportArticles);
    }

    private function userPreferenceArticles(): JsonResponse
    {
        $articleRepository = $this->entityManager->getRepository(Article::class);

        /** @var User $user */
        $user = $this->user;
        // TODO: eventuell noch die gelesenen rausfiltern
        $userArticles = $articleRepository->findForUserPreference($user->getUserCategoryPreferences());
        $all = $articleRepository->findNewestArticles();
        $combined = [];
        foreach ($userArticles as $article) {
            $combined['featured'][] = ArticleExportFactory::create($article, $this->user, $this->entityManager)->jsonSerialize();
        }
        foreach ($all as $article) {
            $combined['all'][] = ArticleExportFactory::create($article, $this->user, $this->entityManager)->jsonSerialize();
        }
        return new JsonResponse($combined);
    }

    private function defaultArticles(): JsonResponse
    {
        $all = $this->entityManager->getRepository(Article::class)->findNewestArticles();
        $exportArticles = [];
        for ($i = 0; $i < count($all); $i++) {
            if ($i < 5) {
                $exportArticles['featured'][] = $this->cache->get('export_article_' . $all[$i]->getId(), function () use ($all, $i) {
                    return ArticleExportFactory::create($all[$i], $this->user, $this->entityManager)->jsonSerialize();
                });
//                $exportArticles['featured'][] = ArticleExportFactory::create($all[$i], $this->user, $this->entityManager)->jsonSerialize();
            } else {
                $exportArticles['all'][] = $this->cache->get('export_article_' . $all[$i]->getId(), function () use ($all, $i) {
                    return ArticleExportFactory::create($all[$i], $this->user, $this->entityManager)->jsonSerialize();
                });
//                $exportArticles['all'][] = ArticleExportFactory::create($all[$i], $this->user, $this->entityManager)->jsonSerialize();
            }
        }
        return new JsonResponse($exportArticles);
    }
}