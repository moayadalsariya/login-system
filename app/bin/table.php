<?php
// require DB
require_once "../config/db.php";
// CREATE users table in DB
try {
    $statment = $pdo->prepare("CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        gendor VARCHAR(255) NOT NULL,
        photo VARCHAR(255),
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");
    $statment->execute();
    echo "users table is successful created ...";
} catch (\Throwable $th) {
    echo "table is already created ..";
}