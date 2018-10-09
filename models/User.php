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
        $user = $sth->fetchAll();
        var_dump($user[0]['email']);
        die();
        $verify = password_verify($password, $user->password);


    }
}