<?php

namespace App\Repository;

use App\Entity\LoginAttemps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoginAttemps>
 *
 * @method LoginAttemps|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginAttemps|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginAttemps[]    findAll()
 * @method LoginAttemps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginAttempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginAttemps::class);
    }

//    /**
//     * @return LoginAttemps[] Returns an array of LoginAttemps objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LoginAttemps
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
