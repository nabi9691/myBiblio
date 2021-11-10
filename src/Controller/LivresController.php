<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use App\Repository\LivresRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("livres")
     */
    
class LivresController extends AbstractController
{
    /**
     * @Route("/", name="livre_index")
     */
    public function index(): Response
    {
        $repo= $this->getDoctrine()->getRepository(Livres::class);
        $livres = $repo->findAll();
        return $this->render('livres/index.html.twig', [
            'controller_name' => 'LivresController',
'livres' => $livres,
        ]);
    }

    /**
     * @Route("/new", name="new_livre", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
$livres = new Livres();

$livres->setDate(new  \DateTime());
 $livres->setTitre(" Le titre de mon livre");
        $livres->setHauteur("  l'auteur de mon livre");
 $livres->setResume("  Le résumé de mon livre");
 $livres->setContenu("  Le contenu de mon livre");
 $livres->setCommentaires("  Les commentaires de mon livre"); 

       $em->persist($livres);
           $em->flush();

       return $this->render('livres/nouvelLivre.html.twig', [
           'livre' => $livres,
       ]);
}    

    /**
* @Route("/newpageform", name="newpageform_livre")
    */
    public function pageForm(Request $request, EntityManagerInterface $manager)
    {
    

        $livres = new Livres();

        $form = $this->createFormBuilder($livres) 
        ->add('date')
->add('titre')
        ->add('hauteur')
        ->add('resume')
                    ->add('contenu')
                                        ->add('commantaires')
                    
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($livres); 
            $manager->flush();
    
                return $this->redirectToRoute('newpageform_livre', 
        
            ['id'=>$livres->getId(),
        ]);
    } 
        
        
            return $this->render('livres/nouvelLivre.html.twig',[
            "formLivre" => $form->createView(),
        ]);
    }




}
