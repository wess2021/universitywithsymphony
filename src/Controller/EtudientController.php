<?php

namespace App\Controller;

use App\Entity\Etudient;
use App\Form\EtudientType;
use App\Repository\EtudientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudient")
 */
class EtudientController extends AbstractController
{
    /**
     * @Route("/", name="etudient_index", methods={"GET"})
     */
    public function index(EtudientRepository $etudientRepository): Response
    {
        return $this->render('etudient/index.html.twig', [
            'etudients' => $etudientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etudient = new Etudient();
        $form = $this->createForm(EtudientType::class, $etudient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudient);
            $entityManager->flush();

            return $this->redirectToRoute('etudient_index');
        }

        return $this->render('etudient/new.html.twig', [
            'etudient' => $etudient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudient_show", methods={"GET"})
     */
    public function show(Etudient $etudient): Response
    {
        return $this->render('etudient/show.html.twig', [
            'etudient' => $etudient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudient $etudient): Response
    {
        $form = $this->createForm(EtudientType::class, $etudient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudient_index');
        }

        return $this->render('etudient/edit.html.twig', [
            'etudient' => $etudient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudient $etudient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudient_index');
    }
}
