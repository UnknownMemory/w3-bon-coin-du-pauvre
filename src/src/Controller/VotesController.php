<?php

namespace App\Controller;

use App\Entity\Votes;
use App\Form\VoteFormType;
use App\Repository\VotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/votes')]
class VotesController extends AbstractController
{
    #[Route('/voter/{vendeurID}', name: 'app_votes', methods:['POST'])]
    public function vote(Request $request, Security $security, VotesRepository $votesRepository, $vendeurID): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_all');
        }

        $user = $security->getUser();
        $vote = $votesRepository->findOneBy([
            'user' => $user,
            'vendeur' => $vendeurID,
        ]);


        if($vote == null){
            $vote = new Votes();
        }
        
        $form = $this->createForm(VoteFormType::class, $vote);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $vote->setAVoter($form->get('aVoter')->getData());

            if(($vote->getVendeur() && $vote->getUser()) == null){
                $vote->setVendeur($vendeurID);
                $vote->setIdUser($user);
            }

            $votesRepository->save($vote, true);

            return $this->redirectToRoute($request->header->get('referer'));
        }
    }
}