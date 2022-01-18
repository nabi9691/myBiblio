<?php

namespace App\DataFixtures;

use Faker; 
use App\Entity\Commentaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class CommentaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

         // Creer occurence de 500 commentaires :
        
         for ($i=0; $i<500 ; $i++ ) 
        { 
        
        $commentaire = new Commentaire();
        

        
        $commentaire->setDate(new \DateTime())
                        ->setContenu($faker->sentence())
->setAuteurs($faker->sentence());
        
        
$manager->persist($commentaire);

        $manager->flush();
    }
    }
}
