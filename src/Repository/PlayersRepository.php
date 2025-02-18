<?php

namespace App\Repository;

use App\Entity\Players;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Players>
 */
class PlayersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Players::class);
    }

    public function getAllPlayers(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.Score', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    //    /**
    //     * @return Players[] Returns an array of Players objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Players
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findByName(string $playerName): ?Players
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Name = :name')
            ->setParameter('name', $playerName)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
