<?php

namespace App\Repository;

use App\Entity\Audioguide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Audioguide>
 *
 * @method Audioguide|null find($id, $lockMode = null, $lockVersion = null)
 * @method Audioguide|null findOneBy(array $criteria, array $orderBy = null)
 * @method Audioguide[]    findAll()
 * @method Audioguide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudioguideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audioguide::class);
    }

//    /**
//     * @return Audioguide[] Returns an array of Audioguide objects
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

//    public function findOneBySomeField($value): ?Audioguide
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
