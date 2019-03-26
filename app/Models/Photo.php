<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class Photo
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function createPhoto($photoPath, $userId)
    {
        $sql = "
            INSERT INTO `photos`
            (
              `photo_path`, 
              `user_id`
            )
            VALUES 
            (
              :photoPath, 
              :userId
            )
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':photoPath' => $photoPath,
                ':userId' => $userId
            )
        );
    }

    public function getAll()
    {
        $sql = "
            SELECT * 
            FROM `photos` 
            WHERE 1
            ORDER BY `photos`.created_at DESC;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array()
        );
        $photos = $sth->fetchAll();

        return $photos;
    }

    public static function checkUserPhoto($userId, $photoId)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT id
            FROM photos
            WHERE `id` = :photoId AND `user_id` = :userId
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':userId' => $userId,
                ':photoId' => $photoId
            )
        );
        $photo = $sth->fetchAll();
        $photo = array_shift($photo);

        if (isset($photo['id'])) {
            return true;
        }
        return false;
    }

    public function removePhoto($userId, $photoId)
    {
        $sql = "
            DELETE 
            FROM photos
            WHERE 
              `id` = :photoId AND `user_id` = :userId;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':photoId' => $photoId,
                ':userId' => $userId
            )
        );
    }
}