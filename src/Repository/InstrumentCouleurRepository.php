<?php

namespace App\Repository;

use App\Entity\InstrumentCouleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InstrumentCouleur>
 *
 * @method InstrumentCouleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstrumentCouleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstrumentCouleur[]    findAll()
 * @method InstrumentCouleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstrumentCouleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstrumentCouleur::class);
    }

//    /**
//     * @return InstrumentCouleur[] Returns an array of InstrumentCouleur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InstrumentCouleur
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
