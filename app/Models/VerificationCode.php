<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class VerificationCode
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function closeVerificationAndReturnUserId($verificationCode)
    {
        $userId = $this->getUserIdFromVerificationId($verificationCode);
        if (isset($userId)) {
            $this->setDateToVerification($verificationCode);
        }
    }

    private function setDateToVerification($verificationCode)
    {
        $sql = "
            UPDATE verifications 
                SET `verified_at` = CURRENT_TIMESTAMP
            WHERE verification_code = :verificationCode AND verified_at IS NULL;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':verificationCode' => $verificationCode));
    }

    private function getUserIdFromVerificationId($verificationCode)
    {
        $sql = "
            SELECT user_id 
            FROM `verifications` 
            WHERE verification_code = :verificationCode AND verified_at IS NULL;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':verificationCode' => $verificationCode));
        $verificationCodes = $sth->fetchAll();
        $verificationCodeRow = array_shift($verificationCodes);
        $userId = isset($verificationCodeRow) ? $verificationCodeRow['user_id']: NULL;

        return $userId;
    }

    /**
     * Create verification code to user and return him.
     *
     * @param $userId
     * @return string
     */
    public function createVerificationCodeToUser($userId)
    {
        $sql = "
            INSERT INTO `verifications` 
            (
                user_id,
                verification_code,
            ) 
            VALUES 
            (
              :userId, 
              :verificationCode, 
            )
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $verificationCode = md5(time() . $userId);
        $sth->execute(
            array(
                ':userId' => $userId,
                ':verificationCode' => $verificationCode,
            )
        );

        return $verificationCode;
    }
}