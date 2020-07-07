<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/quizzes/{quiz}/question/{question}", name="question_show")
     * @param Question           $question
     * @param Quiz               $quiz
     * @param QuestionRepository $questionRepository
     * @return Response
     */
    public function show(Question $question, Quiz $quiz, QuestionRepository $questionRepository)
    {
        $nextQuestionId = $questionRepository->getIDByOrder($quiz, $question->getOrder() + 1);
        $isLastQuestion = is_null($nextQuestionId);

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'quiz' => $quiz,
            'nextQuestionId' => $nextQuestionId,
            'isLastQuestion' => $isLastQuestion,
        ]);
    }
}
