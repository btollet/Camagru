<?php
if ($_SESSION['login'])
{
?>

<div id='account'>
    <form method="post">
        Nouveau mot de passe: <input type="password" name="new_pw"><br/>
        <input type="submit" name="submit">
    </form>
</div>

<?php
}
?>