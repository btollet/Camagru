<?php

function check_logout ($get_action) {
    if ($get_action == 'logout' && $_SESSION['login'])
        $_SESSION['login'] = null;
}

function gen_key($len) {
    $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $count = strlen($char) - 1;
    for ($i = 0; $i < $len; $i++)
        $result .= $char[ rand(0, $count)];
    return ($result);
}

function confirm_mail ($mail, $login, $key, $id) {
    $header = 'From: btollet@student.42.fr' . "\r\n";
    $header .= 'Content-Type: text/html';
    $text = '<html><h1>Camagru</h1><p>Voici le lien afin de finaliser votre inscription sur Camagru: <a href="http://localhost:8080' .$_SERVER['REQUEST_URI'].'?action=confirm&id='.$id.'&key='.$key.'">Confirmer mon adresse mail</a></p></html>';
    
    if (mail($mail, 'Confirmation compte Camagru', $text, $header))
        return (TRUE);
    return (FALSE);
}

function add_picture ($link, $bdd, $id_cadre, $x, $y) {
    if ($_SESSION['login'])
    {
        if (!file_exists('private'))
            mkdir('private');
        $add_bdd = $bdd->prepare("INSERT INTO picture (login, date_pub) VALUES (:login, :date_pub)");
        $add_bdd->execute(array('login' => $_SESSION['login'], 'date_pub' => date('Y-m-d H:i:s')));
        $id = $bdd->lastInsertId('id');

        $source = imagecreatefrompng($link);
        $cadre = imagecreatefrompng($id_cadre. '.png');
        $resize = imagecreatetruecolor(200, 200);

        list($largeur, $hauteur) = getimagesize($id_cadre. '.png');
        imagecopyresized($source, $cadre, $y, $x, 0, 0, 200, 200, $largeur, $hauteur);

        imagepng($source, 'private/' .$id. '.png');
        imagedestroy($resize);
        imagedestroy($source);
        imagedestroy($cadre);
    }
}

?>