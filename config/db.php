<?php
$DB_SERVER = 'localhost';
$DB_USERNAME = 'root';
$DB_PORT = '3306';
$DB_PASSWORD = '';
$DB_NAME = 'login_sys';

$pdo = new PDO("mysql:host=$DB_SERVER;port=$DB_PORT;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
