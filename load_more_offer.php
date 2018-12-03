<?php

include_once 'conn.php';
$offers = $_GET['offers'];

$moreOffers = $conn->query("SELECT `id`,`name` FROM `offers` ORDER BY `name` LIMIT 5 OFFSET ".$offers);

$result = '';
if($moreOffers->num_rows > 0){
    while($offer = $moreOffers->fetch_assoc()){
        $result .= '<li><input class="offer" name="'.$offer['name'].'" type="checkbox" value="'.$offer['id'].'"><label for="'.$offer['name'].'">&nbsp;&nbsp;'.$offer['name'].'</label></li>';
    }
}

echo $result;