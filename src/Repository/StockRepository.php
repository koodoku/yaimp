<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stock>
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    public function findById(int $stockId): ?Stock
    {
    
        return $this -> createQueryBuilder(alias:'s')
        ->andWhere('s.id = :stockId')
        ->setParameter('stockId', $stockId)   
        ->getQuery()
        ->getOneOrNullResult() 
        ;
}

}
