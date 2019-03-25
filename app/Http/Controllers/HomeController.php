<?php

namespace App\Http\Controllers;

use App\Repositories\PhotoRepository;

class HomeController
{
    private $photoRepository;

    public function __construct()
    {
        $this->photoRepository = new PhotoRepository();

    }

    public function index()
    {
        $photos = $this->photoRepository->getAllPhoto();

        $contentPathBlade = "gallery.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }
}