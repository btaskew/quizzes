<?php

namespace App\Controller;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/quizzes/{quiz}/results", name="view_results")
     * @param Quiz $quiz
     * @return Response
     */
    public function show(Quiz $quiz)
    {
        $answers = $this->session->get($quiz->getId());
        $correctAnswers = array_filter($answers, function ($answer) {
            return $answer->isCorrect();
        });

        return $this->render('results/show.html.twig', [
            'correct_count' => count($correctAnswers),
            'total_count' => $quiz->getQuestions()->count(),
            'answers' => $answers,
            'quiz' => $quiz,
        ]);
    }
}
