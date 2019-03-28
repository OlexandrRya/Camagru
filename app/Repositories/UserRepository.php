<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function confirmUser($userId)
    {
        $this->userModel->confirmUser($userId);
    }

    public function informUserAboutComment($photo)
    {
        $this->userModel->loginWithUserIdWithoutPassword($photo['user_id']);

        if ($this->userModel->isEmailInforming == 1 && $this->userModel->id !== auth()->id) {

            $emailSubject = "Camagru notification";
            $encode  = "utf-8";
            $subject = array(
                "output-charset" => $encode,
                "input-charset" => $encode,
                "line-break-chars" => "\r\n",
                "line-length" => 76
            );
            $emailMessage = '
                <html>
                    <head>
                    </head>
                    <body>
                        <div style="text-align: center;font-family: \'Lato\', \'appleLogo\', sans-serif">
                            <h1>Hello '.$this->userModel->name.', you have new comment below your photo!</h1>
                        </div>
                    </body>
                </html>
            ';

            $emailHeader = "Content-type: text/html; charset=".$encode." \r\n";
            $emailHeader .= "From: Camagru <no-reply@camagru.com> \r\n";
            $emailHeader .= "MIME-Version: 1.0 \r\n";
            $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
            $emailHeader .= "Date: ".date("r (T)")." \r\n";
            $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subject);

            $result = mail($this->userModel->email, $emailSubject, $emailMessage, $emailHeader);
            return $result;
        }
        return NULL;
    }
}