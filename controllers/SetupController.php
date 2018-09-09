<?php


class SetupController
{
    public function actionSetup()
    {
        include_once ROOT.'/config/setup.php';

        return true;
    }
}