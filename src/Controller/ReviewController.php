<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewController extends AbstractController
{
    #[Route('/recipes/{id}/review', name: 'app_review_new', methods: ['GET', 'POST'])]
    public function new(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $review = new Review();
        $review->setRecipe($recipe);
        $review->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Спасибо! Ваш отзыв добавлен.');

            return $this->redirectToRoute('app_recipe_detail', [
                'id' => $recipe->getId(),
            ]);
        }

        return $this->render('review/index.html.twig', [
            'form' => $form,
            'recipe' => $recipe,
        ]);
    }
}