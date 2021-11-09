<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
 use Faker;


class CategoriesFixtures extends Fixture
{
   public function load(ObjectManager $manager): void
    {
        for ($j=0; $j<50 ; $j++ ) 
      { 
          
          
$categories = new Categories();
                    
$categories ->setTitre(" LeTitre de ma catégorie ");
$categories ->setContenu(" Le Contenu de ma catégorie, Le Contenu de ma catégorie, Le Contenu de ma catégorie, Le Contenu de ma catégorie, Le Contenu de ma catégorie    ");
$categories   ->setDate(new  \DateTime());
$categories   ->setImage(" Image de mon Article ");
$categories ->setAction(" L'action de ma catégorie ");


                  $manager->persist($categories);
$manager->flush();
    }
}
}
