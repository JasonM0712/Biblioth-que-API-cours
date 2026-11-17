<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/livres', name: 'app_livre')]

final class LivreController extends AbstractController
{
    #[Route('/', name: 'livre_liste', methods: ['GET']), ]
    public function index(LivreRepository $livreRepository): JsonResponse
    {
        $livres = $livreRepository->findAll();

        return $this->json(
            $livres, 
            200,
            [],
            ['groups' => 'livre:lecture'],
        );
    }

    #[Route('/{id}', name: 'livre_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(LivreRepository $livreRepository, int $id): JsonResponse
    {
        $livre = $livreRepository->find($id);

        if (!$livre) {
            return $this->json(['erreur' => 'Livre non trouvé'], 404);
        }

        return $this->json(
            $livre,
            200,
            [],
            ['groups' => 'livre:lecture']
        );

    }

#[Route('/', name: 'livre_creation', methods: ['POST'])]
public function creation( Request $request, DenormalizableInterface $denormalizer, ValidatorInterface $validator, AuteurRepository $auteurRepository, EntityManagerInterface $em) : JsonResponse {
        
        $donnees = $request->toArray();

        try {
            $livre = $denormalizer->denormalize($donnees, Livre::class, null, ['groups' => 'livre:ecriture']);
        } catch (NotNormalizableValueException $e){
            return $this->json(['erreur' => $e->getMessage()], 400);
        }

        $livre->setAuteur($auteurRepository->find($donnees['auteurId'] ?? 0));

        //validation 

        $erreurs = $validator->validate($livre);
        if (count($erreurs) > 0) {
            return $this->json(['erreurs', 422]);
        }

        $em->persist($livre);
        $em->flush();

        return $this->json($livre, 201);
 
}
}