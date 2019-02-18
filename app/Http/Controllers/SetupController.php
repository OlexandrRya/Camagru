<?php

namespace App\Http\Controllers;

class SetupController
{

    public function setup()
    {
        include_once ROOT . '/config/setup.php';

        return true;
    }
}