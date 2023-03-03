<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Find categories by popularity.
     *
     * @param int $limit
     *
     * @return Category[]
     */
    public function findByPopularity($limit)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.products', 'p')
            ->addSelect('COUNT(p.id) as HIDDEN countProducts')
            ->orderBy('countProducts', 'DESC')
            ->groupBy('c.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
