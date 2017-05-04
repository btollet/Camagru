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
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;

    if ($id)
    {
        $exist = $bdd->prepare('SELECT * FROM picture WHERE id = :id');
        $exist->execute(array('id' => $id));

        if ($exist->rowCount() == 1)
        {
            $is_like = $bdd->prepare('SELECT * FROM t_like WHERE id_img = :id AND login = :login');
            $is_like->execute(array('id' => $id, 'login' => $_SESSION['login']));

            if ($is_like->rowCount() == 0)
            {
                $add_like = $bdd->prepare('INSERT INTO t_like(id_img, login) VALUES (:id, :login)');
                $add_like->execute(array('id' => $id, 'login' => $_SESSION['login']));
                echo 'add';
            }
            else
            {
                $rem_like = $bdd->prepare('DELETE FROM t_like WHERE id_img = :id AND login = :login');
                $rem_like->execute(array('id' => $id, 'login' => $_SESSION['login']));
                echo 'remove';
            }
        }
    }
}

?>