<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteRecipeController extends AbstractController
{
    #[Route(
        '/recipes/{id}/delete',
        name: 'app_delete_recipe',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function index(
        Recipe $recipe,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash('success', 'Рецепт успешно удалён!');

        return $this->redirectToRoute('app_recipes');
    }
}
