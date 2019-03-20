<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository
{
    private $photoModel;

    public function __construct()
    {
        $this->photoModel = new Photo;
    }

    public function savePhoto($uploadPath, $userId)
    {
        $this->photoModel->createPhoto($uploadPath, $userId);
    }
}