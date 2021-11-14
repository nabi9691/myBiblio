<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;

use App\Form\AdminType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/admin")
     */
    
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(): Response
    {
        $repo= $this->getDoctrine()->getRepository(Admin::class);
        $admin = $repo->findAll();
        
        return $this->render('admin/index.html.twig', [
            'admin_name' => 'ESPACE ADMINISTRATEUR :',
                        'admin' => $admin,
        ]);
    }

/**
* @Route("/new", name="new_administrateur", methods={"GET", "POST"})
      */
      public function new(Request $request, EntityManagerInterface $em): Response
      {
  
         $admin = new Admin();
  
         $admin->setNom("Nom de l'administrateur ");
         $admin->setPrenom("Prenom de l'administrateur ");
         $admin->setLogin("Login de l'administrateur ");
         $admin->setPassword(" Le mot de passe de l'administrateur ");


      $em->persist($admin);
             $em->flush();
  
         return $this->render('admin/nouvelAdmin.html.twig', [
  'administrateur_name' => 'NOUVEL ADMINISTRATEUR :',
          'administrateur' => $admin,
         ]);
  }
  
    /**
     * @Route("/form", name="form_administrateur")
    */
    public function pageForm(Request $request, EntityManagerInterface $manager)
    {
    
        $admin =new Admin(); 

        $form = $this->createFormBuilder($admin) 
                    
        ->add('nom')
                    ->add('prenom')
                    ->add('login')
                    ->add('password')
                    
            
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($admin); 
            $manager->flush();
    
                return $this->redirectToRoute('admin_index', 
        
            ['id'=>$admin->getId(),
        ]);
    } 
        
            return $this->render('admin/newAdmin.html.twig',[
            "formAdmin" => $form->createView(),
        ]);
    }


    /**
     * @Route("/formtype", name = "formType_administrateur", methods={"GET","POST"})
     */
public function formtype(Request $request): Response
{
    $admin = new Admin();
    $form = $this->createForm(AdminType::class, $admin);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($admin);
        $entityManager->flush();

        return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin/newAdmin.html.twig', [
        'administrateur' => $admin,
        'formAdmin' => $form->createView(),
    ]);
}

/**
     * @Route("/forminscription", name="form_inscription")
    */
    public function formInscription(Request $request, EntityManagerInterface $manager)
    {
    
        $admin =new Admin(); 

        $form = $this->createFormBuilder($admin) 
                    
        ->add('nom')
                    ->add('prenom')
                    ->add('login')
                    ->add('password')
                    
            
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($admin); 
            $manager->flush();
    
                return $this->redirectToRoute('utilisateur_index', 
        
            ['id'=>$admin->getId(),
        ]);
    } 
        
            return $this->render('users/newUtilisateur.html.twig',[
            "formUtilisateur" => $form->createView(),
        ]);
    }

    /**
     * @Route("/formconnection", name="form_connection")
    */
    public function formConnection(Request $request, EntityManagerInterface $manager)
    {
    
        $admin =new Admin(); 

        $form = $this->createFormBuilder($admin) 
                    
        ->add('nom')
                    ->add('prenom')
                    ->add('login')
                    ->add('password')
                    
            
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($admin); 
            $manager->flush();
    
                return $this->redirectToRoute('utilisateur_index', 
        
            ['id'=>$admin->getId(),
        ]);
    } 
        
            return $this->render('users/newUtilisateur.html.twig',[
            "formUtilisateur" => $form->createView(),
        ]);
    }




    }
