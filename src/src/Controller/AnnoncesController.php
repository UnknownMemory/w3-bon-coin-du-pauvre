<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Service\SlugService;
use App\Form\CreationAnnonceType;
use App\Service\UploadImageService;
use App\Repository\AnnonceRepository;
use App\Service\RedirectToService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonces')]
class AnnoncesController extends AbstractController
{

    public function __construct(Security $security, AnnonceRepository $annoncesRepository)
    {
        $this->security = $security;
        $this->annoncesRepository = $annoncesRepository;
    }

    #[Route('/', name: 'app_all')]
    public function index(): Response
    {
        return $this->render('annonces/index.html.twig', [
            'allAnnonces' => $this->annoncesRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_creation', methods: ["GET", "POST"])]
    public function creationAnnonces(Request $request, SlugService $slugService, UploadImageService $upload): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $annonce = new Annonce();
        $form = $this->createForm(CreationAnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form['images']->getData();
            /* On utilise notre service pour upload l'image et on lui passe en parametre les données de nos images, le nom du site, et l'endroit ou l'on veut upload les images*/
            $arrayImage = $upload->upload($images, "-le-bon-coin-du-pauvre", '/public/assets/img/upload');
            /* On utilise la méthode setImage pour enregistrer les noms des images dans BDD (ici sous forme de tableau) */
            $annonce->setImages($arrayImage);

            $annonce->setVendeur($this->getUser());
            $annonce->setDate(new \DateTime());
            $annonce->setSlug($slugService->getSlug($annonce));
            $this->annoncesRepository->save($annonce, true);
        }

        return $this->render('annonces/creationAnnonce.html.twig', [
            'creationAnnonce' => $form->createView(),
        ]);
    }


    #[Route('/modification/{annonce_id}', name: 'app_modify', methods: ["GET", "POST"])]
    public function modificationAnnonces(Request $request, int $annonce_id, RedirectToService $redirectTo): Response
    {
        $user = $this->security->getuser();

        if(!$user){
            return $this->redirectToRoute('app_all');
        }

        $annonce = $this->annoncesRepository->find($annonce_id);
        $form = $this->createForm(CreationAnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($user->getId() != $annonce->getVendeur()->getId()) {
                return $this->redirectToRoute('app_all');
            }

            $annonce->setTitre($form->get('titre')->getData());
            $annonce->setDescription($form->get('description')->getData());
            $this->annoncesRepository->save($annonce, true);

            $redirectURL = $redirectTo->getRedirectURL($request);
            return $this->redirect($redirectURL);
        }

        return $this->renderForm('annonces/modification.html.twig', [
            'annonceForm' => $form,
            'nameAnnonce' => $annonce->getTitre(),
        ]);
        
    }



    #[Route('/{slug}', name: 'app_oneannonce')]
    public function oneAnnonce(Annonce $annonce): Response
    {
        return $this->render('annonces/oneAnnonce.html.twig', [
            'oneAnnonce' => $annonce,
        ]);
    }

    #[Route('/delete/{annonce_id}', name: 'app_delete')]
    public function deleteAnnonces(Request $request, int $annonce_id, RedirectToService $redirectTo): Response
    {
        $userID = $this->security->getUser()->getId();
        $annonce = $this->annoncesRepository->find($annonce_id);
        if ($userID && $userID == $annonce->getVendeur()->getId()) {
            $this->annoncesRepository->remove($annonce, true);

            $redirectURL = $redirectTo->getRedirectURL($request);
            return $this->redirect($redirectURL);
        }
    }
}
