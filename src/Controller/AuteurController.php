<?php

namespace App\Controller;


use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/auteur', name: 'app_auteur')]
final class AuteurController extends AbstractController
{
    #[Route('/', name: 'liste_auteur', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository): JsonResponse
    {
        $auteurs = $auteurRepository->findAll();
        $listeAuteur = [];

        foreach($auteurs as $auteur){
            $listeAuteur[] = [
                'id' => $auteur->getId(),
                'nom' => $auteur->getNom(),
            ];
        }

        if (!$listeAuteur) {
            return $this->json(['erreur' => 'Aucun auteur trouvé'], 404);
        }

        return $this->json([
            'auteurs' => $listeAuteur
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_auteur', requirements: ['id' => '\d+'], methods:['GET']) ]
    public function auteurDetail(AuteurRepository $auteurRepository, int $id):  JsonResponse{
        $auteur = $auteurRepository->find($id);
        
        if (!$auteur){
             return $this->json(['erreur' => 'Cette auteur n\'a pas été trouvée'], 404); 
        }
        
        return $this->json([
            'auteur' => [
                'id' => $auteur->getId(),
                'nom' => $auteur->getNom()
            ]
        ]);
    }

    #[Route('/{id}/livres', name: 'auteur_livres', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function auteurLivres(AuteurRepository $auteurRepository, int $id): JsonResponse
    { 
        $auteur = $auteurRepository->find($id);

        if( null === $auteur) {
            return $this->json(['erreur' => 'Cette auteur n\'a pas été trouvée'], 404);
        }


        return $this->json(
            $auteur->getLivres(),
            200,
            [],
            ['groups' => 'livre:lecture']
        );

    }
}
