<?php
namespace Config;

use App\Components\Db;
use PDOException;

// CREATE DATABASE
try {
    $paramsPath = ROOT."/config/db_params.php";
    $params = include($paramsPath);
    $db = Db::getConnectionIfExistDb();

    $sql = 'DROP DATABASE IF EXISTS ' . $params['dbname'];
    $db->exec($sql);

    $sql = "CREATE DATABASE `".$params['dbname']."`";
	$db->exec($sql);

    $db = Db::getConnection();

    /**
     * Create users table
     */
    $sql = "CREATE TABLE users (
		id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_name VARCHAR(254) NOT NULL,
		password VARCHAR(254) NOT NULL,
		email VARCHAR(254),
		is_verified BOOLEAN NOT NULL DEFAULT FALSE,
		is_admin BOOLEAN NOT NULL DEFAULT FALSE
	)";
    $db->exec($sql);

    $sql = "CREATE TABLE verifications (
		id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_id INT(11) NOT NULL,
		verification_code VARCHAR(254) NOT NULL,
		verified_at TIMESTAMP NULL DEFAULT NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	)";
    $db->exec($sql);

    /**
     * Insert admin user to database.
     */
    $sql = "
        INSERT INTO `users` 
        (
          `id`,
          `user_name`,
          `password`,
          `email`,
          `is_verified`,
          `is_admin`
        )
        VALUES
        (
          '1',
          'admin',
          '" . password_hash("12345", PASSWORD_DEFAULT) ."',
          'admin@admin.com',
          '1',
          '1'
        );
    ";
    $db->exec($sql);


    echo "Database created successfully\n";
    header('Location: /');
} catch (PDOException $e) {
	echo "EROOR creating DATABASE: \n".$e->getMessage()."\nAborting process\n";
	exit (-1);
}