<?php
if ($_SESSION['login'])
{
?>
<script>

    function like(id){
        let xmlhttp = new XMLHttpRequest();
        let button = document.getElementById('like' + id);
        let count = document.getElementById('nb_like' + id);

        xmlhttp.onload = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                let ret = (xmlhttp.responseText);
                if (ret == 'add')
                {
                    button.style.color = 'red';
                    count.innerHTML = parseInt(count.innerHTML) + 1;
                }
                if (ret == 'remove')
                {
                    button.style.color = 'black';
                    count.innerHTML = parseInt(count.innerHTML) - 1;
                }
            }
        }
        xmlhttp.open("GET", 'include/like.php?id=' + id, true);
        xmlhttp.send();
    }

</script>

<?php

    $picture = $bdd->query("SELECT * FROM picture ORDER BY date_pub DESC LIMIT 50");

    foreach ($picture as $data)
    {
        $like = $bdd->prepare('SELECT * FROM t_like WHERE id_img = :id');
        $like->execute(array('id' => $data['id']));
        $color = 'black';
        if ($like->rowCount() != 0)
        {
            foreach ($like as $l_data)
            {
                if ($l_data['login'] == $_SESSION['login'])
                {
                    $color = 'red';
                    break;
                }
            }
        }

        echo '<div class="wall">';
        echo '<center><img src="private/' .$data['id']. '.png"></center>
        <p>Auteur: ' .$data['login']. '<br/>
        <input type="submit" id="like' .$data['id']. '" value="♥" style="color: ' .$color.'">';
        echo '<span id="nb_like' .$data['id']. '">' .$like->rowCount(). '</span>';
        echo '</div>';
        echo '<script>document.getElementById("like' .$data['id']. '").addEventListener("click", function() {like(' .$data['id']. ')});</script>';
    }

}
?>