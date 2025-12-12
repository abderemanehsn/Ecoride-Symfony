<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


enum TripStatusEnum  : string

{
    case AVAILABLE = 'DISPONIBLE' ;
    case FULL = 'PLEIN' ;
    case PAST = 'PASSÉ' ;
    case ONGOING = 'EN COURS' ;
}