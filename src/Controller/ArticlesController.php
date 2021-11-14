<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;

use App\Form\ArticlesType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("articles")
     */
    
     class ArticlesController extends AbstractController
    {
    /**
     * @Route("/", name="article_index")
     */

    public function index(): Response
    {   
        $repo= $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repo->findAll();
        return $this->render('articles/index.html.twig', [
            'article_name' => 'ARTICLES :',
            'articles' => $articles,
        ]);
    }
    
/**
* @Route("/new", name="new_article", methods={"GET", "POST"})
      */
    public function new(Request $request, EntityManagerInterface $em): Response
    {

       $articles = new Articles();

       $articles->setTitre(" Titre de mon Article");
       $articles->setContenu(" Contenu de mon Article Contenu de mon ArticleContenu de mon ArticleContenu de mon ArticleContenu de mon Article");
       $articles->setResume(" Titre de mon Article");
       $articles->setDate(new  \DateTime());
       $articles->setImage(" Image de mon Article ");
       
    $em->persist($articles);
           $em->flush();

       return $this->render('articles/nouvelArticle.html.twig', [
'article_name' => 'NOUVEL ARTICLE :',
        'articles' => $articles,
       ]);
}


    /**
     * @Route("/form", name="form_article")
    */
    public function pageForm(Request $request, EntityManagerInterface $manager)
    {
    
        $articles =new Articles(); 

        $form = $this->createFormBuilder($articles) 
                    
        ->add('titre')
                    ->add('resume')
                    ->add('contenu')
                    ->add('date')
                    ->add('image')

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($articles); 
            $manager->flush();
    
                return $this->redirectToRoute('article_index', 
        
            ['id'=>$articles->getId(),
    ]);
    } 
        
        
            return $this->render('articles/newArticle.html.twig',[
            'article_name' => 'FORMULAIRE CONTROLLER',
                "formArticle" => $form->createView(),
        ]);
    }

    /**
     * @Route("/formtype", name = "formType_index", methods={"GET","POST"})
     */
public function newwithformtype(Request $request): Response
    {
        $articles = new Articles();
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/newArticle.html.twig', [
            'article' => $articles,
            'formArticle' => $form->createView(),
        ]);
    }
    



}
    