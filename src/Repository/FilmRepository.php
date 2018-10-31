<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function getTotalFilms()
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findFilmsByConditions($conditions = [])
    {
        $order_column = 'f.id';
        $order_dir = 'ASC';
        $request = $this->createQueryBuilder('f');

        if (isset($conditions['search'])) {
            $request->andWhere('(
                    f.name  LIKE :val OR
                    f.genre LIKE :val OR 
                    fs.name LIKE :val OR
                    a.name  LIKE :val)')
                ->setParameter('val', "%{$conditions['search']}%");
        }

        if (!empty($order_column)) {
            $order_column = $conditions['order_column'];
            $order_dir = $conditions['order_dir'];
        }

        if (!empty($conditions['length'])) {
            $request->setFirstResult($conditions['start'])
                ->setMaxResults($conditions['length']);
        }

        return $request
            ->join('f.studio', 'fs')
            ->join('f.actors', 'a')
            ->orderBy($order_column, $order_dir)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Film[] Returns an array of Film objects
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
    public function findOneBySomeField($value): ?Film
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
