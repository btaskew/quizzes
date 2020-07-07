<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param Quiz $quiz
     * @return Question
     */
    public function getFirstQuestion(Quiz $quiz): Question
    {
        return $this->createQueryBuilder('q')
            ->where('q.quiz = :quiz')
            ->setParameter('quiz', $quiz->getId())
            ->orderBy('q.order')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0];
    }

    /**
     * @param Quiz $quiz
     * @param int  $order
     * @return int|null
     */
    public function getIDByOrder(Quiz $quiz, int $order): ?int
    {
        $questions = $this->createQueryBuilder('q')
            ->select('q.id')
            ->where('q.quiz = :quiz')
            ->andWhere('q.order = :order')
            ->setParameter('quiz', $quiz->getId())
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult();

        if (count($questions) < 1) {
            return null;
        }

        return $questions[0]['id'];
    }
}
