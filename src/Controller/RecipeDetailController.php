<?php

namespace App\Controller;

use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeDetailController extends AbstractController
{
    #[Route('/recipes/{id}', name: 'app_recipe_detail', requirements: ['id' => '\d+'])]
    public function show(Recipe $recipe): Response
    {
        $ingredients = [];

        foreach (explode("\n", $recipe->getIngredients()) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (preg_match(
                '/^(.+?)\s*[—–-]\s*(\d+(?:[.,]\d+)?)\s*(.*)$/u',
                $line,
                $matches
            )) {
                $ingredients[] = [
                    'name' => trim($matches[1]),
                    'quantity' => (float) str_replace(',', '.', $matches[2]),
                    'unit' => trim($matches[3]),
                ];
            } else {
                $ingredients[] = [
                    'name' => $line,
                    'quantity' => 1,
                    'unit' => '',
                ];
            }
        }

        $steps = array_filter(
            array_map('trim', explode("\n", $recipe->getInstructions()))
        );

        return $this->render('recipe/detail.html.twig', [
            'recipe' => [
                'id' => $recipe->getId(),
                'title' => $recipe->getTitle(),
                'category' => $recipe->getCategory(),
                'time' => $recipe->getCookingTime(),
                'image' => $recipe->getImage(),
                'description' => $recipe->getDescription(),
                'servings' => $recipe->getServings(),
                'ingredients' => $ingredients,
                'steps' => $steps,
                'reviews' => $recipe->getReviews(),
            ],
        ]);
    }
}
