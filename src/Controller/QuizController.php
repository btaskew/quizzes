<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @Route("/", name="quizzes")
     * @param QuizRepository $quizRepository
     * @return Response
     */
    public function index(QuizRepository $quizRepository)
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }

    /**
     * @Route("/quizzes/{quiz}", name="quizzes_show")
     * @param Quiz               $quiz
     * @param QuestionRepository $questionRepository
     * @return Response
     */
    public function show(Quiz $quiz, QuestionRepository $questionRepository)
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
            'firstQuestion' => $questionRepository->getFirstQuestion($quiz)
        ]);
    }
}
