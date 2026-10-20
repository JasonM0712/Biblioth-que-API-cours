<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nomAuteurs = [
            'Victor Hugo', 
            'Alexandre Dumas', 
            'Gustave Flaubert'
        ];

        $auteurs = [];

        foreach ($nomAuteurs as $nom) {
            $auteur = (new Auteur())
                ->setNom($nom);
                $manager->persist($auteur);
                $auteurs[$nom] = $auteur;
        }

        $livre = [
            ['Les Misérables','1234567890123',1862,'Livre de jean Valjean crée une grande émotion','Victor Hugo'],
            ['Le Comte de Monte-Cristo','1234567890124',1844,'Livre intrigue vengeance et justice','Alexandre Dumas'],
            ['Madame Bovary','1234567890125',1856,'Livre sur la vie d\'Emma Bovary','Gustave Flaubert'],
        ]; 

 
        foreach ($livre as [$titre, $isbn, $annee, $resume, $auteur]) {

            $livre = (new Livre())
                ->setTitre($titre)
                ->setIsbn($isbn)
                ->setAnneePublication($annee)
                ->setResume($resume)
                ->setAuteur($auteurs[$auteur]);
            $manager->persist($livre);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
