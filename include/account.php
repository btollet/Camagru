<?php
if ($_SESSION['login'])
{
    $post_new_pw = isset($_POST['new_pw']) ? htmlspecialchars($_POST['new_pw']) : null;
    
    if ($post_new_pw && isset($_POST['submit']))
    {
        $pass = hash('whirlpool', $post_new_pw);
        
        $change_pw = $bdd->prepare('UPDATE user SET password = :pass WHERE login = :login');
        $change_pw->execute(array('pass' => $pass, 'login' => $_SESSION['login']));
        
        $message = 'Mot de passe changer !';
    }
?>

<div id='account'>
    <p><?php echo $message; ?></p>
    <p>Modifier mon compte:</p>
    <form method="post">
        Nouveau mot de passe: <input type="password" name="new_pw"><br/>
        <input type="submit" name="submit" value="Confirmer">
    </form>
</div>

<?php
}
?>