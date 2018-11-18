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
}
