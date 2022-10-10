<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Entity\Annonces;
use App\Repository\TagsRepository;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(AnnoncesRepository $annonces, TagsRepository $tags, EntityManagerInterface $entityManager): Response
    {

        /* ajout de tags en brute */
        /*       $tag = new Tags();
        $tag->setNom('eclairage');
        $entityManager->persist($tag);
        $entityManager->flush(); */


        return $this->render('index.html.twig', [
            'lastAnnonces' => $annonces->findSixtLastAnnoncement(), // En attente de User et annonces
            'PopularTags' => $tags->findFourMostUsedTags(), // OK
        ]);
    }
}
