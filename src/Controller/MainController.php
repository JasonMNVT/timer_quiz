<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('main/home.html.twig', []);
    }

    #[Route('/homepage', name: 'homepage', methods: ['GET'])]
    public function homepage(CategoryRepository $categoryRepository): Response
    {
        return $this->render('main/homepage.html.twig', [
            "categories" => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'event_category', methods: ['GET'])]
    public function showQuestions(Category $category): Response
    {
        $tabQuestions = $category->getQuestions()->toArray();

        return $this->redirectToRoute('event_question', ['id' => $tabQuestions[0]->getId()]);

        /*return $this->render('main/category.html.twig', [
            'category' => $category,
            'questions' => $tabQuestions,
        ]);*/
    }

    #[Route('/question/number/{id}', name: 'event_question', methods: ['GET'])]
    public function showResponses(Question $question): Response
    {
        // Tableau des réponses de la question
        $tabResponses = $question->getResponses()->toArray();
        // Retrouver la catégorie à partir de la question
        $categorie = $question->getCategory();
        // Tableau des des questions de la catégorie
        $questions = $categorie->getQuestions()->toArray();
        // parcourir le tableau de question, et prendre celle juste après l'actuel $question
        for ($i = 0; $i < count($questions); $i++) {
            if ($question == $questions[$i]) {
                // puis tu recupere la question après $next_question
                $next_question = $questions[$i + 1];
            }
        }
        shuffle($tabResponses);

        return $this->render('main/question.html.twig', [
            'question' => $question,
            'responses' => $tabResponses,
            'next_question' => $next_question
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(): Response
    {
        return $this->render('main/historique.html.twig', []);
    }
}
