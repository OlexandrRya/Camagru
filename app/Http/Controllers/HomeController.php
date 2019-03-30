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
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $photos = $this->photoRepository->getPhotoWithPaginate($page, 5);
        $pageCount = $this->photoRepository->getPageCount(5);

        $contentPathBlade = "gallery.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }
}