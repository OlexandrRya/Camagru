<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class User
{
    public $name = NULL;
    public $email = NULL;
    public $isAdmin = 0;

    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function login($email, $password)
    {
        $user = $this->getUserFromEmail($email);
        $passwordHash = $user['password'];

        if ($this->verifyPass($password, $passwordHash)) {
            $this->name = $user['user_name'];
            $this->email = $user['email'];
            $this->isAdmin = $user['is_admin'];
        }
    }

    public function getUserId()
    {
        $sql = "
            SELECT id 
            FROM `users` 
            WHERE email = :email;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $this->email));
        $users = $sth->fetchAll();
        $user = array_shift($users);

        return isset($user['id']) ? $user['id'] : NULL;
    }

    private function getUserFromEmail($email)
    {
        $sql = "
            SELECT email, user_name, is_admin, password 
            FROM `users` 
            WHERE email = :email;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));
        $users = $sth->fetchAll();
        $user = array_shift($users);
        return $user;
    }

    private function createUser($email, $name, $password)
    {
        $sql = "
            INSERT INTO `users` 
            (
              `user_name`, 
              `password`, 
              `email`
            )
            VALUES 
            (
              :name, 
              :passwordHash, 
              :email
            )
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':email' => $email,
                ':name' => $name,
                ':passwordHash' => password_hash($password, PASSWORD_DEFAULT)
            )
        );
    }

    private function updateUser($email, $name, $password)
    {
        $sql = "
            UPDATE `users` 
            SET user_name = :name, password = :passwordHash
            WHERE email = :email;
        ";

        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(
            array(
                ':name' => $name,
                ':passwordHash' => password_hash($password, PASSWORD_DEFAULT),
                ':email' => $email
            )
        );
    }

    public function register($email, $name, $password)
    {
        $user = $this->getUserFromEmail($email);
        if (!isset($user)) {
            $this->createUser($email, $name, $password);
        } else {
            $this->updateUser($email, $name, $password);
        }
        $this->login($email, $password);
    }

    private function verifyPass($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }

    public static function getUserInfoByEmail($email)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT email, user_name, is_admin, is_verified
            FROM `users` 
            WHERE email = :email;
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));
        $users = $sth->fetchAll();
        $user = array_shift($users);
        return $user;
    }

    public static function emailAndPasswordVerification($email, $password)
    {
        $error = NULL;
        $db = Db::getConnection();
        $sql = "
            SELECT password, is_verified
            FROM `users` 
            WHERE email = :email AND is_verified = 1;
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));
        $users = $sth->fetchAll();
        $user = array_shift($users);

        if (!$user) {
            $error = 'Invalid email';
        }
        else if (!password_verify($password, $user['password'])) {
            $error = 'Invalid password';
        } else if ($user['is_verified'] == 0) {
            $error = 'You need to confirm your email.';
        }
        return $error;
    }

    public static function emailVerification($email) {
        $error = '';
        $user = User::getUserInfoByEmail($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email isn't valid.";
        } else if (isset($user) && $user['is_verified'] == 1) {
            $error = "Email has already registered.";
        }
        return $error;
    }

    public static function passwordVerification($password, $repeatedPassword) {
        $error = '';
        $passwordLen = strlen($password);
        $repeatedPassLen = strlen($repeatedPassword);

        if (strcmp($password, $repeatedPassword)) {
            $error = 'Password mismatch.';
        } else if ($passwordLen < 4 || $passwordLen != $repeatedPassLen) {
            $error = 'Too short password (Min 4 symbols).';
        } else if (!preg_match("/^(?=.*[A-Z])(?=.*\d)([0-9a-zA-Z]+)$/", $password)) {
            $error = 'Too simple password  (should contain at least one uppercase and lowercase letter and a number).';
        }
        return $error;
    }

    public function confirmUser($userId)
    {
        $sql = "
            UPDATE users 
                SET `is_verified` = TRUE
            WHERE id = :userId AND is_verified IS FALSE;
        ";
        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':userId' => $userId));
    }
}