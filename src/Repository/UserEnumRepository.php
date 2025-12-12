<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


enum UserEnumRepository  : string

{
    case USER = 'USER' ;
    case DRIVER = 'DRIVER' ;
    case ADMIN = 'ADMIN' ;
}