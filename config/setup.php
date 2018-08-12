<?php

include_once ROOT.'/components/Db.php';

// CREATE DATABASE
try {
    $paramsPath = ROOT."/config/db_params.php";
    $params = include($paramsPath);

	$sql = "CREATE DATABASE `".$params['dbname']."`";
	
	$db = Db::getConnection();
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec($sql);
	echo "Database created successfully\n";
} catch (PDOException $e) {
	echo "EROOR creating DATABASE: \n".$e->getMessage()."\nAborting process\n";
	exit (-1);
}