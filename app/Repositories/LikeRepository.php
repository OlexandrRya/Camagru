<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository
{
    private $likeModel;

    public function __construct()
    {
        $this->likeModel = new Like();
    }

    public function createLike($userId, $photoId)
    {
        $this->likeModel->createLike($userId, $photoId);
    }

    public function removeLike($userId, $photoId)
    {
        $this->likeModel->removeLike($userId, $photoId);
    }

}