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
        $errors = $this->sessionRepository->getErrorMessagesInArray();
        $dirName = '/public/uploads/photos/';

        $fileName = date('Y_m_d') . '_' . rand(1, 10000) . '.png';

        $uploadPath = ROOT . $dirName . $fileName;

        if (count($errors) == 0) {

            $this->photoRepository->savePhotoFromCamera($_POST['img'], $fileName, $dirName);

            $finalImage = imagecreatefrompng($uploadPath);
            imagesavealpha($finalImage, true);
            imagealphablending($finalImage, true);

            $this->photoRepository->applyFilterToPhoto($finalImage, $_POST['filter']);

            if (isset($_POST['sticker'])) {
                $this->photoRepository->applySticker($finalImage, $_POST['sticker']);
            }

            imagepng($finalImage, $uploadPath);

            $this->photoRepository->savePhoto($dirName . $fileName, auth()->id);

            imagedestroy($finalImage);

            $res = ['path' => $dirName . $fileName];
            echo json_encode($res);
        } else {
            echo json_encode($errors);
        }

        return true;
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

                    $this->photoRepository->savePhoto($uploadPath, auth()->id);

                    echo 'success';
                }
            }
            return true;
        } else {
            echo json_encode($errors);
        }
        return true;
    }
}