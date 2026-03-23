<?php
declare(strict_types=1);

namespace App\Controller;


use App\DTO\Factory\ArticleExportFactory;
use App\Entity\User;
use App\Entity\UserReadArticle;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleDetailController extends AbstractController
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/article/{id}', name:'app_article_detail', methods: ['GET'])]
    public function article(int $id): JsonResponse
    {
        $article = $this->articleRepository->find($id);
        if (empty($article)) {
            return new JsonResponse('Article not found', Response::HTTP_NOT_FOUND);
        }
        /** @var ?User $user */
        $user = $this->getUser();
        if (!empty($user)) {
            $userArticle = new UserReadArticle();
            $userArticle->setArticle($article);
            $userArticle->setUser($user);
            $userArticle->setReadDate(new DateTime());
            $this->entityManager->persist($userArticle);
            $this->entityManager->flush();
            $user->addUserReadArticle($userArticle);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        $export = ArticleExportFactory::create($article, $this->getUser(), $this->entityManager);
        return new JsonResponse($export);
    }
}