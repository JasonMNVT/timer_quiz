<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Masterminds\HTML5\Elements;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('main/home.html.twig', [
            "categories" => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'event_category', methods: ['GET'])]
    public function showQuestions(Category $category): Response
    {
        return $this->render('main/category.html.twig', [
            'category' => $category,
            'questions' => $category->getQuestions(),
        ]);
    }

    #[Route('/question/number/{id}', name: 'event_question', methods: ['GET'])]
    public function showResponses(Question $question): Response
    {
        return $this->render('main/question.html.twig', [
            'question' => $question,
            'responses' => $question->getResponses(),
        ]);
    }
}