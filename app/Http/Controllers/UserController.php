<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    public function getLogin()
    {
        if (isset($_COOKIE['error']))
            $error = $_COOKIE['error'];
        $contentPathBlade = "login.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function login()
    {
        $user = new User;
        $user->login($_POST['email'], $_POST['password']);

        if ($user->email != NULL) {
            $_SESSION['user'] = json_encode($user);
            header("Location: /");
            return true;
        }
        $error = 'Username or password do not match!';
        setcookie("error", $error, time() + 1);
        header("Location: /login");
        return true;
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }

    public function signUp()
    {
        if (isset($_COOKIE['error']))
            $error = $_COOKIE['error'];
        $contentPathBlade = "signUp.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function createUser()
    {
        $user = new User;
        $user->register($_POST);

        if ($user->email != NULL) {
            $_SESSION['user'] = json_encode($user);
            header("Location: /");
            return true;
        }
        $error = 'This email is already taken!';
        setcookie("error", $error, time() + 1);
        header("Location: /sign-up");
        return true;
    }
}