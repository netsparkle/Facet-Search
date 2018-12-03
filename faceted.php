<?php

include_once 'conn.php';

$sql = "SELECT * FROM `products`";

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql .= " WHERE `name` LIKE '%".$search."%'";
}

if(isset($_GET['categories'])){
    $categories = $_GET['categories'];
    $category = implode(',',$categories);
    $sql .= " AND `category_id` IN (".$category.")";
}

if(isset($_GET['brands'])){
    $brands = $_GET['brands'];
    $brand = implode(',',$brands);
    $sql .=" AND `brand_id` IN (".$brand.")";
}

if(isset($_GET['types'])){
    $types = $_GET['types'];
    $type = implode(',',$types);
    $sql .=" AND `type_id` IN (".$type.")";
}

if(isset($_GET['colors'])){
    $colors = $_GET['colors'];
    $color = implode(',',$colors);
    $sql .=" AND `color_id` IN (".$color.")";
}

if(isset($_GET['offers'])){
    $offers = $_GET['offers'];
    $offer = implode(',',$offers);
    $sql .=" AND `offer_id` IN (".$offer.")";
}

if(isset($_GET['price']) && $_GET['price'] != null){
    $range = str_replace('$','',$_GET['price']);
    $range = explode(' - ',$range);
    $sql .= " AND `price` BETWEEN ".$range[0]." AND ".$range[1];
}

$rows = $conn->query($sql)->num_rows;

if(isset($_GET['sorting']) && $_GET['sorting'] != ''){
    $sorting = $_GET['sorting'];
    $direction = $_GET['direction'];
    $sql .= " ORDER BY `".$sorting."` ".$direction;
}

if(isset($_GET['qty'])){
    $qty = $_GET['qty'];
    $sql .= " LIMIT ".$qty;
}

if(isset($_GET['page'])){
    $page = $_GET['page'];
    $qty = $_GET['qty'];
    $sql .= " OFFSET ".($page-1)*$qty;
    $active = $page;
}else{
    $qty = $_GET['qty'];
    $active = 1;
}

$products = $conn->query($sql);
//$rows = $products->num_rows;

$result = '<div class="card-deck">';

if($rows > 0){
    while($list = $products->fetch_assoc()){
        $result .= '<div class="col-4" style="margin-bottom:25px">
                                <div class="card">
                                    <div class="row">
                                        <div class="card-body">
                                            <h3 class="card-title">'.$list['name'].'</h3>
                                            <p class="card-text">'.$list['description'].'</p>
                                            <p class="price">Price: $'.$list['price'].'</p>
                                        </div>
                                    </div>
                                </div>
                    </div>';
    }
}

$result .= '</div>';

echo json_encode(['result'=>$result,'rows'=>$rows,'qty'=>$qty,'active'=>$active]);