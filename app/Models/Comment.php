<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function createComment($userId, $photoId, $text)
    {

        $sql = "
            INSERT INTO `comments`
            (
              `user_id`, 
              `photo_id`,
              `text`
            )
            VALUES 
            (
              :userId, 
              :photoId,
              :text
            )
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':userId' => $userId,
                ':photoId' => $photoId,
                ':text' => $text
            )
        );
    }

    public function removeComment($userId, $commentId)
    {
        $sql = "
            DELETE 
            FROM comments
            WHERE 
              `id` = :commentId AND `user_id` = :userId
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':commentId' => $commentId,
                ':userID' => $userId
            )
        );
    }

    public static function checkText($text)
    {
        $error = '';

        if (strlen($text) > 254){
            return "Comment can't be more than 254 characters!";
        }
        return $error;
    }

    public static function getCommentsFromPhoto($photoId)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT *
            FROM `comments`
            WHERE `photo_id` = :photoId
            ORDER BY `created_at` ASC
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':photoId' => $photoId
            )
        );
        $comments = $sth->fetchAll();

        return $comments;
    }
}