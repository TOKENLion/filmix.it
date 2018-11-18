<?php

namespace App\Repository;

use App\Entity\Actor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actor[]    findAll()
 * @method Actor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actor::class);
    }

    public function getTotalActors()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findActorsByConditions($conditions = [])
    {
        $order_column = 'a.id';
        $order_dir = 'ASC';
        $request = $this->createQueryBuilder('a');

        if (isset($conditions['search'])) {
            $request->andWhere('(
                        a.name  LIKE :val OR
                        a.email LIKE :val OR 
                        a.phone LIKE :val OR
                        f.name  LIKE :val)')
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
            ->leftJoin('a.films', 'f')
            ->orderBy('a.id', 'ASC')
            ->groupBy('a.id')
            ->orderBy($order_column, $order_dir)
            ->getQuery()
            ->getResult();
    }

    public function getCountActorsByConditions($conditions = [])
    {
        $request = $this->createQueryBuilder('a')->select('COUNT(DISTINCT a.id)');

        if (isset($conditions['search'])) {
            $request->andWhere('(
                        a.name  LIKE :val OR
                        a.email LIKE :val OR 
                        a.phone LIKE :val OR
                        f.name  LIKE :val)')
                ->setParameter('val', "%{$conditions['search']}%");
        }

        return $request
            ->leftJoin('a.films', 'f')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
