<?php
include 'database.php';

// CREATE DATABASE
try {
	$sql = "CREATE DATABASE `".$DB_NAME."`";
	
	$db = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec($sql);
	echo "Database created successfully\n";
} catch (PDOException $e) {
	echo "EROOR creating DATABASE: \n".$e->getMessage()."\nAborting process\n";
	exit (-1);
}