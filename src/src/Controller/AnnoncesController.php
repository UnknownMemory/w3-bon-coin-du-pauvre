<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonces')]
class AnnoncesController extends AbstractController {

    #[Route('/', name: 'app_all')]
    public function index(AnnoncesRepository $annoncesRepository ): Response {
        return $this->render('annonces/index.html.twig', [
           'allAnnonces' => $annoncesRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_creation', methods: ["GET", "POST"])]
    public function creationAnnonces(AnnoncesRepository $annoncesRepository): Response {
        $form = $this->createForm(CreationAnnonceType::class);
       return $this->render('annonces/creationAnnonce.html.twig', [
           'creationAnnonce' => $form->createView(),
       ]);
    }

    #[Route('/delete/{annonce_id}', name: 'app_delete')]
    public function deleteAnnonces(AnnoncesRepository $annoncesRepository, int $annonce_id): Response
    {
        $annonce = $annoncesRepository->find($annonce_id);
        $annoncesRepository->remove($annonce);
        return $this->redirectToRoute('app_accueil');
    }

}
