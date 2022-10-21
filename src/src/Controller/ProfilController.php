<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    public function seeProfil(User $user)
    {

        return $this->render('profil/index.html.twig', [
            'myAnnonces' => $user->getAnnonces(),
            'information' => $user
        ]);
    }
}
