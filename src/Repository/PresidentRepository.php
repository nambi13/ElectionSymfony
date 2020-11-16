<?php

namespace App\Repository;

use App\Entity\President;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use App\Exception\YourBadRequestException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * @method President|null find($id, $lockMode = null, $lockVersion = null)
 * @method President|null findOneBy(array $criteria, array $orderBy = null)
 * @method President[]    findAll()
 * @method President[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresidentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, President::class);
    }

    // /**
    //  * @return President[] Returns an array of President objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?President
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function test(President $entity){
        try{
            $entityManager = $this->getEntityManager();
            $entityManager->persist($entity);
         
        }catch(UniqueConstraintViolationException $e){
            return 0;
        }





    }
}
