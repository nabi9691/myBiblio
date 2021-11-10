<?php

namespace App\Controller;

use App\Entity\Locations;
use App\Form\LocationsType;
use App\Repository\LocationsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("locations")
     */
    
class LocationsController extends AbstractController
{
    /**
     * @Route("/", name="location_index")
     */
    public function index(): Response
    {
        $repo= $this->getDoctrine()->getRepository(Locations::class);
        $locations = $repo->findAll();
        return $this->render('locations/index.html.twig', [
            'controller_name' => 'LocationsController',
'locations' => $locations,
        ]);
    }


    /**
     * @Route("/new", name="new_location", methods={"GET", "POST"})
     */
     public function new(Request $request, EntityManagerInterface $em): Response
     {

        $locations = new Locations();

        $locations->setDate(new  \DateTime());
        $locations->setTitre(" Titre de ma location");
        $locations->setCategories(" Categorie de ma location");
        $locations->setImage(" L'image de ma location");
        $locations->setDescription(" Description de ma location");
        $locations->setValeur(" La valeur de ma location");
        $locations->setAdresse(" L'adresse de ma location");
        $locations->setAccessibility(" L'accessibilité de ma location");
        $locations->setStatuts(" Statuts de ma location");
        $locations->setAlaune(" à la une de ma location");
        
        $em->persist($locations);
        $em->flush();

        return $this->render('locations/nouvelleLocation.html.twig', [
            'location' => $locations,
        ]);
}

/**
     * @Route("/newpageform", name="newpageform_location")
    */
    public function pageForm(Request $request, EntityManagerInterface $manager)
    {
        $locations =new Locations(); 

        $form = $this->createFormBuilder($locations) 
                    
        ->add('titre')
        ->add('date')
        ->add('image')
                            ->add('adresse')
                    ->add('statuts')
                    

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($locations); 
            $manager->flush();
    
                return $this->redirectToRoute('newpageform_location', 
        
            ['id'=>$locations ->getId(),
        ]);
    } 
        
        
            return $this->render('locations/newLocation.html.twig',[
            "formLocation" => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/newwithformtype", name="newwithform", methods={"GET","POST"})
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

            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/new.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }






}
