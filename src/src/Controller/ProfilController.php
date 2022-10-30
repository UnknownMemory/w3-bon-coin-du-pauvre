<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\RegistrationFormType;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class ProfilController extends AbstractController
{
    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    #[Route('/profil/{id}', name: 'app_profil')]
    public function seeProfil(User $user)
    {

        return $this->render('profil/index.html.twig', [
            /* Récupere les annonces de l'utilisateur */
            'myAnnonces' => $user->getAnnonces(),
            /* Récupere les informations de l'utilisateur */
            'information' => $user,
            /* Récupere les commentaires de l'utilisateur */
            'lastCommentaires' => $user->getIdCommentaires()
        ]);
    }

    #[Route('/modification/{id}', name:'app_modif', methods: ["GET", "POST"])]
    public function modificationUser(Request $request, int $user_id): Response {
        if($this->security->getUser()) {
            $user = $this->userRepository->find($user_id);
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $user->setNom($form->get('nom')->getData());
                $user->setPrenom($form->get('prenom')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setPassword($form->get('plainPassword')->getData());
                $this->userRepository->save($user, true);

                return $this->redirectToRoute('app_accueil');
            }
            return $this->renderForm('profil/modification.html.twig', [
                'userForm' => $form,
            ]);
        }
    }

}
