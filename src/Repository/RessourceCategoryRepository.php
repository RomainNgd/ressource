<?php

namespace App\Repository;

use App\Entity\RessourceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RessourceCategory>
 *
 * @method RessourceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RessourceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RessourceCategory[]    findAll()
 * @method RessourceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RessourceCategory::class);
    }

    //    /**
    //     * @return RessourceCategory[] Returns an array of RessourceCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RessourceCategory
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
