<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/api/article/{articleId}/comments', name: 'app_article_comments', methods: ['GET'])]
    public function articleComments(int $articleId): JsonResponse
    {
        $article = $this->entityManager->getRepository(Article::class)->find($articleId);
        if (empty($article)) {
            return new JsonResponse('Article not found', Response::HTTP_NOT_FOUND);
        }
    }

    public function add(): JsonResponse
    {

    }

    #[Route('/api/comment/{commentId}/remove', name: 'app_comment_remove', methods: ['POST'])]
    public function remove(Request $request): JsonResponse
    {
        $user = $this->getUser();

    }

    public function listUserComments(): JsonResponse
    {

    }
}