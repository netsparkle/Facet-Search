<?php

include_once 'conn.php';

?>

<!doctype html>
<html lang="en">
<head>
    <?php include_once 'head.html' ?>
</head>
<body>
<div class="container main">
    <?php include_once 'header.html' ?>
    <div class="col">
        <div class="row">
            <div class="section">
                <div class="row">

                    <?php include_once 'aside.php' ?>

                    <!-- Search Result -->
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3>Result</h3>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="form-group row">
                                        <label for="sorting" class="col-form-label col-sm-2 text-right">Sort By:</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="sorting" name="sorting">
                                                <option selected="selected" disabled="disabled" hidden="hidden" value="">Select for sorting</option>
                                                <option value="brand_id">Brand</option>
                                                <option value="category_id">Category</option>
                                                <option value="type_id">Type</option>
                                                <option value="color_id">Color</option>
                                                <option value="price">Price</option></select>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="direction" name="direction">
                                                <option value="asc">Ascending</option>
                                                <option value="desc">Descending</option>
                                            </select>
                                        </div>
                                        <label for="qty" class="col-form-label col-sm-2 text-right">Display:</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="qty" name="qty">
                                                <option value="3">3</option>
                                                <option value="6" selected="selected">6</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" id="result">
                                <!-- Search result will appeared here -->
                            </div>
                            <!-- Pagination -->
                            <div class="text-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center" id="pagination">
                                        <!-- Pagination will appeared here -->
                                    </ul>
                                </nav>
                            </div>
                            <!-- /Pagination -->
                        </div>
                    </div>
                    <!-- /Search Result -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="assets/vendor/jquery-3.2.1/jquery-3.2.1.min.js"></script>
<!-- Bootstrap -->
<script src="assets/vendor/bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
<!-- jQuery UI -->
<script src="assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script>
    var xhr = new XMLHttpRequest(); //create a new instance of ajax request

    function faceted(page){

        if(xhr !== 'undefined'){
            xhr.abort(); //abort the previous ajax request if new request sent to server;
        }

        var search = $("#search").val();
        var categories = [];
        var types = [];
        var brands = [];
        var colors = [];
        var offers = [];
        var price = $("#amount").val();
        var sorting = $("#sorting").val();
        var direction = $("#direction").val();
        var qty = $("#qty").val();
        var categoryName = [];
        var typeName = [];
        var brandName = [];
        var colorName = [];
        var offerName = [];

        $(".category:checked").each(function(){
            categories.push($(this).val());
            categoryName.push(this.name);
            $("#filter-item-category").html('<b>Category: </b>'+categoryName);
        });
        $(".brand:checked").each(function(){
            brands.push($(this).val());
            brandName.push(this.name);
            $("#filter-item-brand").html('<b>Brand: </b>'+brandName);
        });
        $(".color:checked").each(function(){
            colors.push($(this).val());
            colorName.push(this.name);
            $("#filter-item-color").html('<b>Color: </b>'+colorName);
        });
        $(".type:checked").each(function(){
            types.push($(this).val());
            typeName.push(this.name);
            $("#filter-item-type").html('<b>Type: </b>'+typeName);
        });
        $(".offer:checked").each(function(){
            offers.push($(this).val());
            offerName.push(this.name);
            $("#filter-item-offer").html('<b>Offer: </b>'+offerName);
        });

        if(categories.length == 0){
            $("#filter-item-category").html('')
        }
        if(brands.length == 0){
            $("#filter-item-brand").html('')
        }
        if(colors.length == 0){
            $("#filter-item-color").html('')
        }
        if(types.length == 0){
            $("#filter-item-type").html('')
        }
        if(offers.length == 0){
            $("#filter-item-offer").html('')
        }

        xhr = $.ajax({
            //url: 'filter',
            url: 'faceted.php',
            data: {search:search,categories:categories,brands:brands,colors:colors,types:types,offers:offers,price:price,sorting:sorting,direction:direction,page:page,qty:qty},
            type: 'get',
            dataType: 'json',
            beforeSend:function(){
                $("#result").html('<img src="assets/images/spinner.gif" alt=""/>')
            }
        }).done(function(e){
            $("#result").html(e['result']);
            pagination(e['rows'],e['qty'],e['active']);
        });
    }
