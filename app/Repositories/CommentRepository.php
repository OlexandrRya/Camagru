<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function createComment($userId, $photoId, $text)
    {
        $this->commentModel->createComment($userId, $photoId, $text);
    }

    public function removeComment($userId, $commentId)
    {
        $this->commentModel->removeComment($userId, $commentId);
    }
}