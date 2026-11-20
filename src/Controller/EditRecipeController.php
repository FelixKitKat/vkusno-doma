<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class EditRecipeController extends AbstractController
{
    #[Route('/recipes/{id}/edit', name: 'app_edit_recipe', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function index(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($request->isMethod('POST')) {
            $recipe->setTitle($request->request->get('title'));
            $recipe->setDescription($request->request->get('description'));
            $recipe->setCategory($request->request->get('category'));
            $recipe->setCookingTime((int) $request->request->get('cookingTime'));
            $recipe->setIngredients($request->request->get('ingredients'));
            $recipe->setInstructions($request->request->get('instructions'));
            $recipe->setServings((int) $request->request->get('servings'));

            $imageFile = $request->files->get('image');

            if ($imageFile) {
                $allowedMimeTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                ];

                $mimeType = $imageFile->getMimeType();

                if (!isset($allowedMimeTypes[$mimeType])) {
                    throw $this->createNotFoundException(
                        'Допустимы только JPG, PNG и WEBP.'
                    );
                }

                if ($imageFile->getSize() > 5 * 1024 * 1024) {
                    throw $this->createNotFoundException(
                        'Размер фотографии не должен превышать 5 МБ.'
                    );
                }

                $imageName = bin2hex(random_bytes(16))
                    . '.'
                    . $allowedMimeTypes[$mimeType];

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/images',
                        $imageName
                    );
                } catch (FileException $exception) {
                    throw new \RuntimeException(
                        'Не удалось сохранить фотографию.',
                        0,
                        $exception
                    );
                }

                $recipe->setImage($imageName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Рецепт успешно обновлён!');

            return $this->redirectToRoute('app_recipe_detail', [
                'id' => $recipe->getId(),
            ]);
        }

        return $this->render('edit_recipe/index.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
