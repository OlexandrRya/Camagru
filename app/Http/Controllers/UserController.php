<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;

class UserController
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

    public function settingShow()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        $contentPathBlade = "userSettings.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function changeUserName()
    {
        $errors = [];
        $newUserName = $_POST['new_user_name'];
        $userName = auth()->name;
        $errors['newUserName'] = User::userNameVerification($newUserName);
        $errors = array_filter($errors);

        if (count($errors) == 0) {
            $user = new User;
            $user->loginWithoutPassword($userName);
            $user->changeUserName($newUserName);

            $_SESSION['user'] = json_encode($user);
            header("Location: /settings");
            return true;
        } else {
            $this->sessionRepository->setErrorMessages($errors);
            header("Location: /login");

//            header("Location: /settings");
            var_dump($errors);
            var_dump($_COOKIE);

            die;
        }
        return true;
    }
}