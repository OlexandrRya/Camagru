<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;
use App\Repositories\PhotoRepository;

class PhotoController
{
    private $sessionRepository;
    private $verificationCodeRepository;
    private $userRepository;
    private $photoRepository;

    public function __construct()
    {
        if (auth() == NULL) {
            header("Location: /login");
            return false;
        }
        $this->sessionRepository = new SessionRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository();
        $this->userRepository = new UserRepository();
        $this->photoRepository = new PhotoRepository();
    }

    public function photoShowCreatePage()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();

        $contentPathBlade = "photoCreate.blade.php";
        require_once(ROOT . '/view/general.blade.php');
        return true;
    }

    public function photoCreatePostSnapshotFile()
    {
        // setting directory for saving photos and randomizer for names
        $dir_name = 'photos/';
        $file_name = date('Y_m_d') . '_' . rand(1, 10000) . '.png';
        // save simple image
        MakephotoController::savePhotoFromCamera($_POST['img'], $file_name, $dir_name);
        // create new image to apply stickers and filters
        $final_image = imagecreatefrompng($dir_name . $file_name);
        imagesavealpha($final_image, true);
        imagealphablending($final_image, true);
        // apply filter to photo
        MakephotoController::applyFilterToPhoto($final_image, $_POST['filter']);
        // apply stickers and filters
        if (isset($_POST['sticker'])) {
            MakephotoController::applySticker($final_image, $_POST['sticker']);
        }
        // save changed image
        imagepng($final_image,  $dir_name . $file_name);
        Photos::addNewPhoto($dir_name . $file_name, $_SESSION['user_id']);
        // clean image
        imagedestroy($final_image);
        // sending path for javascript img tag
        $res = ['path' => $dir_name . $file_name];
        echo json_encode($res);
    }

    public function photoCreatePostUploadFile()
    {
        $errors = $this->sessionRepository->getErrorMessagesInArray();
        $dirName = '/public/uploads/photos/';

        if(!is_dir(ROOT . $dirName)) {
            mkdir(ROOT . $dirName, 0777, true);
        }

        $name =  date('Y_m_d') . '_' . rand(1, 10111) . '.png';

        $uploadPath = $dirName . $name;

        if (count($errors) == 0) {
            if (isset($_FILES['file'])) {
                if ($_FILES['file']['size'] != 0 and $_FILES['file']['size'] <= 10240000) {
                    move_uploaded_file($_FILES['file']['tmp_name'], ROOT . $uploadPath);
                    // add file to data base
                    $this->photoRepository->savePhoto($uploadPath, auth()->id);
                    echo 'success';
                }
            }
            header("Location: /photo/create");
            return true;
        } else {
            $this->sessionRepository->setErrorMessages($errors);
            header("Location: /photo/create");
        }
        return true;
    }
}