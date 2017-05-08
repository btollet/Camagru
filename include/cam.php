<?php

if ($_SESSION['login'])
{

    $save_link = isset($_POST['save_link']) ? $_POST['save_link'] : null;
    $save_cadre = isset($_POST['save_cadre']) ? $_POST['save_cadre'] : null;
    $save_x = isset($_POST['save_x']) ? intval($_POST['save_x']) : null;
    $save_y = isset($_POST['save_y']) ? intval($_POST['save_y']) : null;

    if ($save_link && $save_cadre && is_numeric($save_x) && is_numeric($save_y))
        add_picture($save_link, $bdd, $save_cadre, $save_x, $save_y);
    else if ($save_link && !$save_cadre)
        $message = 'Il faut choisir un cadre !';

?>
<script>

    function delete_img(id) {
        let xmlhttp = new XMLHttpRequest();
        let div = document.getElementById('pic' + id);

        xmlhttp.onload = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                let ret = (xmlhttp.responseText);
                if (ret == 'Ok')
                    div.style.display = 'none';
            }
        }
        xmlhttp.open("GET", 'include/delete.php?id=' + id, true);
        xmlhttp.send();
    }

</script>

<div id="take_picture">
    <p><?php echo $message; ?></p>
    <video id="video"></video>
    <input type="file" id="file_up"><br/><br/>
    <canvas id="preview"></canvas>
    <img src="1.png" width="200" height="200" id="cadre1" onclick="change_cadre(1)">
    <img src="2.png" width="200" height="200" id="cadre2" onclick="change_cadre(2)">
    <img src="3.png" width="200" height="200" id="cadre3" onclick="change_cadre(3)">
    <img src="4.png" width="200" height="200" id="cadre4" onclick="change_cadre(4)">
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
        <button name="photo" id="button" onclick="picture()" hidden="hidden">Prendre photo</button>
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
    $picture = $bdd->prepare("SELECT * FROM picture WHERE login = :login ORDER BY date_pub DESC");
    $picture->execute(array('login' => $_SESSION['login']));

    foreach ($picture as $data)
    {
        $count_like = $bdd->query('SELECT * FROM t_like WHERE id_img = ' .$data['id']);
        $count_com = $bdd->query('SELECT * FROM comment WHERE id_img = ' .$data['id']);
    ?>
    <div id="pic<?php echo $data['id']; ?>">
        <hr>
        <table>
            <td><img src="private/<?php echo $data['id']; ?>.png"></td>
            <td>
                <p>Like: <?php echo $count_like->rowCount(); ?><br/>
                    Commentaires: <?php echo $count_com->rowCount(); ?></p>
                <input type="submit" id='<? echo $data['id']; ?>' value="Supprimer">
            </td>
        </table>
    </div>
    <script>document.getElementById("<?php echo $data['id']; ?>").addEventListener("click", () => { delete_img("<?php echo $data['id']; ?>")});</script>
    <?php
    }
    ?>

</div>

<?php
}
?>