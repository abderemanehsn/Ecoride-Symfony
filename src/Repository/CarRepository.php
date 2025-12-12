<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function paginationCarsByUser ( $user, int $limit = 10, int $page = 1) : array
    {

        $query = $this
            ->createQueryBuilder('c')
            -> select('c','p', 'u')
            -> join('c.brand', 'p')
            ->join('c.user', 'u')
            ->andWhere('c.user = :user')
            ->setParameter(':user', $user);

         $query
            ->orderBy('c.firstImmatriculationAt', 'DESC')
            -> setFirstResult(($page - 1) * $limit)
            ->SetMaxResults($limit);

            $paginator = new Paginator($query, fetchJoinCollection: true);
            $cars = $paginator->getQuery()-> getResult();

            $count = $paginator-> count();
            $pages = ceil($count / $limit);


        return [
            'cars' => $cars,
            'maxPages' => $pages,
           'countPosts' => $count
        ];
            
         /*    ->setHint(Paginator::HINT_ENABLE_DISTINCT, false) */
            
         return new Paginator($query, false);
            
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
