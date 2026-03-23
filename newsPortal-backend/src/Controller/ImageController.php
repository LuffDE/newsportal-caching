<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route("/api/image/media/{imageName}", name: "app_image_media")]
    public function image(string $imageName): BinaryFileResponse
    {
        $imagePath = __DIR__ . '/../../public/media/' . $imageName;
        if (!file_exists($imagePath)) {
            return new BinaryFileResponse(__DIR__ . '/../../data/placeholder.png');
        }
        return new BinaryFileResponse($imagePath);
    }
}