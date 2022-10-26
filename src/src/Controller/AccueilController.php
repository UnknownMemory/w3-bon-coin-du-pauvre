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
            'lastAnnonces' => $annonceRepository->findEightLastAnnoncement(), // En attente de User et annonces
            'PopularTags' => $tags->findFourMostUsedTags(), // OK
            'SearchForm' => $searchBar->createView(), // ok
            'annonces' => $annonceRechercher, //

        ]);
    }

    /* A METTRE DANS LE CONTROLLER DES TAGS UNE FOIS CELUI-CI RECUPERER | ET SERA À MODIFIER !!! */

    #[Route('/tags/{nom}', name: 'app_annonces_tags')]
    public function annoncesTags(Tag $tag): Response
    {

        /*         dd($tag->getAnnonces()); */
        /*  foreach ($tag->getAnnonces() as $annonce) {
            dd($annonce);
        } */

        return $this->render('tags/index.html.twig', [
            'annoncesTags' => $tag->getAnnonces(),
        ]);
    }
}
