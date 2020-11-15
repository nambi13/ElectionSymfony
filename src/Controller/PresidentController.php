<?php

namespace App\Controller;

use App\Entity\President;
use App\Entity\Election;
use App\Form\PresidentType;
use App\Repository\PresidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * @Route("/president")
 */
class PresidentController extends AbstractController
{
    /**
     * @Route("/", name="president_index", methods={"GET"})
     */
    public function index(PresidentRepository $presidentRepository): Response
    {
        //'presidents' => $presidentRepository->findAll(),
        return $this->render('president/index.html.twig', [
            'presidents' => $presidentRepository->findAll(),
        ]);
    }
    /**
     * @Route("/liste/{id}", name="listepresident")
     */
    public function listePresident(PresidentRepository $presidentRepository,int $id): Response
    {
       // dd($id);

   //    $entityManager=$this->getDoctrine()->getManager();
  //     $President = $entityManager->getRepository(President::class);

        //'presidents' => $presidentRepository->findAll(),
        return $this->render('president/listepr.html.twig', [
            'presidents' => $presidentRepository->findBy(["Election"=>$id]),
            'id'=>$id
        ]);
    }
     /**
     * @Route("/newpr/{id}", name="newpr")
     */
    public function newpr(PresidentRepository $presidentRepository,Request $request,int $id): Response
    {
       // dd($id);

   //    $entityManager=$this->getDoctrine()->getManager();
  //     $President = $entityManager->getRepository(President::class);

        //'presidents' => $presidentRepository->findAll(),
        $article=new President();
        $form=$this->createFormBuilder($article)
        ->add('Nom')
        ->getForm();
        $form->handleRequest($request);
        $entityManager=$this->getDoctrine()->getManager();
        $Election = $entityManager->getRepository(Election::class);
        $Elec = $Election->findBy(["id" => $id]);


        //dump($article);
        if($form->isSubmitted() && $form->isValid())
        {
            $article->setElection($Elec[0]);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
     //       return $this->redirectToRoute('president/liste/'.$id);
       //     $manager->persist($article);
       //     $manager->flush();
        
       $response = $this->forward('App\Controller\PresidentController::listePresident', [
        'id'=>$id
            ]);
            return $response;
    
    } 
    
        return $this->render('president/new.html.twig', [
            'president' => $article,
            'form' => $form->createView(),
        ]);
    

     
    }







    /**
     * @Route("/new", name="president_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $president = new President();
        $form = $this->createForm(PresidentType::class, $president);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($president);
            $entityManager->flush();

            return $this->redirectToRoute('president_index');
        }

        return $this->render('president/new.html.twig', [
            'president' => $president,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="president_show", methods={"GET"})
     */
    public function show(President $president): Response
    {
        return $this->render('president/show.html.twig', [
            'president' => $president,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="president_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, President $president): Response
    {
        $form = $this->createForm(PresidentType::class, $president);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('president_index');
        }

        return $this->render('president/edit.html.twig', [
            'president' => $president,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="president_delete", methods={"DELETE"})
     */
    public function delete(Request $request, President $president): Response
    {
        if ($this->isCsrfTokenValid('delete'.$president->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($president);
            $entityManager->flush();
        }

        return $this->redirectToRoute('president_index');
    }
}
