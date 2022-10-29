<?php

namespace App\Controller;

use App\Entity\Votes;
use App\Repository\UserRepository;
use App\Repository\VotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/votes')]
class VotesController extends AbstractController
{
    #[Route('/process/{vendeurID}', name: 'app_votes')]
    public function vote(Request $request, Security $security, VotesRepository $votesRepository, UserRepository $userRepository, int $vendeurID): JsonResponse
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_all');
        }

        $user = $security->getUser();
        $vendeur = $userRepository->findOneBy(array('id' => $vendeurID));
        $vote = $votesRepository->findOneBy(array(
            'idUser' => $user->getId(),
            'vendeur' => $vendeur,
        ));

        if($vote == null){
            $vote = new Votes();
        }

        $vote->setAVoter($request->get('aVoter'));

        if(($vote->getVendeur() && $vote->getUser()) == null){
            $vote->setVendeur($vendeur);
            $vote->setIdUser($user->getId());
        }
        
        $votesRepository->save($vote, true);
     
        $response = new JsonResponse(['vote' => $vote->isAVoter(), 'customer' => $vote->getIdUser(), 'vendeur' => $vote->getVendeur()->getId()]);
        return $response;
        
    }
}