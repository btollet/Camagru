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

function add_picture ($link, $bdd) {
    if ($_SESSION['login'])
    {
        if (!file_exists('private'))
            mkdir('private');
        if (!file_exists('private/' .$_SESSION['login']))
            mkdir('private/' .$_SESSION['login']);
        $add_bdd = $bdd->prepare("INSERT INTO picture (login, date_pub) VALUES (:login, :date_pub)");
        $add_bdd->execute(array('login' => $_SESSION['login'], 'date_pub' => date('Y-m-d H:i:s')));
        $id = $bdd->lastInsertId('id');
        
        $link = str_replace('data:image/png;base64,', '', $link);
        file_put_contents('private/' .$_SESSION['login']. '/' .$id. '.png' , base64_decode($link));
    }
}

?>