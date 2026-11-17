<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeDetailController extends AbstractController
{
    #[Route('/recipes/{id}', name: 'app_recipe_detail', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $recipes = [
            1 => [
                'title' => 'Домашний куриный суп',
                'category' => 'Супы',
                'time' => 40,
                'image' => 'soup.jpg',
                'description' => 'Лёгкий и ароматный суп для семейного обеда.',
                'servings' => 4,
                'ingredients' => [
                    'Курица — 400 г',
                    'Картофель — 3 шт.',
                    'Морковь — 1 шт.',
                    'Лук — 1 шт.',
                    'Вода — 2 л',
                    'Соль и зелень — по вкусу',
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
                'image' => 'salad.jpg',
                'description' => 'Яркий салат из свежих овощей и зелени.',
                'servings' => 2,
                'ingredients' => [
                    'Помидоры — 2 шт.',
                    'Огурцы — 2 шт.',
                    'Болгарский перец — 1 шт.',
                    'Листья салата — 100 г',
                    'Оливковое масло — 2 ст. л.',
                    'Соль — по вкусу',
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
                'image' => 'dessert.jpg',
                'description' => 'Нежная выпечка для уютного чаепития.',
                'servings' => 6,
                'ingredients' => [
                    'Мука — 250 г',
                    'Ягоды — 200 г',
                    'Сахар — 120 г',
                    'Яйца — 2 шт.',
                    'Сливочное масло — 100 г',
                    'Разрыхлитель — 1 ч. л.',
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
