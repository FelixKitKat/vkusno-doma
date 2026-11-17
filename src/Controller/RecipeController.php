<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipes')]
    public function index(): Response
    {
        $recipes = [
            [
                'title' => 'Домашний куриный суп',
                'category' => 'Супы',
                'time' => 40,
                'image' => 'photo-1547592180-85f173990554.jfif',
                'description' => 'Лёгкий и ароматный суп для семейного обеда.',
            ],
            [
                'title' => 'Свежий овощной салат',
                'category' => 'Салаты',
                'time' => 15,
                'image' => 'photo-1512621776951-a57141f2eefd.jfif',
                'description' => 'Яркий салат из свежих овощей и зелени.',
            ],
            [
                'title' => 'Домашний ягодный пирог',
                'category' => 'Десерты',
                'time' => 60,
                'image' => 'photo-1464349095431-e9a21285b5f3.jfif',
                'description' => 'Нежная выпечка для уютного чаепития.',
            ],
        ];

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
