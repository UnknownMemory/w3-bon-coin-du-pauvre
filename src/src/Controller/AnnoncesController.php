<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\CreationAnnonceType;
use App\Repository\AnnonceRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function creationAnnonces(EntityManagerInterface $em, Request $request): Response
    {
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
                $this->annoncesRepository->save($annonce, true);
            }
            return $this->render('annonces/creationAnnonce.html.twig', [
                'creationAnnonce' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_all');
        }
    }

    #[Route('/modification/{annonce_id}', name:'app_modify', methods:["GET", "POST"])]
    public function modificationAnnonces(Request $request, int $annonce_id): Response
    {
        if($this->security->getuser()){
            $annonce = $this->annoncesRepository->find($annonce_id);
            $form = $this->createForm(CreationAnnonceType::class, $annonce);

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $annonce->setTitre($form->get('titre')->getData());
                $annonce->setDescription($form->get('description')->getData());
                $this->annoncesRepository->save($annonce, true);

                return $this->redirectToRoute('app_accueil');
            }
    
            return $this->renderForm('annonces/modification.html.twig', [
                'annonceForm' => $form,
            ]);
        }

    }

    #[Route('/delete/{annonce_id}', name: 'app_delete')]
    public function deleteAnnonces(int $annonce_id): Response
    {
        $userID = $this->security->getUser()->getId();
        $annonce = $this->annoncesRepository->find($annonce_id);
        if ($userID && $userID == $annonce->getVendeur()->getId()) {
            $this->annoncesRepository->remove($annonce, true);
            return $this->redirectToRoute('app_acceuil');
        }
    }
}
