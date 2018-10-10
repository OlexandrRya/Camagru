<?php

class HomeController
{
    public function actionIndex()
    {
        if (isset($_SESSION['user'])) {
            $user = json_decode($_SESSION['user']);
        }
        $contentPathBlade = "";
        require_once(ROOT.'/view/general.blade.php');
        return true;
    }
}