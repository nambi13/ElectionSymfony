<?php

namespace App\Controller;
use App\Form\PaysFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pays;
use App\Entity\Election;
use App\Entity\Votant;
use App\Entity\Etat;
use App\Entity\President;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaysController extends AbstractController
{
    /**
     * @Route("/pays", name="pays")
     */
    public function index(): Response
    {
        return $this->render('pays/index.html.twig', [
            'controller_name' => 'PaysController',
        ]);
    }


    /**
     * @Route("/readpays", name="readpays")
     */
    public function readPays(Request $request): Response
    {
        
      

        $pays = $this->getDoctrine()->getRepository(Pays::class)->findAll();

        return $this->render('pays/listepays.html.twig', [
            "pays" => $pays,
        ]);
        
    }
    

    /**
     * @Route("/add-pays", name="add-pays",methods={"GET","POST"})
     */
    public function addProduct(Request $request): Response
    {
        $pays=new Pays();
        $form = $this->createForm(PaysFormType::class,$pays);
        
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {
           // try{  
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pays);
            $entityManager->flush();
            // ... do something
            /*
            }catch(\Exception $e){
                
                return $this->render("pays/formpays.html.twig", [
                    "form_title" => "Ajouter un Pays",
                    "form_product" => $form->createView(),
                    "error"=>$e->getMessage()
                ]);

            }
            */
        }
      

        return $this->render("pays/formpays.html.twig", [
            "form_title" => "Ajouter un Pays",
            "form_product" => $form->createView(),
            "error"=>''
        ]);
        
    }
    /**
 * @Route("/paysupdate/{id}", name="paysupdate")
 */
public function product(Request $request,int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $product = $entityManager->getRepository(Pays::class)->find($id);
    $form = $this->createForm(PaysFormType::class, $product);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager->flush();
        return $this->redirectToRoute('readpays');
    }

    return $this->render("pays/update-pays.html.twig", [
        "form_title" => "Modifier un Pays",
        "form_product" => $form->createView(),
    ]);
}
/**
     * @Route("/listecandidat", name="listecandidat",methods={"GET","POST"})
     */
