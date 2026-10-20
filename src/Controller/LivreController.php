<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\LivreRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/livres', name: 'app_livre')]

final class LivreController extends AbstractController
{
    #[Route('/', name: 'livre_liste', methods: ['GET']), ]
    public function index(LivreRepository $livreRepository): JsonResponse
    {
        return $this->json([
            'livres' => $livreRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'livre_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(LivreRepository $livreRepository, int $id): JsonResponse
    {
        $livre = $livreRepository->find($id);
        if (!$livre) {
            return $this->json(['erreur' => 'Livre non trouvé'], 404);
        }

        return $this->json([
            $livre
        ]);

    }
}
