<?php

class HomeController
{
    public function actionIndex()
    {
        $contentPathBlade = "";
        require_once(ROOT.'/view/general.blade.php');
        return true;
    }
}