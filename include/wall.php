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
                    let val = button.getAttribute('value').replace('♥ ', '');
                    button.setAttribute('value', '♥ ' + (parseInt(val) + 1));
                }
                if (ret == 'remove')
                {
                    button.style.color = 'black';
                    let val = button.getAttribute('value').replace('♥ ', '');
                    button.setAttribute('value', '♥ ' + (parseInt(val) - 1));
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
?>
<div class="wall">
    <center><img src="private/<?php echo $data['id']; ?>.png"></center>
    <p>Auteur: <?php echo $data['login']; ?><br/>
    <input type="submit" id="like<?php echo $data['id']; ?>" value="♥ <?php echo $like->rowCount(); ?>" style="color: <?php echo $color; ?>"></p>
    <form action="?page=comment&id=<?php echo $data['id']; ?>" method="post">
        <center><input type="submit" value="Commentaires"></center>
    </form>
</div>
<script>
    document.getElementById("like<?php echo $data['id']; ?>").addEventListener("click", function() {like(<?php echo $data['id']; ?>)});
</script>
<?php
    }

}
?>