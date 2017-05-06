<?php

$mail_error = FALSE;
$p_login = isset($_POST['reg_login']) ? htmlspecialchars($_POST['reg_login']) : null;
$p_pass = isset($_POST['reg_passwd']) ? htmlspecialchars($_POST['reg_passwd']) : null;
$p_mail = isset($_POST['reg_mail']) ? htmlspecialchars($_POST['reg_mail']) : null;

if ($p_mail)
    if (!filter_var($p_mail, FILTER_VALIDATE_EMAIL))
        $mail_error = TRUE;

if (isset($_POST['reg_submit']) == 'Inscription' && $p_login && $p_pass && $p_mail && !$mail_error)
{
    $len_login = strlen($p_login);
    $check_pass = preg_match('^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $p_pass);
    if ($check_pass)
    {
        $pass = hash('whirlpool', $p_pass);

        $exist = $bdd->prepare("SELECT * FROM user WHERE login = :login OR mail = :mail");
        $exist->execute(array('login' => $p_login, 'mail' => $p_mail));
        if ($exist->rowCount() == 0)
        {
            $key = gen_key(8);

            $add = $bdd->prepare("INSERT INTO user (login, password, mail, confirm, code) VALUES (:login, :passwd, :mail, 0, :key)");
            $add->execute(array('login' => $p_login, 'passwd' => $pass, 'mail' => $p_mail, 'key' => $key));

            $id = $bdd->lastInsertId('id');
            if (!confirm_mail($p_mail, $p_login, $key, $id[0]))
                $message = 'Erreur lors de l\'envoi du mail de confirmation';
            else
            {
                $message = 'Compte creer avec succes !<br/>Un mail a été envoyer a votre adresse mail pour valider votre inscription';
                $p_login = null;
                $p_pass = null;
                $p_mail = null;
            }
        }
        else
            $message = 'Login ou adresse mail deja existant';
    }
    else
        $message = 'Error pass';
}

?>

<div id="main">
    <?php
    echo '<p>'.$message.'</p><br/>';
    ?>
    Inscription:
    <form action="index.php" method="POST">
        Login: <input type="text" name="reg_login" value="<?php echo $p_login; ?>"> 
        <?php 
        if (isset($_POST['submit']) == 'Inscription' && !$p_login)
            echo '<- Ne peu être vide !';
        ?>
        <br/>
        Mot de passe: <input type="password" name="reg_passwd" value="<?php echo $p_pass; ?>">
        <?php 
        if (isset($_POST['submit']) == 'Inscription' && !$p_pass)
            echo '<- Ne peu être vide !';
        ?>
        <br/>
        Adresse mail: <input type="mail" name="reg_mail" value="<?php echo $p_mail; ?>">
        <?php 
        if (isset($_POST['submit']) == 'Inscription' && !$p_mail)
            echo '<- Ne peu être vide !';
        if ($p_mail && $mail_error)
            echo '<- Adresse mail non valide';
        ?>
        <br/>
        <input type="submit" name="reg_submit" value="Inscription">
    </form>
</div>