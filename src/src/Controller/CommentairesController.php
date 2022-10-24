<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaires;
use App\Form\CommentaireType;
use App\Repository\CommentairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends AbstractController
{
    public function commentaireInAnnonce(Annonce $annonce, Request $request, CommentairesRepository $commentairesRepository): Response
    {
        $comment = new Commentaires();
        $formCommentaire = $this->createForm(CommentaireType::class, $comment);
        $formCommentaire->handleRequest($request);
        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid()) {
            $comment->setIdUser($this->getUser());
            $comment->setAnnonce($annonce);
            $comment->setDatePublication(new \DateTime());
            $commentairesRepository->save($comment, true);
        }

            return $this->render('commentaires/index.html.twig', [
                "formCommentaire" => $formCommentaire->createView()
            ]);
    }
}
