<?php

if ($_SESSION['login'])
{
    $com_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
    $com_text = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : null;
    
    if ($com_id)
    {
        $check_pic = $bdd->prepare('SELECT * FROM picture WHERE id = :id');
        $check_pic->execute(array('id' => $com_id));

        if ($check_pic->rowCount() == 1)
        {
            if (isset($_POST['sub_com']) == 'Envoyer' && $com_text)
            {
                if (strlen($com_text) <= 1000)
                {
                    $add_com = $bdd->prepare('INSERT INTO comment(id_img, login, message, date_pub) VALUES (:id, :login, :message, :date)');
                    $add_com->execute(array('id' => $com_id, 'login' => $_SESSION['login'], 'message' => $com_text, 'date' => date('Y-m-d H:i:s')));
                    
                    $mail = $bdd->prepare('SELECT user.mail FROM user, picture WHERE picture.id = :id AND picture.login = user.login ');
                    $mail->execute(array('id' => $com_id));
                    foreach($mail as $data)
                        
                    
                    $com_text = null;
                }
                else
                    $message = 'Votre message est trop long (1000 characteres maximum)';
            }
            
            $comment = $bdd->prepare('SELECT * FROM comment WHERE id_img = :id ORDER BY date_pub DESC');
            $comment->execute(array('id' => $com_id));

?>
<center>
    <div id="comment">
        <p><?php echo $message; ?></p>
        <img src="private/<?php echo $com_id; ?>.png">
        <hr>
        <?php
            foreach($comment as $data)
                echo '<p><b>' .$data['login']. '</b>:<br/>' .$data['message']. '</p><hr>';
        ?>
        <form action="" method="post">
            <h3>Ecrire un commentaire:</h3>
            <p>(1000 characteres maximum)</p>
            <textarea name="comment"><?php echo $com_text; ?></textarea><br/>
            <input type="submit" name="sub_com" value="Envoyer">
        </form>
    </div>
</center>

<?php
        }
        else
            include('wall.php');
    }
    else
        include('wall.php');
}

?>