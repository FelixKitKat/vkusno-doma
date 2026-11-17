<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipes/{id}', name: 'app_recipe_detail', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $recipes = [
            1 => [
                'title' => 'Домашний куриный суп',
                'category' => 'Супы',
                'time' => 40,
                'image' => 'photo-1547592180-85f173990554.jfif',
                'description' => 'Лёгкий и ароматный суп для семейного обеда.',
                'servings' => 4,
                'ingredients' => [
                    ['name' => 'Курица', 'quantity' => 400, 'unit' => 'г'],
                    ['name' => 'Картофель', 'quantity' => 3, 'unit' => 'шт.'],
                    ['name' => 'Морковь', 'quantity' => 1, 'unit' => 'шт.'],
                    ['name' => 'Лук', 'quantity' => 1, 'unit' => 'шт.'],
                    ['name' => 'Вода', 'quantity' => 2, 'unit' => 'л'],
                ],
                'steps' => [
                    'Промойте курицу и положите её в кастрюлю с водой.',
                    'Варите бульон около 25 минут, снимая пену.',
                    'Нарежьте картофель, морковь и лук.',
                    'Добавьте овощи в кастрюлю и варите до готовности.',
                    'Посолите, добавьте зелень и подавайте к столу.',
                ],
            ],

            2 => [
                'title' => 'Свежий овощной салат',
                'category' => 'Салаты',
                'time' => 15,
                'image' => 'photo-1512621776951-a57141f2eefd.jfif',
                'description' => 'Яркий салат из свежих овощей и зелени.',
                'servings' => 2,
                'ingredients' => [
                    ['name' => 'Помидоры', 'quantity' => 2, 'unit' => 'шт.'],
                    ['name' => 'Огурцы', 'quantity' => 2, 'unit' => 'шт.'],
                    ['name' => 'Болгарский перец', 'quantity' => 1, 'unit' => 'шт.'],
                    ['name' => 'Листья салата', 'quantity' => 100, 'unit' => 'г'],
                    ['name' => 'Оливковое масло', 'quantity' => 2, 'unit' => 'ст. л.'],
                ],
                'steps' => [
                    'Промойте все овощи и зелень.',
                    'Нарежьте помидоры, огурцы и перец.',
                    'Порвите листья салата руками.',
                    'Смешайте ингредиенты в салатнице.',
                    'Добавьте масло и соль, аккуратно перемешайте.',
                ],
            ],

            3 => [
                'title' => 'Домашний ягодный пирог',
                'category' => 'Десерты',
                'time' => 60,
                'image' => 'photo-1464349095431-e9a21285b5f3.jfif',
                'description' => 'Нежная выпечка для уютного чаепития.',
                'servings' => 6,
                'ingredients' => [
                    ['name' => 'Мука', 'quantity' => 250, 'unit' => 'г'],
                    ['name' => 'Ягоды', 'quantity' => 200, 'unit' => 'г'],
                    ['name' => 'Сахар', 'quantity' => 120, 'unit' => 'г'],
                    ['name' => 'Яйца', 'quantity' => 2, 'unit' => 'шт.'],
                    ['name' => 'Сливочное масло', 'quantity' => 100, 'unit' => 'г'],
                    ['name' => 'Разрыхлитель', 'quantity' => 1, 'unit' => 'ч. л.'],
                ],
                'steps' => [
                    'Размягчите сливочное масло и смешайте с сахаром.',
                    'Добавьте яйца и перемешайте.',
                    'Постепенно всыпьте муку с разрыхлителем.',
                    'Выложите тесто в форму и добавьте ягоды.',
                    'Выпекайте при 180 °C примерно 40 минут.',
                ],
            ],
        ];

        if (!isset($recipes[$id])) {
            throw $this->createNotFoundException('Рецепт не найден');
        }

        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipes[$id],
        ]);
    }
}
