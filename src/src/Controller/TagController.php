<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    public function tagInAnnonce(Annonce $annonce, Request $request, TagRepository $tagRepository): Response
    {
        $tag = new Tag();
        $formTag = $this->createForm(TagType::class, $tag);
        $formTag->handleRequest($request);
        if ($formTag->isSubmitted() && $formTag->isValid()) {
            $tag->addAnnonce($annonce);
            $tagRepository->save($tag, true);
        }

        return $this->render('tag/index.html.twig', [
            'formTag' => $formTag->createView()
        ]);
    }

    #[Route('/tags/{nom}', name: 'app_annonces_tags')]
    public function annoncesTags(Tag $tag, TagRepository $tagsRepository, $nom): Response
    {
        /*         dd($tag->getAnnonces()); */


        return $this->render('tag/index.html.twig', [
            'annonces' => $tag->getAnnonces(),
            'NameTag' => $nom,

        ]);
    }
}
