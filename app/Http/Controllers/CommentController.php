<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Models\Comment;

class CommentController
{
    private $sessionRepository;
    private $userRepository;
    private $photoRepository;
    private $commentRepository;

    public function __construct()
    {
        if (auth() == NULL) {
            echo json_encode(array('status' => 'error', 'text' => 'Need login'));
            exit;
        }
        $this->sessionRepository = new SessionRepository;
        $this->userRepository = new UserRepository();
        $this->photoRepository = new PhotoRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function createComment()
    {
        $errors = [];
        $photoId = $_POST['photo_id'];
        $text = $_POST['text'];
        $errors['comment'] = Comment::checkText($text);

        $userId = auth()->id;
        $errors = array_filter($errors);

        if (count($errors) == 0) {
            $this->commentRepository->createComment($userId, $photoId, $text);
            $photo = $this->photoRepository->getPhotoFromId($photoId);

            $this->userRepository->informUserAboutComment($photo);

            echo json_encode(array('status' => 'success', 'text' => $text, 'user_name' => auth()->name));
            return true;
        } else {
            echo json_encode($errors);
        }
        return true;
    }

    public function removeComment()
    {
        $errors = [];
        $commentId = $_POST['comment_id'];
        $userId = auth()->id;
        $errors = array_filter($errors);

        if (count($errors) == 0) {
            $this->commentRepository->removeComment($userId, $commentId);

            echo 'success';
            return true;
        } else {
            echo 'error';
        }
        return true;
    }
}