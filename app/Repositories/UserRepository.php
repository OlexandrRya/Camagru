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

    public function informUserAboutComment($photo)
    {
        $this->userModel->loginWithUserIdWithoutPassword($photo['user_id']);
        if ($this->userModel->isEmailInforming == 1 && $this->userModel->id !== auth()->id) {
//            User::sendNotisficationEmail($user['email'], $user['login']);
            //TODO create email informing user
        }
    }
}