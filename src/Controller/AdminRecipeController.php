<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminRecipeController extends AbstractController
{
    #[Route('/admin/recipe', name: 'app_admin_recipe', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($request->isMethod('POST')) {
            $recipe = new Recipe();

            $recipe->setTitle($request->request->get('title'));
            $recipe->setDescription($request->request->get('description'));
            $recipe->setCategory($request->request->get('category'));
            $recipe->setCookingTime((int) $request->request->get('cookingTime'));
            $recipe->setImage($request->request->get('image'));
            $recipe->setIngredients($request->request->get('ingredients'));
            $recipe->setInstructions($request->request->get('instructions'));
            $recipe->setServings((int) $request->request->get('servings'));
            $recipe->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash('success', 'Рецепт успешно добавлен!');

            return $this->redirectToRoute('app_recipe_detail', [
                'id' => $recipe->getId(),
            ]);
        }

        return $this->render('admin_recipe/index.html.twig');
    }
}
