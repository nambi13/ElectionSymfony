<?php

namespace App\Repository;

use App\Entity\Votant;
use App\Entity\Election;
use App\Entity\Etat;    
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Votant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Votant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Votant[]    findAll()
 * @method Votant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Votant::class);
    }
    public function getEtat($idelection){

        /*
        $listeEtat= $this->createQueryBuilder('v')
            ->select('v.Etat')
            ->andWhere('v.Election = :val')
            ->setParameter('val', $idelection)
            ->distinct()
            ->getQuery()
            ->getOneOrNullResult()
        ;
        */
       // $entityManager = $this->getEntityManager();
       /*
       $conn = $this->getEntityManager()->getConnection();  
      // $sql = 'SELECT  product p WHERE p.price > :price ORDER BY p.price ASC';
       $sql='select distinct etat_id from votant p where p.election_id=:id';
       $stmt = $conn->prepare($sql);
       $stmt->execute(['id' => $idelection]);
       */
      $conn = $this->getEntityManager()->getConnection();  
      // $sql = 'SELECT  product p WHERE p.price > :price ORDER BY p.price ASC';
    //  $sql='select distinct etat_id from votant p where p.election_id=:id';
       $sql='select *from election p where p.id=:id';
       $stmt = $conn->prepare($sql);
       $stmt->execute(['id' => $idelection]);
       $election=$stmt->fetchAllAssociative();
    //  dd($election[0]["pays_id"]);
    /*
       $sql2='select *from etat p where p.pays_id=:id';
       $stmt2 = $conn->prepare($sql2);
       $stmt2->execute(['id' => $election[0]["pays_id"]]);
       $election3=$stmt2->fetchAllAssociative();
     */
    $entityManager = $this->getEntityManager();
      $Etat = $entityManager->getRepository(Etat::class);
       $listeVotant=$Etat->findBy(["pays"=>$election[0]["pays_id"]]);
      //  dd($listeVotant[0]->getReference());
       return $listeVotant;
    }
    public function getSommeVotant($idelection){
     //   $idelection=4;
        $entityManager = $this->getEntityManager();
        $listeEtat=$this->_em->createQueryBuilder()
        ->select('SUM(u.Nombre) as Nombre','elc.id as election_id','pres.id as president_id')
        ->from(Votant::class, 'u')
        ->join('u.Election','elc')
        ->join('u.president','pres')
       // ->join('v.president','presi')
       
        ->andWhere('u.Election = :idelection')
        ->setParameter('idelection', $idelection)
        ->distinct(true)
       // ->groupBy('u.Election')
       // ->groupBy('u.president')
        ->groupBy('elc.id','pres.id')
       // ->groupBy('elc.id')
     //   ->groupBy('pres.id')
        
        ->getQuery()
        ->getResult()        
    ;
    
//    $query = $listeEtat->getQuery();

  //  return $query->execute();
   // dd($listeEtat);
        return $listeEtat;

   // select distinct sum(nombre),election_id,president_id from votant where election_id='1' group by election_id,president_id ;



    }






        
    

    // /**
    //  * @return Votant[] Returns an array of Votant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Votant
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
