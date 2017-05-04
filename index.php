<?php

session_start();

include ("config/database.php");
include ("include/function.php");

try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$message = null;
$get_action = isset($_GET['action']) ? $_GET['action'] : null;
$get_page = isset($_GET['page']) ? $_GET['page'] : null;
$get_key = isset($_GET['key']) ? $_GET['key'] : null;
$get_id = isset($_GET['id']) ? $_GET['id'] : null;

check_logout($get_action);

if (isset($_POST['connexion']) == "Connexion" && isset($_POST['co_login']) && isset($_POST['co_passwd']) && !$_SESSION['login'])
{
    $passwd = hash('whirlpool', $_POST['co_passwd']);
    
    $exist = $bdd->prepare("SELECT * FROM user WHERE login = :login AND password = :pass AND confirm = 1");
    $exist->execute(array('login' => $_POST['co_login'], 'pass' => $passwd));
    
    if ($exist->rowCount() == 0)
        $message = 'Mauvais login ou mot de passe</br>Verifier que votre compte est bien valider';
    else
        $_SESSION['login'] = $_POST['co_login'];
}

?>

<html>
    <head>
        <title>Camagru</title>
        <link rel="stylesheet" href="style/index.css">
    </head>
    <body>
    <div id="header">
        <center><a href="index.php"><h1>Camagru</h1></a></center>
    </div>
    <div id="menu">
        <?php include ("include/menu.php"); ?>
    </div>
        <?php
            if ($_SESSION['login'])
            {
                if ($get_page == 'picture')
                    include ("include/cam.php");
                else
                    include ("include/wall.php");
            }
            else
            {
                if ($get_action == 'confirm')
                    include ("include/confirm.php");
                else
                    include ("include/register.php");
            }
        ?>
        <div id="footer">
            <p>Camagru <i>© btollet 2017</i></p>
        </div>
    </body>
</html>