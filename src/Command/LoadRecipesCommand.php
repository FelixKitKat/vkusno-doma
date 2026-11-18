<?php

namespace App\Command;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-recipes',
    description: 'Добавляет начальные рецепты в базу данных'
)]
class LoadRecipesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $repository = $this->entityManager->getRepository(Recipe::class);

        if ($repository->count([]) > 0) {
            $output->writeln('В базе уже есть рецепты. Новые записи не добавлены.');
            return Command::SUCCESS;
        }

        $recipes = [
            [
                'title' => 'Домашний куриный суп',
                'description' => 'Лёгкий и ароматный суп для семейного обеда.',
                'category' => 'Супы',
                'time' => 40,
                'image' => 'photo-1547592180-85f173990554.jfif',
                'ingredients' => "Курица — 400 г\nКартофель — 3 шт.\nМорковь — 1 шт.\nЛук — 1 шт.\nВода — 2 л",
                'instructions' => "Промойте курицу и положите её в кастрюлю с водой.\nВарите бульон около 25 минут, снимая пену.\nНарежьте картофель, морковь и лук.\nДобавьте овощи в кастрюлю и варите до готовности.\nПосолите, добавьте зелень и подавайте к столу.",
                'servings' => 4,
            ],
            [
                'title' => 'Свежий овощной салат',
                'description' => 'Яркий салат из свежих овощей и зелени.',
                'category' => 'Салаты',
                'time' => 15,
                'image' => 'photo-1512621776951-a57141f2eefd.jfif',
                'ingredients' => "Помидоры — 2 шт.\nОгурцы — 2 шт.\nБолгарский перец — 1 шт.\nЛистья салата — 100 г\nОливковое масло — 2 ст. л.",
                'instructions' => "Промойте все овощи и зелень.\nНарежьте помидоры, огурцы и перец.\nПорвите листья салата руками.\nСмешайте ингредиенты в салатнице.\nДобавьте масло и соль, аккуратно перемешайте.",
                'servings' => 2,
            ],
            [
                'title' => 'Домашний ягодный пирог',
                'description' => 'Нежная выпечка для уютного чаепития.',
                'category' => 'Десерты',
                'time' => 60,
                'image' => 'photo-1464349095431-e9a21285b5f3.jfif',
                'ingredients' => "Мука — 250 г\nЯгоды — 200 г\nСахар — 120 г\nЯйца — 2 шт.\nСливочное масло — 100 г\nРазрыхлитель — 1 ч. л.",
                'instructions' => "Размягчите сливочное масло и смешайте с сахаром.\nДобавьте яйца и перемешайте.\nПостепенно всыпьте муку с разрыхлителем.\nВыложите тесто в форму и добавьте ягоды.\nВыпекайте при 180 °C примерно 40 минут.",
                'servings' => 6,
            ],
        ];

        foreach ($recipes as $data) {
            $recipe = new Recipe();

            $recipe->setTitle($data['title']);
            $recipe->setDescription($data['description']);
            $recipe->setCategory($data['category']);
            $recipe->setCookingTime($data['time']);
            $recipe->setImage($data['image']);
            $recipe->setIngredients($data['ingredients']);
            $recipe->setInstructions($data['instructions']);
            $recipe->setServings($data['servings']);
            $recipe->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($recipe);
        }

        $this->entityManager->flush();

        $output->writeln('Успешно добавлено рецептов: ' . count($recipes));

        return Command::SUCCESS;
    }
}
