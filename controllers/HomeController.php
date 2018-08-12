<?php

class HomeController
{
    public function actionIndex ()
    {



        require_once(ROOT.'/view/general.blade.php');
        return true;
    }
}