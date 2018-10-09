<?php

include_once ROOT.'/models/User.php';

class UserController
{
    public function actionGetLogin()
    {
        $error = $_COOKIE['error'];
        $contentPathBlade = "login.blade.php";
        require_once(ROOT.'/view/general.blade.php');
        return true;
    }

    public function actionLogin()
    {
        $user = new User;
        $user->login($_POST['email'], $_POST['password']);

        if ($user->email != NULL) {
            session_start();
            $_SESSION['user'] = $user;
            header("Location: /");
            return true;
        }
        $error = 'Username or password do not match!';
        setcookie("error", $error, time()+1);
        header("Location: /login");
        return true;
    }

    public function actionSignUp()
    {
        $contentPathBlade = "signUp.blade.php";
        require_once(ROOT.'/view/general.blade.php');
        return true;
    }

    public function actionCreateUser()
    {
        echo "create user";
//        require_once(ROOT.'/view/general.blade.php');
        return true;
    }
}