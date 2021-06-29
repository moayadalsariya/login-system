<?php
// Not complte, columns missing
require_once "../config/db.php";
require_once "../utils/functions.php";
try {
    for ($i = 0; $i < 10; $i++) {
        $username = random();
        $email = random(5) . "@" . random(10) . ".com" ;
        $password = "password12345";
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statment = $pdo->prepare("INSERT INTO users (username,email,password)
        VALUES (:username,:email,:password);");
        $statment->bindValue(':username', $username);
        $statment->bindValue(':email', $email);
        $statment->bindValue(':password', $password);
        $statment->execute();
        echo "DB has been seeds ...";
    }
} catch (\Throwable $th) {
    echo $th;
}
