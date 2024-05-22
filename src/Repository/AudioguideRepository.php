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

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Audioguide $audioguide): void
    {
        $this->getEntityManager()->remove($audioguide);
    }

    public function add(Audioguide $audioguide): void
    {
        $this->getEntityManager()->persist($audioguide);
    }
}
