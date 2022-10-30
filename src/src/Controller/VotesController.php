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

    #[Route('/all/{vendeurID}', name: "app_get_votes")]
    public function getVotes(Request $request,  UserRepository $userRepository, VotesRepository $votesRepository, int $vendeurID): JsonResponse
    {
        $vendeur = $userRepository->findOneBy(array('id' => $vendeurID));
        $totalVotes = $votesRepository->findBy(array('vendeur' => $vendeur));
        
        $positiveVotes = array_filter($totalVotes, function($vote) {
            return $vote->isAVoter() == true;
        });

        return new JsonResponse(['total_votes' => count($totalVotes), 'positive_votes' => count($positiveVotes)]);
    }

    #[Route('/get/{vendeurID}', name: "app_get_user_vote")]
    public function getVote(Security $security, Request $request,  UserRepository $userRepository, VotesRepository $votesRepository, int $vendeurID): JsonResponse
    {
        $user = $security->getUser();
        $vendeur = $userRepository->findOneBy(array('id' => $vendeurID));
        $vote = $votesRepository->findOneBy(array(
            'vendeur' => $vendeur, 
            'idUser' => $user->getId()
        ));
        
        $response = new JsonResponse(['vote' => $vote->isAVoter(), 'customer' => $vote->getIdUser()->getId(), 'vendeur' => $vote->getVendeur()->getId()]);
        return $response;
    }

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
            $vote->setIdUser($user);
        }
        
        $votesRepository->save($vote, true);
     
        $response = new JsonResponse(['vote' => $vote->isAVoter(), 'customer' => $vote->getIdUser()->getId(), 'vendeur' => $vote->getVendeur()->getId()]);
        return $response;
        
    }
}