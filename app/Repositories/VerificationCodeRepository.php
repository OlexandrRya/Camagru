<?php

namespace App\Repositories;


use App\Models\VerificationCode;
use App\Models\User;

class VerificationCodeRepository
{
    private $verificationCodeModel;

    public function __construct()
    {
        $this->verificationCodeModel = new VerificationCode();
    }

    public function confirmCodeAndReturnUserId($confirmCode)
    {
        $userId = $this->verificationCodeModel->closeVerificationAndReturnUserId($confirmCode);

        return $userId;
    }

    public function createConfirmCodeAndSentConfirmEmailToUser(User $user)
    {
        $confirmCode = $this->verificationCodeModel->createVerificationCodeToUser($user->getUserId());

        $this->sendConfirmationEmail($user, $confirmCode);
    }

    public function sendConfirmationEmail($user, $confirmCode) {
        $emailSubject = "Email verification";
        $encode  = "utf-8";
        $subject = array(
            "output-charset" => $encode,
            "input-charset" => $encode,
            "line-break-chars" => "\r\n",
            "line-length" => 76
        );
        $appUrl = getConfigParam('generalConfig', 'app_url');
        $emailMessage = '
        <html>
            <head>
            </head>
            <body>
                <div style="text-align: center;font-family: \'Lato\', \'appleLogo\', sans-serif">
                    <h1>Hey '.$user->name.', thanks for signing up!</h1>
                    <p>Account has been created, to active follow the url below.</p>
                    <a href="' . $appUrl . '/confirm?confirmCode=' . $confirmCode .'">Confirm</a>
                </div>
            </body>
        </html>
        ';

        $emailHeader = "Content-type: text/html; charset=".$encode." \r\n";
        $emailHeader .= "From: Photo Creator <no-reply@camagru.com> \r\n";
        $emailHeader .= "MIME-Version: 1.0 \r\n";
        $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
        $emailHeader .= "Date: ".date("r (T)")." \r\n";
        $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subject);

        $result = mail($user->email, $emailSubject, $emailMessage, $emailHeader);

        return $result;
    }
}