<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\UserCategoryPreference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param string $searchTerm
     * @param int $limit
     * @return Article[]
     */
    public function findBySearchTerm(string $searchTerm, int $limit = 20): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('LOWER(a.headline) LIKE LOWER(:searchTerm)')
            ->setParameter('searchTerm', "%$searchTerm%")
            ->setMaxResults($limit)
            ->orderBy('a.modificationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @return Article[]
     */
    public function findNewestArticles(int $limit = 100): array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'i', 'c', 'au')
            ->orderBy('a.publishingDate', 'DESC')
            ->leftJoin('a.image', 'i')
            ->leftJoin('a.category', 'c')
            ->leftJoin('a.authors', 'au')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Collection<UserCategoryPreference> $userPreferences
     * @param int $limit
     * @return Article[]
     */
    public function findForUserPreference(Collection $userPreferences, int $limit = 5): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a', 'c')
            ->leftJoin('a.category', 'c');
        if ($userPreferences->count() > 0) {
            $qb->andWhere('c IN (:categories)')
                ->setParameter('categories', $userPreferences);
        }
        return $qb->orderBy('a.publishingDate', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
