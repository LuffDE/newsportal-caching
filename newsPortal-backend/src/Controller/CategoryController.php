<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{

    #[Route('/api/category/list', name: 'app_category_list', methods: ['GET'])]
    public function list(CategoryRepository $categoryRepository): JsonResponse
    {
        $allCategories = $categoryRepository->findAll();
        $export = [];
        foreach ($allCategories as $category) {
            $export[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'url' => $this->generateUrl('app_articles_by_category', ['categoryName' => urlencode($category->getName())])
            ];
        }
        return new JsonResponse($export);
    }

}