<?php

namespace App\Http\Controllers;

class HomeController
{
    public function __construct()
    {

    }

    public function index()
    {
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }
}