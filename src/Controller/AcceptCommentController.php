<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ressource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AcceptCommentController extends AbstractController
{

    public function __invoke(Comment $comment): Comment
    {
        if ($comment->isAccepted()){
            $comment->setAccepted(false);
        } else {
            $comment->setAccepted(true);
        }

        return $comment;
    }

}