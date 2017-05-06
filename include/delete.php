<?php

session_start();

include ("../config/database.php");

if ($_SESSION['login'])
{
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    
    $get_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
    if ($get_id)
    {
        $delete = $bdd->prepare('DELETE FROM picture WHERE id = :id AND login = :login');
        $delete->execute(array('id' => $get_id, 'login' => $_SESSION['login']));
        
        if ($delete->rowCount() == 1)
        {
            $delete_like = $bdd->prepare('DELETE FROM t_like WHERE id_img = :id');
            $delete_like->execute(array('id' => $get_id));
            unlink('../private/' .$get_id. '.png');

            echo 'Ok';
        }
    }
}
?>