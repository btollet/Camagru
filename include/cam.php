<?php

if ($_SESSION['login'])
{

$save_link = isset($_POST['save_link']) ? $_POST['save_link'] : null;
$save_cadre = isset($_POST['save_cadre']) ? $_POST['save_cadre'] : null;
$save_x = isset($_POST['save_x']) ? intval($_POST['save_x']) : null;
$save_y = isset($_POST['save_y']) ? intval($_POST['save_y']) : null;

echo $save_x;
echo $save_y;

if ($save_link && $save_cadre && is_numeric($save_x) && is_numeric($save_y))
    add_picture($save_link, $bdd, $save_cadre, $save_x, $save_y);
else if ($save_link && !$save_cadre)
    $message = 'Il faut choisir un cadre !';

?>
<div id="take_picture">
    <p><?php echo $message; ?></p>
    <video id="video"></video>
    <canvas id="preview"></canvas>
    <img src="1.png" width="200" height="200" id="cadre1" onclick="change_cadre(1)">
    <img src="2.png" width="200" height="200" id="cadre2" onclick="change_cadre(2)">
    <table>
        <tr>
            <td></td>
            <td><button name="photo" onclick="move(1)">^</button></td>
            <td></td>
        </tr>
        <tr>
            <td><button name="photo" onclick="move(2)"><</button></td>
            <td><button name="photo" onclick="move(3)">v</button></td>
            <td><button name="photo" onclick="move(4)">></button></td>
        </tr>
    </table>
    <form src="" method="post">
        <button name="photo" id="startbutton" onclick="picture()">Take photo</button>
        <input type="text" name="save_link" id="save_link" hidden="hidden">
        <input type="text" name="save_cadre" id="save_cadre" hidden="hidden">
        <input type="text" name="save_x" id="save_x" hidden="hidden">
        <input type="text" name="save_y" id="save_y" hidden="hidden">
    </form>
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
        echo '<hr><table><td><img src="private/' .$data['id']. '.png"></td><td><p>Like: ' .$count_like->rowCount(). '</br>Commentaires:</p></td></table>';
    }
    ?>
</div>

<?php
}
?>