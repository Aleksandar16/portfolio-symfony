<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

class TechnoController extends AbstractController
{
    #[Route('/techno', name: 'techno')]
    public function index(TechnoRepository $technoRepository): Response
    {
        return $this->render('techno/techno.html.twig', ['techno' => $technoRepository->findAll()]);
    }

    #[Route('/showTechno/{id}', name: 'show_techno')]
    public function show(TechnoRepository $technoRepository, int $id): Response
    {
        $techno = $technoRepository->find($id);

        if (null === $techno) {
            throw new NotFoundHttpException(sprintf("Techno not found", $id));
        }

        $typeTechno = $techno->getType($techno);

        return $this->render('techno/show.html.twig', ['techno' => $techno, 'type' => $typeTechno]);
    }

    #[Route('/create-techno', name: 'create_techno')]
    public function create(SluggerInterface $slugger, TechnoRepository $technoRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $techno = new Techno();

        $form = $this->createForm(TechnoType::class, $techno);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $screen = $form->get('image')->getData();

            if ($screen) {
                $originalFilename = pathinfo($screen->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newScreen = $safeFilename.'-'.uniqid().'.'.$screen->guessExtension();

                try {
                    $screen->move(
                        $this->getParameter('projet_directory'),
                        $newScreen
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $techno->setImage($newScreen);
            }

            $entityManager = $doctrine->getManager();

            $techno = $form->getData();

            $entityManager->persist($techno);

            $entityManager->flush();

            return $this->redirectToRoute('techno');
        }

        return $this->render('techno/create-techno.html.twig', [
            'form' => $form->createView(),
            'techno' => $technoRepository->findAll(),
        ]);
    }

    #[Route('/update-techno/{id}', name: 'update_techno')]
    public function update(SluggerInterface $slugger, TechnoRepository $technoRepository, Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $techno = $technoRepository->find($id);

        if (null === $techno) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $screen = $form->get('image')->getData();

            if ($screen) {
                $originalFilename = pathinfo($screen->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newScreen = $safeFilename.'-'.uniqid().'.'.$screen->guessExtension();

                try {
                    $screen->move(
                        $this->getParameter('projet_directory'),
                        $newScreen
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $techno->setImage($newScreen);
            }

            $entityManager = $doctrine->getManager();

            $techno = $form->getData();

            $entityManager->persist($techno);

            $entityManager->flush();

            return $this->redirectToRoute('techno', [
                'id' => $techno->getId()]);
        }

        return $this->render('techno/update-techno.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-techno/{id}', name: 'delete_techno')]
    public function delete(TechnoRepository $technoRepository, Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $techno = $technoRepository->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($techno);
        $entityManager->flush();
        return $this->redirectToRoute('techno');
    }
}
