<?php

namespace App\Controller;

use App\Entity\Accueil;
use App\Repository\AccueilRepository;

use App\Form\AccueilType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/accueil")
     */
    
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_index")
     */
    public function index(): Response
{
    $repo= $this->getDoctrine()->getRepository(Accueil::class);
        $accueil = $repo->findAll();
        return $this->render('accueil/index.html.twig', [
            'accueil_name' => 'PAGE D ACCUEIL : ',
        'accueil'  => $accueil,
        ]);
    }




}
