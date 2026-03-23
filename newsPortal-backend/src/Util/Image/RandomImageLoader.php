<?php
declare(strict_types=1);

namespace App\Util\Image;

use App\Entity\Image;
use App\Exception\ImportException;

class RandomImageLoader
{
    private const string API_BASE_URL = 'https://picsum.photos/id/';
    private const string PUBLIC_MEDIA_DIRECTORY = __DIR__ . '/../../../public/media/';

    /**
     * @throws ImportException
     */
    public function loadRandomImage(): Image
    {
        $randomId = rand(1, 200);
        $url = self::API_BASE_URL . $randomId . '/info';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($curl);
        if (!$response) {
            throw new ImportException('Not able to load random image.');
        }

        $info = json_decode($response);
        if (empty($info) || !property_exists($info, 'download_url')) {
            throw new ImportException('Not able to load random image.');
        }
        $filenameParts = explode('/', $info->url);
        $filename = end($filenameParts);

        $ch = curl_init($info->download_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);

        if (!$response) {
            throw new ImportException('Not able to load random image.');
        }

        curl_close($ch);
        curl_close($curl);
        file_put_contents(sys_get_temp_dir().$filename, $response);

        $mime = mime_content_type(sys_get_temp_dir().$filename);
        $ext = match ($mime) {
            'image/jpeg' => '.jpg',
            'image/png'  => '.png',
            'image/gif'  => '.gif',
            'image/webp' => '.webp',
            default      => ''
        };

        file_put_contents(self::PUBLIC_MEDIA_DIRECTORY . $filename . $ext, $response);


        $image = new Image();
        $image->setUrl("/media/$filename$ext");
        $image->setCopyright($info->author);
        $image->setHeight($info->height);
        $image->setWidth($info->width);
        $image->setMimeType($mime);
        $image->setCaption($info->author);
        return $image;
    }
}
