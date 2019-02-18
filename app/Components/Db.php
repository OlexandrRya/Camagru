<?php

class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT."/config/db_params.php";
        $params = include($paramsPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

    public static function getConnectionIfExistDb()
    {
        $paramsPath = ROOT."/config/db_params.php";
        $params = include($paramsPath);
        $dsn = "mysql:host=localhost";
        $db = new PDO($dsn, $params['user'], $params['password']);

        return $db;
    }

}