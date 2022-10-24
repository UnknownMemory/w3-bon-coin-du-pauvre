<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Images;
use App\Entity\Tag;
use App\Form\CreationAnnonceType;
use App\Repository\AnnonceRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonces')]
class AnnoncesController extends AbstractController {

    #[Route('/', name: 'app_all')]
    public function index(AnnonceRepository $annoncesRepository ): Response {
        return $this->render('annonces/index.html.twig', [
            'allAnnonces' => $annoncesRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_creation', methods: ["GET", "POST"])]
    public function creationAnnonces(AnnonceRepository $annonceRepository, EntityManagerInterface $em, Request $request): Response {
        if ($this->getUser()) {
            $slugify = new Slugify();
            $annonce = new Annonce();
            $form = $this->createForm(CreationAnnonceType::class, $annonce);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $annonce->setVendeur($this->getUser());
                $annonce->setDate(new \DateTime());
                $slug = $slugify->slugify($annonce->getTitre());
                $annonce->setSlug($slug);
                $annonceRepository->save($annonce, true);
            }
            return $this->render('annonces/creationAnnonce.html.twig', [
                'creationAnnonce' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_all');
        }

    }

    #[Route('/delete/{annonce_id}', name: 'app_delete')]
    public function deleteAnnonces(AnnonceRepository $annoncesRepository, int $annonce_id): Response {
        $annonce = $annoncesRepository->find($annonce_id);
        $annoncesRepository->remove($annonce);
        return $this->redirectToRoute('app_accueil');
    }



}
