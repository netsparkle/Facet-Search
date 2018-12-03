<?php

include_once 'conn.php';
$colors = $_GET['colors'];

$moreColors = $conn->query("SELECT `id`,`name` FROM `colors` ORDER BY `name` LIMIT 5 OFFSET ".$colors);

$result = '';
if($moreColors->num_rows > 0){
    while($color = $moreColors->fetch_assoc()){
        $result .= '<li><input class="color" name="'.$color['name'].'" type="checkbox" value="'.$color['id'].'"><label for="'.$color['name'].'">&nbsp;&nbsp;'.$color['name'].'</label><span>&nbsp;('.$conn->query("SELECT * FROM `products` WHERE `color_id` = '".$color['id']."'")->num_rows.')</span></li>';
    }
}

echo $result;