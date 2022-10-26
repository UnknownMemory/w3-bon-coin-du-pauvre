<?php

namespace App\Controller;

use App\Entity\Annonce;

use App\Entity\Images;

use App\Form\CreationAnnonceType;
use App\Service\SlugService;
use App\Service\UploadImageService;
use App\Repository\AnnonceRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function creationAnnonces(AnnonceRepository $annonceRepository, Request $request, SlugService $slugService, UploadImageService $upload): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_all');
        }
        $annonce = new Annonce();
        $form = $this->createForm(CreationAnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form['images']->getData();

            /* Gestion des images */
            /* On récupérer les différentes images */
            $images = $form['images']->getData();
            /* On utilise notre service pour upload l'image et on lui passe en parametre les données de nos images, le nom du site, et l'endroit ou l'on veut upload les images*/
            $arrayImage = $upload->upload($images, "-le-bon-coin-du-pauvre", '/public/assets/img/upload');
            /* On utilise la méthode setImage pour enregistrer les noms des images dans BDD (ici sous forme de tableau) */
            $annonce->setImages($arrayImage);

            $annonce->setVendeur($this->getUser());
            $annonce->setDate(new \DateTime());
            $annonce->setSlug($slugService->getSlug($annonce));
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
