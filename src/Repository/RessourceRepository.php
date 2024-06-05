<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ressource>
 *
 * @method Ressource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ressource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ressource[]    findAll()
 * @method Ressource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ressource::class);
    }

    public function countTotalRessources(): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countRessourcesByCategory(): array
    {
        return $this->createQueryBuilder('r')
            ->select('c.name AS category_name, COUNT(r.id) AS ressource_count')
            ->join('r.category', 'c')
            ->groupBy('c.name')
            ->getQuery()
            ->getResult();
    }

    public function countRessourcesLastFiveDays(): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('DATE(r.createdAt) as date, COUNT(r.id) as ressource_count')
            ->where('r.createdAt >= :start_date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->setParameter('start_date', new \DateTime('-5 days'));

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Ressource[] Returns an array of Ressource objects
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

//    public function findOneBySomeField($value): ?Ressource
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
