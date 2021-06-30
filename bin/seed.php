<?php
// require all libs
require_once "../config/db.php";
require_once "../utils/functions.php";
try {
    // loop 10 times to seed DB 10 times
    for ($i = 0; $i < 10; $i++) {
        // generate random firstname
        $firstname = random();
        // generate random lastname
        $lastname  = random();
        // generate random email
        $email = random(5) . "@" . random(10) . ".com" ;
        $gendor = 'male';
        $photo = '';
        $password = "password12345";
        // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // insert data into DB
        $statment = $pdo->prepare("INSERT INTO users (email,firstname,lastname,gendor,photo,password)
        VALUES (:email,:firstname,:lastname,:gendor,:photo,:password);");
        $statment->bindValue(':email', $email);
        $statment->bindValue(':firstname', $firstname);
        $statment->bindValue(':lastname', $lastname);
        $statment->bindValue(':gendor', $gendor);
        $statment->bindValue(':photo', $image);
        $statment->bindValue(':password', $password);
        $statment->execute();
        echo "DB has been seeds ...";
    }
} catch (\Throwable $th) {
    echo $th;
}
