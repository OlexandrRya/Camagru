<?php

namespace App\Repositories;


use App\Models\VerificationCode;
use App\Models\User;

class VerificationCodeRepository
{
    private $verificationCodeModel;
    private $userModel;

    public function __construct()
    {
        $this->verificationCodeModel = new VerificationCode();
        $this->userModel = new User();
    }

    public function createConfirmCodeAndSentRestorePasswordEmailToUser($userEmail)
    {
        $confirmCode = $this->verificationCodeModel->createVerificationCodeToUser(User::getUserInfoByEmail($userEmail)['id']);

        $this->userModel->loginWithEmailWithoutPassword($userEmail);

        $this->sendRestorePasswordEmail($confirmCode);
    }

    private function sendRestorePasswordEmail($confirmCode) {
        $emailSubject = "Password restore";
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
                    <h1>Hey '.$this->userModel->name.', you forgot password!</h1>
                    <p>For restore password, click to this link.</p>
                    <a href="' . $appUrl . '/auth/restore-password/show?confirmCode=' . $confirmCode .'">Confirm</a>
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
        $emailHeader .= "From: Camagru <no-reply@camagru.com> \r\n";
        $emailHeader .= "MIME-Version: 1.0 \r\n";
        $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
        $emailHeader .= "Date: ".date("r (T)")." \r\n";
        $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subject);

        $result = mail($user->email, $emailSubject, $emailMessage, $emailHeader);

        return $result;
    }
}