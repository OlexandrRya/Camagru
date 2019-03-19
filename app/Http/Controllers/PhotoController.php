<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;

class PhotoController
{
    private $sessionRepository;
    private $verificationCodeRepository;
    private $userRepository;

    public function __construct()
    {
        if (auth() == NULL) {
            header("Location: /login");
            return false;
        }
        $this->sessionRepository = new SessionRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository();
        $this->userRepository = new UserRepository();
    }

    public function photoShowCreatePage()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        $contentPathBlade = "photoCreate.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function photoCreatePost()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        var_dump($_POST);
        die;
        if (count($errors) == 0) {

            header("Location: /photo/create");
            return true;
        } else {
            $this->sessionRepository->setErrorMessages($errors);
            header("Location: /photo/create");
        }
        return true;
    }
}