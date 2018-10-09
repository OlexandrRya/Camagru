<?php

class User
{
    public $name = NULL;
    public $email = NULL;
    public $isAdmin = 0;

    public function login($email, $password)
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
        $passwordHash = $user['password'];
        if ($this->verifyPass($password, $passwordHash)) {
            $this->name = $user['user_name'];
            $this->email = $user['email'];
            $this->isAdmin = $user['is_admin'];
        }
    }
    private function verifyPass($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }
}