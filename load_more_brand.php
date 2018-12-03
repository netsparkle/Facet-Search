<?php

include_once 'conn.php';
$brands = $_GET['brands'];

$moreBrands = $conn->query("SELECT `id`,`name` FROM `brands` ORDER BY `name` LIMIT 5 OFFSET ".$brands);

$result = '';
if($moreBrands->num_rows > 0){
    while($brand = $moreBrands->fetch_assoc()){
        $result .= '<li><input class="brand" name="'.$brand['name'].'" type="checkbox" value="'.$brand['id'].'"><label for="'.$brand['name'].'">&nbsp;&nbsp;'.$brand['name'].'</label><span>&nbsp;('.$conn->query("SELECT * FROM `products` WHERE `brand_id` = '".$brand['id']."'")->num_rows.')</span></li>';
    }
}

echo $result;