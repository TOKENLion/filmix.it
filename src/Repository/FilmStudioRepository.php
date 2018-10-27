<?php

namespace App\Repository;

use App\Entity\FilmStudio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FilmStudio|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilmStudio|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilmStudio[]    findAll()
 * @method FilmStudio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmStudioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FilmStudio::class);
    }

//    /**
//     * @return FilmStudio[] Returns an array of FilmStudio objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilmStudio
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
