<?php

$save_link = isset($_POST['save_link']) ? $_POST['save_link'] : null;

if ($save_link)
    add_picture($save_link, $bdd);

?>
<div id="take_picture">
    <video id="video"></video>
    <canvas id="preview"></canvas>
    <img src="cadre.gif" width="200" height="200" id="cadre" onclick="change_cadre()">
    <form src="" method="post">
        <button name="photo" id="startbutton" onclick="picture()">Take photo</button>
        <input type="text" name="save_link" id="save_link" hidden="hidden">
    </form>
    <canvas id="canvas"></canvas>
    <img id="photo" src="<?php echo $save_link; ?>">
    <img id="cam">
    <script type="text/javascript" src="script/cam.js"></script>
</div>

<div id="my_picture">
    <center><p>Dernieres photos:</p></center>
    <?php
    $picture = $bdd->prepare("SELECT * FROM picture WHERE login = :login ORDER BY date_pub DESC LIMIT 5");
    $picture->execute(array('login' => $_SESSION['login']));

    if ($picture->rowCount() == 0)
        echo '0 photo';
    foreach ($picture as $data)
    {
        $count_like = $bdd->query('SELECT * FROM t_like WHERE id_img = ' .$data['id']);
        echo '<hr><table><td><img src="private/' .$data['id']. '.png"></td><td>Like: ' .$count_like->rowCount(). '</br>Commentaires:</td></table>';
    }
    ?>
</div>