<?php
include_once 'conn.php';
$category_sql = "SELECT `id`,`name` FROM `categories` ORDER BY `name` LIMIT 5";
$type_sql = "SELECT `id`,`name` FROM `types` ORDER BY `name` LIMIT 5";
$brand_sql = "SELECT `id`,`name` FROM `brands` ORDER BY `name` LIMIT 5";
$color_sql = "SELECT `id`,`name` FROM `colors` ORDER BY `name` LIMIT 5";
$offer_sql = "SELECT `id`,`name` FROM `offers` ORDER BY `name` LIMIT 5";

$categories = $conn->query($category_sql);
$types = $conn->query($type_sql);
$brands = $conn->query($brand_sql);
$colors = $conn->query($color_sql);
$offers = $conn->query($offer_sql);
?>
<!-- Filter Panel -->
<div class="col-3">
    <div class="card">
        <div class="card-header">
            <h3>Filter</h3>
        </div>

        <div class="card-body">
            <form method="GET" action="/" accept-charset="UTF-8" class="form">
                <p class="filter-title">Current Filter</p>
                
                <p id="filter-item-category"></p>
                <p id="filter-item-type"></p>
                <p id="filter-item-brand"></p>
                <p id="filter-item-color"></p>
                <p id="filter-item-offer"></p>

                <!-- Search Box-->
                <p class="filter-title">Search</p>
                <p><input id="search" placeholder="Name or Description" name="search" type="text"></p>

               <!-- Category Filter-->
                <p class="filter-title"><a data-toggle="collapse" href="#collapseCat" aria-expanded="false" aria-controls="collapseExample">Product Category</a></p>
                <ul class="filter-cat collapse" id="collapseCat">
                    <?php if($categories->num_rows > 0){ ?>
                        <?php while($cat = $categories->fetch_assoc()){ ?>
                            <li>
                                <input class="category" name="<?= $cat['name'] ?>" type="checkbox" value="<?= $cat['id'] ?>">
                                <label for="<?= $cat['name'] ?>"><?= $cat['name'] ?></label>
                                <span>(<?= $conn->query("SELECT * FROM `products` WHERE `category_id` = '".$cat['id']."'")->num_rows ?>)</span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li><a id="loadCat" style="color:blue;text-decoration: underline;cursor: pointer;">Load More >>></a></li>
                </ul>

                <!-- Brand Filter-->
                <p class="filter-title"><a data-toggle="collapse" href="#collapseBrand" aria-expanded="false" aria-controls="collapseExample">Brand</a></p>
                <ul class="filter-cat collapse" id="collapseBrand">
                    <?php if($brands->num_rows > 0){ ?>
                        <?php while($brand = $brands->fetch_assoc()){ ?>
                            <li>
                                <input class="brand" name="<?= $brand['name'] ?>" type="checkbox" value="<?= $brand['id'] ?>">
                                <label for="<?= $brand['name'] ?>"><?= $brand['name'] ?></label>
                                <span>(<?= $conn->query("SELECT * FROM `products` WHERE `brand_id` = '".$brand['id']." AND '")->num_rows ?>)</span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li><a id="loadBrand" style="color:blue;text-decoration: underline;cursor: pointer;">Load More >>></a></li>
                </ul>

               <!-- Product Filter-->
                <p class="filter-title"><a data-toggle="collapse" href="#collapseType" aria-expanded="false" aria-controls="collapseExample">Product Type</a></p>
                <ul class="filter-cat collapse" id="collapseType">
                    <?php if($types->num_rows > 0){ ?>
                        <?php while($type = $types->fetch_assoc()){ ?>
                            <li>
                                <input class="type" name="<?= $type['name'] ?>" type="checkbox" value="<?= $type['id'] ?>">
                                <label for="<?= $type['name'] ?>"><?= $type['name'] ?></label>
                                <span>(<?= $conn->query("SELECT * FROM `products` WHERE `type_id` = '".$type['id']."'")->num_rows ?>)</span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li><a id="loadType" style="color:blue;text-decoration: underline;cursor: pointer;">Load More >>></a></li>
                </ul>

                <!-- Product Colour Filter-->
                <p class="filter-title"><a data-toggle="collapse" href="#collapseColor" aria-expanded="false" aria-controls="collapseExample">Product Colour</a></p>
                <ul class="filter-cat collapse" id="collapseColor">
                    <?php if($colors->num_rows > 0){ ?>
                        <?php while($color = $colors->fetch_assoc()){ ?>
                            <li>
                                <input class="color" name="<?= $color['name'] ?>" type="checkbox" value="<?= $color['id'] ?>">
                                <label for="<?= $color['name'] ?>"><?= $color['name'] ?></label>
                                <span>(<?= $conn->query("SELECT * FROM `products` WHERE `color_id` = '".$color['id']."'")->num_rows ?>)</span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li><a id="loadColor" style="color:blue;text-decoration: underline;cursor: pointer;">Load More >>></a></li>
                </ul>

                <!-- Active Offer Filter-->
                <p class="filter-title"><a data-toggle="collapse" href="#collapseOffer" aria-expanded="false" aria-controls="collapseExample">Active Offers</a></p>
                <ul class="filter-cat collapse" id="collapseOffer">
                    <?php if($offers->num_rows > 0){ ?>
                        <?php while($offer = $offers->fetch_assoc()){ ?>
                            <li>
                                <input class="offer" name="<?= $offer['name'] ?>" type="checkbox" value="<?= $offer['id'] ?>">
                                <label for="<?= $offer['name'] ?>"><?= $offer['name'] ?></label>
                                <span>(<?= $conn->query("SELECT * FROM `offer_product` WHERE `offer_id` = '".$offer['id']."'")->num_rows ?>)</span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li><a id="loadOffer" style="color:blue;text-decoration: underline;cursor: pointer;">Load More >>></a></li>
                </ul>

                <p class="filter-title">
                    <label for="amount">Price range:</label>
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                </p>

                <div id="slider-range"></div>
            </form>
        </div>
    </div>
</div>

