<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/users")
     */
    
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="utilisateur_index")
     */
    public function index(): Response
    {
        $repo= $this->getDoctrine()->getRepository(Users::class);
        $users = $repo->findAll();
        return $this->render('users/index.html.twig', [
            'utilisateur_name' => 'UsersController',
'user' => $users,
        ]);
    }

    /**
     * @Route("/new", name="new_utilisateur", methods={"GET", "POST"})
     */
     public function new(Request $request, EntityManagerInterface $em): Response
     {

        $users = new Users();

        $users->setNom(" Le nom de mon utilisateur ");
        $users->setPrenom(" Le prenom de mon utilisateur ");
        $users->setDatedenaissance(" La date de naissance de mon utilisateur ");
        $users->setAdresse(" L'adresse de mon utilisateur ");
                        $users->setLogin(" Le login de mon utilisateur ");
                $users->setPassword(" Le mot de passe de mon utilisateur ");
        $users->setPhoto(" La photo de mon utilisateur ");
        $users->setEmail(" L'email de mon utilisateur ");
        $users->setRole(" Le Rôle de mon utilisateur ");
        $users->setLocataire("Mon locataire ");
        $users->setProprietaire(" Mon propriétaire");
        $users->setgestionnaire(" Mon gestionnaire ");
        
        $em->persist($users);
        $em->flush();

        return $this->render('users/newUtilisateur.html.twig', [
            'users' => $users,
        ]);
}

/**
     * @Route("/newpageform", name="newpageform_utilisateur")
    */
    public function pageForm(Request $request, EntityManagerInterface $manager)
    {
    
        $users =new Users(); 

        $form = $this->createFormBuilder($users) 
                    
        ->add('nom')
                    ->add('prenom')
                    ->add('login')
                    ->add('password')
                    
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($users); 
            $manager->flush();
    
                return $this->redirectToRoute('utilisateur_index', 
        
            ['id'=>$users->getId(),
        ]);
    } 
        
        
            return $this->render('articles/newUtilisateur.html.twig',[
            "formUtilisateur" => $form->createView(),
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
    
