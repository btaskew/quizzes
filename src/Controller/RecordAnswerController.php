<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RecordAnswerController extends AbstractController
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
     * @Route("/quizzes/{quiz}/question/{question}/answer/{answer}", name="record_answer")
     * @param Quiz               $quiz
     * @param Question           $question
     * @param Answer             $answer
     * @param QuestionRepository $questionRepository
     * @return RedirectResponse
     */
    public function store(Quiz $quiz, Question $question, Answer $answer, QuestionRepository $questionRepository)
    {
        $this->recordAnswer($quiz, $answer, $question);

        $nextQuestionId = $questionRepository->getIDByOrder($quiz, $question->getOrder() + 1);

        if (is_null($nextQuestionId)) {
            return $this->redirectToRoute("view_results", ['quiz' => $quiz->getId()]);
        }

        return $this->redirectToRoute("question_show", ['quiz' => $quiz->getId(), 'question' => $nextQuestionId]);
    }

    /**
     * @param Quiz     $quiz
     * @param Answer   $answer
     * @param Question $question
     */
    private function recordAnswer(Quiz $quiz, Answer $answer, Question $question): void
    {
        $answers = $this->session->get($quiz->getId());
        $answers[$question->getId()] = $answer;
        $this->session->set($quiz->getId(), $answers);
    }
}
