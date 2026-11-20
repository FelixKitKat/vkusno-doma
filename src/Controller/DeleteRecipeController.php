<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteRecipeController extends AbstractController
{
    #[Route('/recipes/{id}/delete', name: 'app_delete_recipe', methods: ['POST'])]
    public function index(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$this->isCsrfTokenValid(
            'delete_recipe_' . $recipe->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Недействительный защитный токен.'
            );
        }

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash('success', 'Рецепт успешно удалён!');

        return $this->redirectToRoute('app_recipes');
    }
}
