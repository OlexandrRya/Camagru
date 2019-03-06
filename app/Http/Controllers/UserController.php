<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SessionRepository;

class UserController
{
    private $sessionRepository;

    public function __construct()
    {
        $this->sessionRepository = new SessionRepository;
    }

    public function getLogin()
    {
        if (isset($_COOKIE['errors'])){
            $errors = json_decode($_COOKIE['errors'], true);
        }

        $contentPathBlade = "login.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function login()
    {
        $errors = [];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors['emailAndPassword'] = User::emailAndPasswordVerification($email, $password);
        $errors = array_filter($errors);

        if (count($errors) == 0) {

            $user = new User;
            $user->login($_POST['email'], $_POST['password']);


            $_SESSION['user'] = json_encode($user);
            header("Location: /");
            return true;
        } else {
            setcookie("errors", json_encode($errors), time() + 1);
            header("Location: /login");
        }
        return true;
    }

    public function logout()
    {
        $this->sessionRepository->sessionDestroy();
        header("Location: /");
    }

    public function signUp()
    {
        if (isset($_COOKIE['errors']))
            $errors = json_decode($_COOKIE['errors'], true);

        $contentPathBlade = "signUp.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function createUser()
    {
        $errors = [];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];

        $errors['email'] = User::emailVerification($email);
        $errors['password'] = User::passwordVerification($password, $repeatPassword);
        $errors = array_filter($errors);

        if (count($errors) == 0){
            $user = new User;
            $user->register($email, $name, $password);

            $this->sessionRepository->setArrayToSessionInJsonForm('user', $user);
            header("Location: /");
            return true;
        } else {
            setcookie("errors", json_encode($errors), time() + 1);
        }

        header("Location: /sign-up");
        return true;
    }
}