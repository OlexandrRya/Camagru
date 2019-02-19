<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $user = json_decode($_SESSION['user']);
        }
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }
}