<?php

namespace App\Controller;

use App\Entity\Election;
use App\Form\ElectionType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pays;
use App\Entity\Votant;
use App\Entity\Etat;
use App\Entity\President;
use App\Repository\VotantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use App\Repository\ElectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/election")
 */
class ElectionController extends AbstractController
{
    /**
     * @Route("/", name="election_index", methods={"GET"})
     */
    public function index(ElectionRepository $electionRepository): Response
    {
        return $this->render('election/index.html.twig', [
            'elections' => $electionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="election_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $election = new Election();
        $form = $this->createForm(ElectionType::class, $election);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $election->setEtat(1);
            $entityManager->persist($election);
            $entityManager->flush();

            return $this->redirectToRoute('election_index');
        }

        return $this->render('election/new.html.twig', [
            'election' => $election,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="election_show", methods={"GET"})
     */
    public function show(Election $election): Response
    {
        return $this->render('election/show.html.twig', [
            'election' => $election,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="election_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Election $election): Response
    {
        $form = $this->createForm(ElectionType::class, $election);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('election_index');
        }

        return $this->render('election/edit.html.twig', [
            'election' => $election,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="election_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Election $election): Response
    {
        if ($this->isCsrfTokenValid('delete'.$election->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($election);
            $entityManager->flush();
        }

        return $this->redirectToRoute('election_index');
    }

    /**
     * @Route("/Participant", name="Participant")
     */
    public function getPresident(Request $request): Response
    {
        dd("AAto ");
        /*
        if ($this->isCsrfTokenValid('delete'.$election->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($election);
            $entityManager->flush();
        }
        */
        return $this->redirectToRoute('election_index');
    }
      /**
        * @Route("/finir/{id}", name="finir")
        */
        public function ValiderElection(int $id,VotantRepository $electionRepository): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $Election_id = $entityManager->getRepository(Election::class)->find($id);
           // dd($Election_id);
            $Election_id->setEtat(5);
            $entityManager->flush();
            return $this->redirectToRoute('election_index');
         
        
          
        }
        /**
        * @Route("/ficheElection/{id}", name="ficheElection")
        */
    public function ficheElection(int $id,VotantRepository $electionRepository): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $election = $entityManager->getRepository(Votant::class)->findBy(["Election"=>$id]);
        $Election_id = $entityManager->getRepository(Election::class)->findBy(["id"=>$id]);
        $em = $this->getDoctrine()->getManager();
        $election=$electionRepository->getEtat($Election_id[0]->getId());
        $resultatotal=$electionRepository->getSommeVotant($Election_id[0]->getId());
        //  dd($election);
        $sommevoie=$electionRepository->getEtat2($Election_id[0]->getId());
        for($ii=0;$ii<count($resultatotal);$ii++){
            $resultatotal[$ii]["Nombre"]=(($resultatotal[$ii]["Nombre"])/($sommevoie[0]["totalvoie"]))*100;

        }
        for($i=0;$i<count($election);$i++){
            $pourcentage=(($election[$i]->getNombre())/$election[$i]->getEtat()->getNbrevoie())*100;
            $election[$i]->setNombre($pourcentage);
        }


        return $this->render("votant/resultat.html.twig", [
        "votants" => $election,
        "resultats"=> $resultatotal
    ]);
    }
}