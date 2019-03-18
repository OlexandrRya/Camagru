<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function confirmUser($userId)
    {
        $this->userModel->confirmUser($userId);
    }
}