<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;

class AuthController
{
    private $sessionRepository;
    private $verificationCodeRepository;
    private $userRepository;

    public function __construct()
    {
        $this->sessionRepository = new SessionRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository();
        $this->userRepository = new UserRepository();
    }

    /**
     * Login area
     */

    public function getLogin()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        $contentPathBlade = "login.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function login()
    {
        $errors = [];
        $userName = $_POST['user_name'];
        $password = $_POST['password'];

        $errors['userNameAndPassword'] = User::userNameAndPasswordVerification($userName, $password);
        $errors = array_filter($errors);

        if (count($errors) == 0) {

            $user = new User;
            $user->login($_POST['user_name'], $_POST['password']);

            $_SESSION['user'] = json_encode($user);
            header("Location: /");
            return true;
        } else {
            $this->sessionRepository->setErrorMessages($errors);
            header("Location: /login");
        }
        return true;
    }
    /***************************************************************************************************************************/


    /**
     * Logout area
     */

    public function logout()
    {
        $this->sessionRepository->sessionDestroy();
        header("Location: /");
    }
    /***************************************************************************************************************************/

    /**
     * Register area
     */

    public function successRegister()
    {
        $contentPathBlade = "signUpSuccess.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function signUp()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        $contentPathBlade = "signUp.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function createUser()
    {
        $errors = [];
        $userName = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];

        $errors['userName'] = User::userNameVerification($userName);
        $errors['email'] = User::emailVerification($email);
        $errors['password'] = User::passwordVerification($password, $repeatPassword);
        $errors = array_filter($errors);


        if (count($errors) == 0){
            $user = new User;
            $user->register($email, $userName, $password);

            $this->sessionRepository->setArrayToSessionInJsonForm('user', $user);
            $this->verificationCodeRepository->createConfirmCodeAndSentConfirmEmailToUser($user);

            header("Location: /success-register");
            return true;
        } else {
            $this->sessionRepository->setErrorMessages($errors);
        }

        header("Location: /sign-up");
        return true;
    }

    public function confirmUser()
    {
        $errors = [];
        $confirmCode = $_GET['confirmCode'];

        $userId = $this->verificationCodeRepository->confirmCodeAndReturnUserId($confirmCode);
        if (isset($userId)) {
            $this->userRepository->confirmUser($userId);
        }

        header("Location: /login");
        return true;
    }

}