public function listecandidat(Request $request): Response
{
  //  dd("ato");
    $idelection=$request->query->get('idelection');
   // dd($idelection);
    $entityManager=$this->getDoctrine()->getManager();
    $President = $entityManager->getRepository(President::class);
    $Votan = $entityManager->getRepository(Votant::class);
    $Etat = $entityManager->getRepository(Etat::class);
    $Election = $entityManager->getRepository(Election::class);
    $Elec = $Election->findBy(["id" => $idelection]);
   // dd($Elec[0]->getPays()->getId());
    $listeEtat=$Etat->findBy(["pays"=>$Elec[0]->getPays()->getId()]);
  //  dd($listeEtat);
    $listeVotant=$President->findBy(["Election"=>$idelection]);
    $fichieElection=$Election->findBy(["id"=>$idelection]);
  //  dd($listeVotant);
   // dump($request);
    if($request->request->count()>0){
      //  dump($reques);
       // dd($request);  
 //     dd($request->request->get('choix'));
        $listevote=$Votan->findBy(["Etat"=>$request->request->get('choix')]);
   //     dd($listevote);
    //    dd($listevote);
        if(count($listevote)>0){
            return $this->render('votant/choisir.html.twig', [
                "etats" => $listeEtat,
                "presidents"=>$listeVotant,
                "idelection"=>$idelection,
                "error"=>"Vote sur Cette Etat est deja fini",
            ]);


        }
        else{
        
        $stack = array();
        $ficheEtat=$Etat->findBy(["id"=>$request->request->get('choix')]);
        try{
            $Election->findId($fichieElection);
        
        for($i=0;$i<count($listeVotant);$i++){
                array_push($stack,$request->request->get($listeVotant[$i]->getId()));
         }
         $vot=array_sum($stack);
         $ficheEtat[0]->setNombre($vot);
      
         for($i=0;$i<count($listeVotant);$i++){
            $manager = $this->getDoctrine()->getManager();
            $votant = new Votant();
          
            $x=$listeVotant[$i]->getId();
           // dd($x);
           $presiden=$President->findBy(["id"=>$x]); 
         //  $president->setId(($listeVotant[$i]->getId()));
            $votant->setNombre($request->request->get($listeVotant[$i]->getId()));
            $votant->setElection($fichieElection[0]);
            $votant->setEtat($ficheEtat[0]);
            $votant->setPresident($presiden[0]);
            $manager->persist($votant);
            $manager->flush();
            
              



         }
        }catch(\Exception $e){
            return $this->render('votant/choisir.html.twig', [
                "etats" => $listeEtat,
                "presidents"=>$listeVotant,
                "idelection"=>$idelection,
                "error"=>$e->getMessage(),
            ]);



        }
    }


        

    } 
   
   
   
   return $this->render('votant/choisir.html.twig', [
        "etats" => $listeEtat,
        "presidents"=>$listeVotant,
        "idelection"=>$idelection,
        "error"=>"",
    ]);

    
}
 /**
     * @Route("/acceselection", name="acceselection",methods={"GET","POST"})
     */


    public function acceselection(Request $request): Response
    {
    //    $userRepo = $entityManager->getRepository(Election::class); 
      //  dd($idpays);
      
      $idpays=$request->query->get('idpays');
        $form=$this->createFormBuilder()
            
         ->add('Election',EntityType::class,[
            'class' => Election::class,
            'query_builder' => function (EntityRepository $er) use ($idpays) {
                    return $er->createQueryBuilder('u')
                    ->where('u.Pays=:id')
                    ->setParameter("id",$idpays);
            },
            'choice_label' => function($election){
                   return $election->StringtoDates();
            },
            ])
            ->add('submit', SubmitType::class)
         ->getForm()
            ;
         
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
          //  dd("Ato o");
            
          //  dd($idpays);
            //  dd($form->getData());
            $data=$form->getData();
          //  dd($data);
            //  dd($data["id"]);
       //     dd($data["Pays"]->getId());
       /*
            $response = $this->forward('App\Controller\PaysController::ListeCandidat', [
        'idelection'=>$data["Election"]->getId()
            ]);
            return $response;
         */   
        return $this->redirectToRoute('listecandidat',  array('idelection' => $data["Election"]->getId()));

        }
        return $this->render('election/choisirdate.html.twig', [
            "formulaire" => $form->createView(),
        ]);
        
    }


 /**
     * @Route("/accespays", name="accespays",methods={"GET","POST"})
     */

    public function accespays(Request $request): Response
    {
        $form=$this->createFormBuilder()
         ->add('Pays',EntityType::class,[
            'class' => Pays::class,
            'choice_label' => 'nompays',
            ])
            ->add('save',SubmitType::class,[
                'label'=>'ajouter'
            ])
         ->getForm()
            ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
          //  dd($form->getData());
            $data=$form->getData();
            //dd($data["Pays"]->getId());
            $id=$data["Pays"]->getId();
            /*
            $response = $this->forward('App\Controller\PaysController::acceselection', [
                'idpays'  => $id
            ]);*/
        //    $response=$resultRedirect->setPath('customer/index/new', ['params' => $params]);
            return $this->redirectToRoute('acceselection',  array('idpays' => $id));


        }
        return $this->render('pays/choisir.html.twig', [
            "formulaire" => $form->createView(),
        ]);
        
    }

 /**
     * @Route("/", name="affichage",methods={"GET","POST"})
     */

    public function affichage(Request $request): Response
    {
        
        return $this->render('pays/accueil.html.twig');
    }

}




/*
public function deleteProduct(int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $product = $entityManager->getRepository(Product::class)->find($id);
    $entityManager->remove($product);
    $entityManager->flush();

    return $this->redirectToRoute("products");
}






*/