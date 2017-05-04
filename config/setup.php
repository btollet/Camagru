<?php

    $DB_DSN = 'mysql:host=localhost';
    $DB_USER = 'root';
    $DB_PASSWORD = 'root';

try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

try {
    $bdd->exec("CREATE DATABASE camagru");
} catch (PDOException $e) {
    echo 'Camagru already exist</br>';
}

$bdd->exec("USE camagru");

try {
    $bdd->exec("CREATE TABLE user(
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        login varchar(255) NOT NULL,
        password text NOT NULL,
        mail varchar(255) NOT NULL,
        confirm tinyint(1) NOT NULL,
        code varchar(8) NOT NULL
    )");
} catch (PDOException $e){
    echo 'User table already existe</br>';
}

try {
    $bdd->exec("CREATE TABLE picture(
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        login varchar(255) NOT NULL,
        date_pub datetime NOT NULL
    )");
} catch (PDOException $e){
    echo 'User table already existe</br>';
}

try {
    $bdd->exec("CREATE TABLE t_like(
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        id_img int NOT NULL,
        login varchar(255) NOT NULL
    )");
} catch (PDOException $e){
    echo 'Like table already existe</br>';
}

if (!file_exists('../private'))
    mkdir ('../private');

?>