<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\Factory\ArticleExportFactory;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookmarkController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/bookmark/add', name: 'app_bookmark_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse('User must be logged in to set bookmark', Response::HTTP_FORBIDDEN);
        }
        $articleId = $request->getPayload()->get('articleId');
        $article = $this->entityManager->getRepository(Article::class)->find($articleId);
        if (empty($article)) {
            return new JsonResponse('Article not found', Response::HTTP_NOT_FOUND);
        }
        $user->addBookmark($article);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new JsonResponse('Bookmark added', Response::HTTP_CREATED);
    }

    #[Route('/api/bookmark/remove', name: 'app_bookmark_remove', methods: ['POST'])]
    public function remove(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse('User must be logged in to remove bookmark', Response::HTTP_FORBIDDEN);
        }
        $bookmarkId = $request->getPayload()->get('bookmarkId');
        $bookmark = $this->entityManager->getRepository(Article::class)->find($bookmarkId);
        if (empty($bookmark)) {
            return new JsonResponse('Bookmark not found', Response::HTTP_NOT_FOUND);
        }
        $user->removeBookmark($bookmark);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new JsonResponse('Bookmark removed', Response::HTTP_OK);
    }

    #[Route('/api/bookmark/list', name: 'app_bookmark_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $user = $this->getUser();
        if (!($user instanceof User)) {
            return new JsonResponse('User must be logged in to list bookmarks', Response::HTTP_FORBIDDEN);
        }
        $bookmarks = $user->getBookmarks();
        $export = [];
        foreach ($bookmarks as $bookmark) {
            $export[] = ArticleExportFactory::create($bookmark, $user, $this->entityManager);
        }
        return new JsonResponse($export);
    }
}