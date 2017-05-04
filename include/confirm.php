<?php

$message = null;

if ($get_key)
{
    $exist = $bdd->prepare("SELECT * FROM user WHERE id = :id AND code = :key AND confirm = 0");
    $exist->execute(array('id' => $get_id, 'key' => $get_key));
    
    if ($exist->rowCount() == 1)
    {
        $confirm = $bdd->prepare("UPDATE user SET confirm = 1 WHERE id = :id AND code = :key");
        $confirm->execute(array('id' => $get_id, 'key' => $get_key));
        $message = "Votre compte a été confirmer, vous pouvez maintenant vous connecter !";
    }
}
if (!$message)
    $message = 'Erreur lors de la validation du compte, veuillez reesayer';
?>

<div id='main'>
    <p><?php echo $message; ?></p>
</div>