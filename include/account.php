<?php
if ($_SESSION['login'])
{
    $post_new_pw = isset($_POST['new_pw']) ? htmlspecialchars($_POST['new_pw']) : null;

    if ($post_new_pw && isset($_POST['submit']))
    {
        $check_pass = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $post_new_pw);
        if ($check_pass)
        {
            $pass = hash('whirlpool', $post_new_pw);

            $change_pw = $bdd->prepare('UPDATE user SET password = :pass WHERE login = :login');
            $change_pw->execute(array('pass' => $pass, 'login' => $_SESSION['login']));

            $message = 'Mot de passe changer !';
        }
        else
            $message = 'Votre mot de passe doit contenir au moins:<br/>- 1 chiffre<br/>- 1 minuscule<br/>- 1 majuscule<br/>- 8 characteres';
    }
?>

<div id='account'>
    <p><?php echo $message; ?></p>
    <h3>Modifier mon compte:</h3>
    <form method="post">
        <p>Nouveau mot de passe: <input type="password" name="new_pw"><br/>
        <input type="submit" name="submit" value="Confirmer"></p>
    </form>
</div>

<?php
}
?>