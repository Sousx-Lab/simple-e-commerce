<?php

namespace App\Repository\Products;

use App\Entity\Products\ProductVariations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductVariations|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductVariations|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductVariations[]    findAll()
 * @method ProductVariations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductVariationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariations::class);
    }

    // /**
    //  * @return ProductVariations[] Returns an array of ProductVariations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductVariations
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
