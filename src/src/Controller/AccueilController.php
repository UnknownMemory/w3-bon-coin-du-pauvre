<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\SearchType;
use App\Repository\TagRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request, AnnonceRepository $annonceRepository, TagRepository $tags): Response
    {
        /* Gestion de la barre de recherche */
        $annonceRechercher = [];
        $searchBar = $this->createForm(SearchType::class);
        if ($searchBar->handleRequest($request)->isSubmitted() && $searchBar->isValid()) {
            $search = $searchBar->getData();
            /* dd($search); */
            $annonceRechercher = $annonceRepository->searchAnonces($search['search']);
        }

        return $this->render('index.html.twig', [
            'lastAnnonces' => $annonceRepository->findSixtLastAnnoncement(), // En attente de User et annonces
            'PopularTags' => $tags->findFourMostUsedTags(), // OK
            'SearchForm' => $searchBar->createView(), // ok
            'annonces' => $annonceRechercher, //

        ]);
    }
}