</script>
<script>
    $(window).on("load",function(){
        faceted();
    })
</script>
<script>
    $("#search").keyup(function(){
        faceted();
    })
</script>
<script>
    $(".category,.type,.brand,.color,.offer").on("click",function(){
        faceted();
        //showHint('str');
        //test();
    });
</script>
<script>
    $("#sorting,#direction,#qty").on('change',function(){
        faceted();
    });
</script>
<script>
    $( function() {
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 0, 500 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                faceted();
            }
        });
        $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    } );
</script>
<script>
    /* ajax pagination */
    function pagination(rows,qty,active){
        var q = parseInt(qty);
        if(active == 1){
            var nav = '<li class="page-item"><a aria-label="Previous" class="page-link" style="cursor:not-allowed"><span aria-hidden="true">&laquo;</span></a></li>';
        }else{
            nav = '<li class="page-item"><a class="page-link" onclick="faceted('+(parseInt(active)-1)+')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        for(var i=0,j=1;i<rows;i+=q,j++){
            if((j >= parseInt(active)-6) && (j <= parseInt(active)+8)){
                nav += '<li class="page-item" id="a'+j+'"><a class="page-link" onclick="faceted('+(j)+')">'+j+'</a>';
            }
        }
        if(active == Math.ceil(rows/qty)){
            nav += '<li class="page-item"><a class="page-link" aria-label="Next" style="cursor:not-allowed"><span aria-hidden="true">&raquo;</span></a></li>';
        }else{
            nav += '<li class="page-item"><a class="page-link" onclick="faceted('+(parseInt(active)+1)+')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }

        $("#pagination").html(nav);

        $("#a"+(parseInt(active))).addClass('active');
    }
</script>

<script>
    /** load more categories */
    $("#loadCat").click(function(){
        var categories = $(".category").length;
       
        $.ajax({
            url: 'load_more_category.php',
            data: {categories:categories},
            //type: 'post',
            beforeSend: function(){
                $("#collapseBrand").addClass('loading');
            }
        }).done(function(e){
            //$("#collapseCat #loadCat").before(e);
            $("#collapseCat li").last().before(e);
            $("#collapseCat").removeClass('loading');
            $(".category").click(function(){
                faceted();
            });
        })
    });
    /** load more brands */
    $("#loadBrand").click(function(){
        var brands = $(".brand").length;
        $.ajax({
            url: 'load_more_brand.php',
            data: {brands:brands},
            //type: 'post',
            beforeSend: function(){
                $("#collapseBrand").addClass('loading');
            }
        }).done(function(e){
            $("#collapseBrand #loadBrand").before(e);
            $("#collapseBrand").removeClass('loading');
            $(".brand").click(function(){
                faceted();
            });
        })
    });
    /** load more types */
    $("#loadType").click(function(){
        var types = $(".type").length;
        $.ajax({
            url: 'load_more_type.php',
            data: {types:types},
            //type: 'post',
            beforeSend: function(){
                $("#collapseType").addClass('loading');
            }
        }).done(function(e){
            $("#collapseType #loadType").before(e);
            $("#collapseType").removeClass('loading');
            $(".type").click(function(){
                faceted();
            });
        })
    });
    /** load more colors */
    $("#loadColor").click(function(){
        var colors = $(".color").length;
        $.ajax({
            url: 'load_more_color.php',
            data: {colors:colors},
            //type: 'post',
            beforeSend: function(){
                $("#collapseColor").addClass('loading');
            }
        }).done(function(e){
            $("#collapseColor #loadColor").before(e);
            $("#collapseColor").removeClass('loading');
            $(".color").click(function(){
                faceted();
            });
        })
    });
    /** load more offers */
    $("#loadOffer").click(function(){
        var offers = $(".offer").length;
        $.ajax({
            url: 'load_more_offer.php',
            data: {offers:offers},
            //type: 'post',
            beforeSend: function(){
                $("#collapseOffer").addClass('loading');
            }
        }).done(function(e){
            $("#collapseOffer #loadOffer").before(e);
            $("#collapseOffer").removeClass('loading');
            $(".offer").click(function(){
                faceted();
            });
        })
    });
</script>

</body>
</html>

<?php
$conn->close() // close database connection
?>