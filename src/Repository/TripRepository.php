<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Trip>
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Trip::class);
        $this->paginator = $paginator;
    }

    public function findSearch(Trip $search, array $filters = []): PaginationInterface
    {

        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
             ->andWhere('p.status = :stat')
            ->setParameter('stat', 'DISPONIBLE') 
            ->join('p.user', 'c')
            ->join('p.car', 'car')
            ->orderBy('p.startDate', 'ASC');

           

        if (!empty($search->startingPoint)) {
            $query = $query
                ->andWhere('p.startingPoint LIKE :startingPoint')
                ->setParameter('startingPoint', "%{$search->startingPoint}%");
        }

        if (!empty($search->destination)) {
            $query = $query
                ->andWhere('p.destination LIKE :destination')
                ->setParameter('destination', "%{$search->destination}%");
        }

        if (!empty($search->places)) {
            $query = $query
                ->andWhere('p.places >= :places')
                ->setParameter('places', $search->places);
        }

        $startDate = empty($search->startDate) ? date_create(): $search->startDate;
        $query = $query
                ->andWhere('p.startDate >= :startDate')
                ->setParameter('startDate', $startDate);
        
        // apply max price filter (unmapped field)
        if (!empty($filters['maxPrice'])) {
            $query = $query
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $filters['maxPrice']);
        }

        
        if (isset($filters['energy']) && $filters['energy'] !== null && $filters['energy'] !== '') {
            $energy = $filters['energy'];
            if ($energy instanceof \UnitEnum) {
                $energy = $energy->value;
            }
            $query = $query
                ->andWhere('car.energy = :energy')
                ->setParameter('energy', $energy);
        }
        

    

        return $this-> paginator->paginate(
            $query,
            $search->page,
            9
        );
    }


   public function paginationTripByUser($user, int $limit=10, int $page=1) : array
    {

        $query = $this
            -> createQueryBuilder('t')
            -> addSelect('t')
            -> leftjoin('t.user', 'u')
            -> andwhere('u = :user')
            -> setParameter(':user', $user);

        $query
            -> orderBy('t.startDate', 'DESC')
            -> setFirstResult(($page - 1) * $limit)
            -> SetMaxResults($limit);

        $paginator = new Paginator($query, fetchJoinCollection: true);
        $trip = $paginator-> getQuery()-> getResult();
        $count = $paginator-> count();
        $page = ceil($count / $limit);

        return [
            'trip' => $trip,
            'countTrip' => $count,
            'max' => $page
        ];

    }



    //    /**
    //     * @return Trip[] Returns an array of Trip objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trip
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
