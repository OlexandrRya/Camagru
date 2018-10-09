<?php

include_once ROOT.'/models/User.php';

class UserController
{
    public function actionGetLogin()
    {
        $contentPathBlade = "login.blade.php";
        require_once(ROOT.'/view/general.blade.php');
        return true;
    }

    public function actionLogin()
    {
        echo "login";
        $user = new User;
        $user->login($_POST['email'], $_POST['password']);
        var_dump($user);
        if ($user->email != NULL) {
            session_start();
            $_SESSION['user'] = $user;
        }
        header("Location: /");
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