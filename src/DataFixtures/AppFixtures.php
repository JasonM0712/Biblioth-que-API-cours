<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $livre = [
            ['Les Misérables','1234567890123',1862,'Livre de jean Valjean crée une grande émotion'],
            ['Le Comte de Monte-Cristo','1234567890124',1844,'Livre intrigue vengeance et justice'],
            ['Madame Bovary','1234567890125',1856,'Livre sur la vie d\'Emma Bovary'],
        ]; 

        foreach ($livre as [$titre, $isbn, $annee, $resume]) {

            $livre = (new Livre())
                ->setTitre($titre)
                ->setIsbn($isbn)
                ->setAnneePublication($annee)
                ->setResume($resume);

            $manager->persist($livre);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
