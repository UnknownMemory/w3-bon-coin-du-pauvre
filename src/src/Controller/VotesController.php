<?php
namespace App\Controller;

use App\Entity\Votes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VotesController extends AbstractController
{
    #[Route('/votes/{userID}', name: 'app_votes', methods:['POST'])]
    public function vote(Request $request, $userID): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_all');
        }
       
    }
}