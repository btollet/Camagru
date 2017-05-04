<?php

if (!$_SESSION['login'])
{
?>
<form action="index.php" method="post" class="right">
    Login: <input class="case" type="text" name="co_login">
    Mot de Passe: <input class="case" type="password" name="co_passwd"> 
    <input type="submit" name="connexion" value="Connexion">
</form>
<?php
}
else
{
?>
<table>
    <td>
        <tr>
            <form action="index.php" method="post">
                <input type="submit" name="index" value="Accueil">
            </form>
        </tr>
        <tr>
            <form action="?page=picture" method="post">
                <input type="submit" name="picture" value="Prendre photo">
            </form>
        </tr>
        <tr>
            <form action="?action=logout" method="post">
                <input type="submit" name="logout" value="Deconnexion">
            </form>
        </tr>
    </td>
</table>
<?php
}
?>