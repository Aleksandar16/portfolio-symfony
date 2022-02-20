<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProjetController extends AbstractController
{
    #[Route('/projet', name: 'projet')]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/projet.html.twig', ['projet' => $projetRepository->findAll()]);
    }

    #[Route('/showProjet/{id}', name: 'show_projet')]
    public function showAuthor(ProjetRepository $projetRepository, TechnoRepository $technoRepository, int $id): Response
    {
        $projet = $projetRepository->find($id);

        if (null === $projet) {
            throw new NotFoundHttpException(sprintf("Projet not found", $id));
        }

        $technoProjet = $projetRepository->findByProjet($projet);

        return $this->render('projet/show.html.twig', ['technoProjet' => $technoProjet, 'projet' => $projet]);
    }

    #[Route('/create-projet', name: 'create_projet')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $projet = new Projet();

        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();

            $projet = $form->getData();

            $entityManager->persist($projet);

            $entityManager->flush();

            return $this->redirectToRoute('projet');
        }

        return $this->render('projet/create-projet.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update-projet/{id}', name: 'update_projet')]
    public function update(ProjetRepository $projetRepository, Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $projet = $projetRepository->find($id);

        if (null === $projet) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();

            $projet = $form->getData();

            $entityManager->persist($projet);

            $entityManager->flush();

            return $this->redirectToRoute('projet', [
                'id' => $projet->getId()]);
        }

        return $this->render('projet/update-projet.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-projet/{id}', name: 'delete_projet')]
    public function delete(ProjetRepository $projetRepository, Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $projet = $projetRepository->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($projet);
        $entityManager->flush();
        return $this->redirectToRoute('projet');
    }
}
