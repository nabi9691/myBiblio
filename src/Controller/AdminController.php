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
            'admin_name' => 'AdminController',
        'admin' => $admin,
        ]);
    }

/**
     * @Route("/newpageform", name="newpageform_admin")
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


}
