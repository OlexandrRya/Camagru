<?php

class User
{
    public $name = NULL;
    public $email = NULL;
    public $isAdmin = 0;

    public function login($email, $password)
    {
        $user = $this->getUser($email);
        $passwordHash = $user['password'];
        if ($this->verifyPass($password, $passwordHash)) {
            $this->name = $user['user_name'];
            $this->email = $user['email'];
            $this->isAdmin = $user['is_admin'];
        }
    }

    private function getUser($email)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT email, user_name, is_admin, password 
            FROM `users` 
            WHERE email = :email;
        ";
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));
        $users = $sth->fetchAll();
        $user = array_shift($users);
        return $user;
    }

    private function createUser()
    {
        $db = Db::getConnection();
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
        $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $_POST['email'],
            ':name' => $_POST['name'],
            ':passwordHash' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ));
    }

    public function register()
    {
        $user = $this->getUser($_POST['email']);
        if ($user) {
            return NULL;
        }
        $this->createUser($_POST);
        $this->login($_POST['email'], $_POST['password']);
    }

    private function verifyPass($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }
}