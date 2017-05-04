<?php

$picture = $bdd->query("SELECT * FROM picture ORDER BY date_pub DESC LIMIT 15");

foreach ($picture as $data)
{
    echo '<div class="wall">';
    echo '<img src="private/' .$data['login']. '/' .$data['id']. '.png">';
    echo '</div>';
}

?>