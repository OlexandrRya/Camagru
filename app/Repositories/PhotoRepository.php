<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository
{
    private $photoModel;

    public function __construct()
    {
        $this->photoModel = new Photo;
    }

    public function savePhoto($uploadPath, $userId)
    {
        $this->photoModel->createPhoto($uploadPath, $userId);
    }

    public function savePhotoFromCamera($img, $fileName, $dirName)
    {
        $uploadPath = ROOT . $dirName . $fileName;

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imgFile = base64_decode($img);

        if(!is_dir(ROOT . $dirName)) {
            mkdir(ROOT . $dirName, 0777, true);
        }

        $res = file_put_contents($uploadPath, $imgFile);

    }

    public function applyFilterToPhoto($finalImage, $filterImg)
    {
        switch ($filterImg) {
            case "grayscale(100%)":
                imagefilter($finalImage, IMG_FILTER_GRAYSCALE);
                break;
            case "sepia(100%)":
                imagefilter($finalImage, IMG_FILTER_GRAYSCALE);
                imagefilter($finalImage, IMG_FILTER_BRIGHTNESS, -5);
                imagefilter($finalImage, IMG_FILTER_COLORIZE, 60, 45, 0);
                break ;
            case  "invert(100%)":
                imagefilter($finalImage, IMG_FILTER_NEGATE);
                break ;
            case  "contrast(200%)":
                imagefilter($finalImage, IMG_FILTER_CONTRAST, -50);
                break ;
        }
    }

    public function applySticker($finalImage, $sticker)
    {
        $stickerPath = explode('/', $sticker);
        $stickerPath = ROOT . '/' . $stickerPath[3] . '/' . $stickerPath[4] . '/' . $stickerPath[5] . '/' . $stickerPath[6];

        if (is_file($stickerPath) && is_readable($stickerPath)) {

            $stickerImg = imagecreatefrompng($stickerPath);

            imagecopy($finalImage, $stickerImg, 0, 0, -65, -120, 600, 450);
            imagedestroy($stickerImg);
        }
    }

    public function getAllPhoto()
    {
        return $this->photoModel->getAll();
    }

    public function getPhotoFromId($photoId)
    {
        return $this->photoModel->getPhotoFromId($photoId);
    }

    public function removePhoto($userId, $photoId)
    {
        $this->photoModel->removePhoto($userId, $photoId);
    }
}