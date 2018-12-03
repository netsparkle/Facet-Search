<?php

include_once 'conn.php';
$categories = $_GET['categories'];

$moreCats = $conn->query("SELECT `id`,`name` FROM `categories` ORDER BY `name` LIMIT 5 OFFSET ".$categories);

$result = '';
if($moreCats->num_rows > 0){
    while($cat = $moreCats->fetch_assoc() ){
        $result .= '<li><input class="category" name="'.$cat['name'].'" type="checkbox" value="'.$cat['id'].'"><label for="'.$cat['name'].'">&nbsp;'.$cat['name'].'</label><span>&nbsp;('.$conn->query("SELECT * FROM `products` WHERE `category_id` = '".$cat['id']."'")->num_rows.')</span></li>';
    }
}

echo $result;