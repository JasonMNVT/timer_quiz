<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\QuizUser;
use App\Repository\CategoryRepository;
use App\Repository\QuizUserRepository;
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
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('main/homepage.html.twig', [
            "categories" => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'event_category', methods: ['GET'])]
    public function showQuestions(Category $category): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        $tabQuestions = $category->getQuestions()->toArray();

        return $this->redirectToRoute('event_question', ['id' => $tabQuestions[0]->getId()]);

        /*return $this->render('main/category.html.twig', [
            'category' => $category,
            'questions' => $tabQuestions,
        ]);*/
    }

    #[Route('/page-category/{id}', name: 'event_page_category', methods: ['GET', 'POST'])]
    public function pageCategory(Category $category, QuizUserRepository $quizUserRepository): Response
    {   
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        $quizUser = new QuizUser();
        $user = $this->getUser();
        $idCategory = $category;
        $time = date('Y-m-d H:i:s');
        $quizUser->setUser($user);
        $quizUser->setCategory($idCategory);
        $quizUser->setDate($time);
        $quizUserRepository->save($quizUser, true);
        
        return $this->render('main/pageCategory.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/question/number/{id}', name: 'event_question_post', methods: ['POST'])]
    public function storeResponse(): Void 
    {
        // 1 - recuperer le formulaire avec les champs suivants: question_id, date_vu_question, date_repondu_question, reponse_est_valide ?
        
        // 2 - Le quizz_user actuel c'est le dernier en date quizz_user de l'user connecté
        
        // 3 - créer le quizz_user_reponse

        // 4 - rediriger sur la nouvelle question (bonus: calculer a la volée le score)
    }

    #[Route('/question/number/{id}', name: 'event_question', methods: ['GET'])]
    public function showResponses(Question $question): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        // Tableau des réponses de la question.
        $tabResponses = $question->getResponses()->toArray();
        // Retrouver la catégorie à partir de la question.
        $categorie = $question->getCategory();
        // Tableau des questions de la catégorie.
        $questions = $categorie->getQuestions()->toArray();
        // Récupérer la question suivante.
        $next_question = null;
        // Parcourir le tableau des questions et prendre celle juste après l'actuelle.
        for ($i = 0; $i < count($questions) - 1; $i++) {
            if ($question == $questions[$i]) {
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
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('main/historique.html.twig', []);
    }
}
