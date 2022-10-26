<?php

namespace App\Controller;

use App\Entity\Annonce;
use Cocur\Slugify\Slugify;

use App\Entity\Commentaires;
use App\Form\CommentaireType;
use App\Form\CreationAnnonceType;
use App\Service\UploadImageService;
use App\Repository\AnnonceRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonces')]
class AnnoncesController extends AbstractController
{

    #[Route('/', name: 'app_all')]
    public function index(AnnonceRepository $annoncesRepository): Response
    {
        return $this->render('annonces/index.html.twig', [
            'allAnnonces' => $annoncesRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_creation', methods: ["GET", "POST"])]
    public function creationAnnonces(AnnonceRepository $annonceRepository, Request $request, UploadImageService $upload): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_all');
        }
        $slugify = new Slugify();
        $min = 1;
        $max = 99999;
        $genrateInt = rand($min, $max);
        $annonce = new Annonce();
        $form = $this->createForm(CreationAnnonceType::class, $annonce);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            /* Gestion des images */
            /* On récupérer les différentes images */
            $images = $form['images']->getData();
            /* On utilise notre service pour upload l'image et on lui passe en parametre les données de nos images, le nom du site, et l'endroit ou l'on veut upload les images*/
            $arrayImage = $upload->upload($images, "-le-bon-coin-du-pauvre", '/public/assets/img/upload');
            /* On utilise la méthode setImage pour enregistrer les noms des images dans BDD (ici sous forme de tableau) */
            $annonce->setImages($arrayImage);
            $annonce->setVendeur($this->getUser());
            $annonce->setDate(new \DateTime());
            $slug = $slugify->slugify($annonce->getTitre() . '-' . $genrateInt);
            $annonce->setSlug($slug);
            $annonceRepository->save($annonce, true);
        }
        return $this->render('annonces/creationAnnonce.html.twig', [
            'creationAnnonce' => $form->createView(),
        ]);
    }

    #[Route('/delete/{annonce_id}', name: 'app_delete')]
    public function deleteAnnonces(AnnonceRepository $annoncesRepository, int $annonce_id): Response
    {
        $annonce = $annoncesRepository->find($annonce_id);
        $annoncesRepository->remove($annonce);
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/{slug}', name: 'app_oneannonce')]
    public function oneAnnonces(Annonce $annonce): Response
    {
        return $this->render('annonces/oneAnnonce.html.twig', [
            'oneAnnonce' => $annonce
        ]);
    }
}
