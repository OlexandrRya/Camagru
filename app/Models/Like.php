<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class Like
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function createLike($userId, $photoId)
    {

        $sql = "
            INSERT INTO `likes`
            (
              `user_id`, 
              `photo_id`
            )
            VALUES 
            (
              :userId, 
              :photoId
            )
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':userId' => $userId,
                ':photoId' => $photoId
            )
        );
    }

    public function removeLike($userId, $photoId)
    {
        $sql = "
            DELETE 
            FROM likes 
            WHERE 
              `user_id` = :userId
              AND 
              `photo_id` = :photoId
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':userId' => $userId,
                ':photoId' => $photoId
            )
        );
    }

    public static function countLikes($photoId)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT COUNT(id) as count_like
            FROM likes
            WHERE `photo_id` = :photoId
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':photoId' => $photoId
            )
        );
        $likes = $sth->fetchAll();
        $likes = array_shift($likes);

        return $likes['count_like'];
    }

    public static function checkUserLike($userId, $photoId)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT user_id
            FROM likes
            WHERE `photo_id` = :photoId AND `user_id` = :userId
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':userId' => $userId,
                ':photoId' => $photoId
            )
        );
        $like = $sth->fetchAll();
        $like = array_shift($like);

        if (isset($like['user_id'])) {
            return true;
        }
        return false;
    }

}