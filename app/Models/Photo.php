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
}