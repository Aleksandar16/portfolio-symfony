<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProjetRepository $projetRepository, TechnoRepository $technoRepository): Response
    {
        return $this->render('base.html.twig', ['projet' => $projetRepository->findAll(), 'techno' => $technoRepository->findAll()]);
    }

    #[Route('/réalisation/{id}', name: 'real')]
    public function real(ProjetRepository $projetRepository, int $id): Response
    {
        $projet = $projetRepository->find($id);

        if (null === $projet) {
            throw new NotFoundHttpException(sprintf("Projet not found", $id));
        }

        $technoProjet = $projetRepository->findByProjet($projet);

        return $this->render('realisation.html.twig', ['technoProjet' => $technoProjet, 'projet' => $projet]);
    }

    #[Route('/back-office', name: 'backoffice')]
    public function back(): Response
    {
        return $this->render('backoffice.html.twig');
    }
}
