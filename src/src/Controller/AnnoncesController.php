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

    #[Route('/creation', name: 'app_creation')]
    public function creationAnnonces(AnnoncesRepository $annoncesRepository): Response {
       return $this->render('annonces/creationAnnonce.html.twig');
    }

    #[Route('/delete', name: 'app_delete')]
    public function deleteAnnonces(AnnoncesRepository $annoncesRepository, Annonces $annonces ): Response {
        return $this->redirect('annonces/index.html.twig', [
                'deleteAnnonces'=> $annoncesRepository->remove($annonces),
        ]);
    }

}
