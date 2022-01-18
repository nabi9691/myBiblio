<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{

// LISTE DES COMMENTAIRES :
/**
    * @Route("commentaire", name="commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaire' => $commentaireRepository->findAll(),
        ]);
    }

    // RECHERCHER UN COMMENTAIRE :
/**
     * @Route("/rechercherCommentaire/{id}", name="rechercherCommentaire_index", methods={"GET","POST"})
     */
    public function rechercheCommentaire(CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = $commentaireRepository-> findByCommentaire();
    return $this->render('commentaire/rechercherCommentaire.html.twig', [
        'id' => $commentaire ->getId(),
        'commentaire' => $commentaire,
    ]);
}

// FORMULAIRE D'UN COMMENTAIRE :
/**
     * @Route("/formulaireCommentaire", name = "formulaireCommentaire_index", methods={"GET","POST"})
     */
    public function formulaireCommentaire(Request $request): Response
    {
        $commentaire = new Commentaire();
        
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/formulaireCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'formCommentaire' => $form->createView(),
        ]);
    }

    // AJOUTER UN NOUVEL COMMENTAIRE :
/**
     * @Route("/nouvelCommentaire", name="nouvelCommentaire_index", methods={"GET","POST"})
     */
    public function nouvelCommentaire(Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/nouvelCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'formCommentaire' => $form->createView(),
        ]);
    }

    // AFFICHER UN COMMENTAIRE :

    /**
     * @Route("/afficherCommentaire/{id}", name="afficherCommentaire_index", methods={"GET"})
     */
    public function afficherCommentaire(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/afficherCommentaire.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

// MODIFIER UN COMMENTAIRE :
    /**
     * @Route("/modifierCommentaire/{id}", name="modifierCommentaire_index", methods={"GET","POST"})
     */
    public function modifierCommentaire(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$this->getDoctrine()->getManager()->flush();

            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/modifierCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'formCommentaire' => $form->createView(),
        ]);
    }

// SUPPRESSION D'UN COMMENTAIRE :
    /**
     * @Route("/supprimerCommentaire/{id}" , name="supprimerCommentaire_index", methods= {"GET","POST"})
     */
    public function supprimerCommentaire(Request $request, Commentaire $commentaire , EntityManagerInterface $entityManager) : Response 
    {           
            $entityManager->remove($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('commentaire_index'); 
    }

    


}
