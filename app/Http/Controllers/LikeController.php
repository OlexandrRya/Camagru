<?php

namespace App\Http\Controllers;

use App\Repositories\LikeRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;

class LikeController
{
    private $sessionRepository;
    private $userRepository;
    private $photoRepository;
    private $likeRepository;

    public function __construct()
    {
        if (auth() == NULL) {
            echo json_encode(array('status' => 'error', 'text' => 'Need login'));
            exit;
        }
        $this->sessionRepository = new SessionRepository;
        $this->userRepository = new UserRepository();
        $this->photoRepository = new PhotoRepository();
        $this->likeRepository = new LikeRepository();
    }

    public function createLike()
    {
        $errors = [];
        $photoId = $_POST['photo_id'];
        $userId = auth()->id;
        $errors = array_filter($errors);

        if (count($errors) == 0) {
            $this->likeRepository->createLike($userId, $photoId);

            echo json_encode(array('status' => 'success', 'text' => 'success'));
            return true;
        } else {
            echo json_encode($errors);
        }
        return true;
    }

    public function removeLike()
    {
        $errors = [];
        $photoId = $_POST['photo_id'];
        $userId = auth()->id;
        $errors = array_filter($errors);

        if (count($errors) == 0) {
            $this->likeRepository->removeLike($userId, $photoId);

            echo json_encode(array('status' => 'success', 'text' => 'success'));
            return true;
        } else {
            echo json_encode($errors);
        }
        return true;
    }

}