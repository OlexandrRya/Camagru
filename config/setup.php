<?php
define('ROOT', dirname(__FILE__) . "/..");

include_once ROOT.'/components/Db.php';

// CREATE DATABASE
try {
    $paramsPath = ROOT."/config/db_params.php";
    $params = include($paramsPath);
    $db = Db::getConnectionIfExistDb();

    $sql = 'DROP DATABASE IF EXISTS ' . $params['dbname'];
    $db->exec($sql);
//
//    $sql = "CREATE DATABASE `".$params['dbname']."`";
//	$db->exec($sql);
//
//    $db = Db::getConnection();
//
//    $sql = "CREATE TABLE users (
//		id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
//		username VARCHAR(254) NOT NULL,
//		password TEXT NOT NULL,
//		email VARCHAR(254),
//		isadmin BOOLEAN NOT NULL DEFAULT FALSE
//	)";
//    $db->exec($sql);


	echo "Database created successfully\n";
} catch (PDOException $e) {
	echo "EROOR creating DATABASE: \n".$e->getMessage()."\nAborting process\n";
	exit (-1);
}