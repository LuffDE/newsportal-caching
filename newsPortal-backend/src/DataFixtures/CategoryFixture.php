<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture
{
    private static array $categories = [
        'Lokales',
        'Politik',
        'Sport',
        'Wirtschaft',
        'Wissen',
        'Kultur',
        'Gesellschaft',
        'International',
        'National',
    ];
    private ObjectManager $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function load(): void
    {
        foreach (self::$categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setUrl('/category/' . $categoryName);
            $this->manager->persist($category);
        }
        $this->manager->flush();
    }
}