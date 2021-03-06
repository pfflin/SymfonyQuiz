<?php
/**
 * Created by PhpStorm.
 * User: Pavlin
 * Date: 1/4/2019
 * Time: 9:34 PM
 */

namespace QuizBundle\Services;


use Doctrine\DBAL\Connection;
use Proxies\__CG__\QuizBundle\Entity\Question;
use QuizBundle\Entity\Comment;
use QuizBundle\Entity\User;
use QuizBundle\Repository\CommentRepository;
use QuizBundle\Repository\QuestionRepository;
use QuizBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class LikesService implements LikesServiceInterface
{
    private $questionRepository;
    private $security;
    private $userRepository;
    private $commentRepository;
    private $connection;
    public function __construct(QuestionRepository $questionRepository,Security $security,UserRepository $userRepository,CommentRepository $commentRepository,Connection$connection)
    {
        $this->questionRepository=$questionRepository;
        $this->security=$security;
        $this->userRepository= $userRepository;
        $this->commentRepository=$commentRepository;
        $this->connection=$connection;
    }

    public function addLikeQuestion($id)
    {
        /**
         * @var Question $question
         */
        $question = $this->questionRepository->find($id);
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        if (!$question->getAuthorId() == $user->getId()){
            return false;
        }
        $user->setLikes($question);
        $this->userRepository->saveUser($user);
        return true;
    }

    public function removeLikeQuestion($id)
    {
        /**
         * @var Question $question
         */
        $question = $this->questionRepository->find($id);
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        $this->userRepository->deleteLike($user,$question,$this->connection);
    }

    public function addLikeComment($id)
    {
        /**
         * @var Comment $comment
         */
        $comment = $this->commentRepository->find($id);
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        if ($comment === null){
            return 0;
        }
        if (!$comment->getAuthorId() == $user->getId()){
            return 0;
        }
        $user->setLikedComments($comment);
        $this->userRepository->saveUser($user);
        return $comment->getQuestionId();
    }

    public function removeLikeComment($id)
    {
        /**
         * @var Comment $comment
         */
        $comment = $this->commentRepository->find($id);
        /**
         * @var User $user
         */
        $user = $this->security->getUser();

        try{
            $this->userRepository->deleteLike($user,$comment,$this->connection);
            return $comment->getQuestionId();
        }catch (\Exception $exception){
            return 0;
        }
    }
}