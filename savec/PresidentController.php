<?php

namespace App\Controller;

use App\Entity\President;
use App\Form\PresidentType;
use App\Repository\PresidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('president/index.html.twig', [
            'presidents' => $presidentRepository->findAll(),
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
