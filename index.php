<?php
$pageName = "home";
include "00header.php";
?>
<section class="section1">
    <div class="container">
        <div class="section1_top_area">
            <div class="section1_top_heading">
                <div class="row">
                    <div class="col-6 left">
                        <h2>Prominent City</h2>
                    </div>
                    <div class="col-6 right">
                        <p class="all_city">View All Cities</p>
                    </div>
                </div>
            </div>
            <div class="section1_top_boxes1">
                <div class="row">
                <?php
                $all_city = get_city();


                foreach ($all_city as $one_city_key => $one_city)
                {
                    if ($one_city_key < 6) 
                    {   
                        ?>
                        <div class="col-lg-2 col-sm-4 col-6 city_item_class" id="city_id-<?php echo $one_city["id"]; ?>">
                            <div class="section1_top_box1 city_box1">
                                <img src="uploads/city/<?php echo $one_city["image_name"]; ?>" alt="" />
                                <p><?php echo $one_city["main_title"]; ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                </div>
            </div>

            <div class="section1_top_boxes2">
                <div class="row">
                
                <?php
                foreach ($all_city as $one_city_key => $one_city) 
                {
                    if ($one_city_key >= 6) {
                        ?>
                        <div class="col-lg-2 col-sm-4 col-6 city_box7 city_item_class" id="city_id-<?php echo $one_city["id"]; ?>">
                            <div class="section1_top_box1">
                                <img src="uploads/city/<?php echo $one_city["image_name"]; ?>" alt="" />
                                <p><?php echo $one_city["main_title"]; ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }

                ?>
                
                </div>
            </div>
        </div>
        
        <div class="section1_bottom_area buy_section">
            <div id="owl-one" class="owl-carousel owl-theme">
                <?php
                $sql_list_ap_type = "SELECT * FROM " . DB_AP_TYPE . "  WHERE status!='D' ORDER BY main_title ASC";
                $qry_list_ap_type = mysqli_query($link, $sql_list_ap_type);
                $num_list_ap_type = mysqli_num_rows($qry_list_ap_type);
                if ($num_list_ap_type > 0) {
                    $list_ap_type = mysqli_fetch_all($qry_list_ap_type, MYSQLI_ASSOC);
                    foreach ($list_ap_type as $ap_type_itm) {
                ?>
                        <div class="item app_type_item_class" id="app_type_id-<?php echo $ap_type_itm["id"]; ?>">
                            <div class="section1_bottom_box1 residential_tab">
                                <div class="section1_bottom_box1_img_area">
                                    <img src="uploads/ap_type/<?php echo $ap_type_itm["image_name"]; ?>" />
                                    <h2><?php echo ucfirst($ap_type_itm["main_title"]); ?></h2>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
</section>

<section class="section2 residential_boxes">
    <div class="container">
        <div class="main_heading">
            <h2 id="apartment_list_head">Kolkata Residential</h2>
        </div>

        <div class="boxes">
            <div class="row" id="apartment_list">
                <!-- <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img1.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Saltlake</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img2.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Dharmatala</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img3.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata South City</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img1.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Saltlake</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img2.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Dharmatala</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img3.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata South City</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</section>
<!-- 
<section class="section2 commercial_boxes">
    <div class="container">
        <div class="main_heading">
            <h2>Kolkata Commercial</h2>
        </div>

        <div class="boxes">
            <div class="row">

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img3.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata South City</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img1.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Saltlake</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img2.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Dharmatala</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img3.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata South City</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="section2 institutional_boxes">
    <div class="container">
        <div class="main_heading">
            <h2>Kolkata Institutional</h2>
        </div>

        <div class="boxes">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img2.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata Dharmatala</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="box1">
                        <div class="img_area">
                            <img src="images/bulding_img3.jpg" alt="" />
                            <span class="tag">eXCLUSIVE</span>
                        </div>

                        <div class="text_area">
                            <a href="#" class="book_now_but">book now</a>
                            <div class="bulding_box_heading">
                                <h2>Kolkata South City</h2>
                            </div>
                            <div class="bulding_box_mid_area">
                                <div class="row align-items-center">
                                    <div class="col-6 area">
                                        <p>Cyber Binge</p>
                                        <p>Noida, Uttar Pradesh</p>
                                    </div>

                                    <div class="col-6 price">
                                        <h3>24.5L</h3>
                                        <p>Onwards</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bulding_buttom_area">
                                <ul>
                                    <li>Exclusive space for a selection of fine dining restaurants</li>
                                    <li>Located in the heart of Noida's IT corridor</li>
                                    <li>Well designed with ample parking and open terraces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section> -->

<section class="feature_section">
    <div class="container">
        <div class="feature_top_text_area">
            <?php echo getRecordFlied(DB_COMMON_CONTENT,"main_title='featured_projects'","descript");?> 
        </div>
        <div class="feature_slider_area">
            <div id="owl-three" class="owl-carousel owl-theme">
                <?php
                $featured_itms=get_all_featured_apartments();
                if ($featured_itms["status"] == "success") {
                    foreach ($featured_itms["data"] as $featured_itm) {
                        ?>
                        <div class="item">
                            <div class="feature_box1">
                                <div class="feature_box1_img_area">
                                    <img src="uploads/appartment/<?php echo json_decode($featured_itm["ap_images"],true)[0]; ?>" alt="" />
                                </div>

                                <div class="feature_box1_text_area">
                                    <h3><?php echo ucfirst($featured_itm["city"]) . ", " . ucfirst($featured_itm["country"]); ?></h3>
                                    <h2><?php echo ucfirst($featured_itm["ap_name"]); ?></h2>
                                    
                                    <div class="bulding_buttom_area p-0 m-0 px-3">
                                        <ul>
                                        <?php 
                                        $b_points=json_decode($featured_itm["ap_bullet_points"],true);
                                        for($i=0; $i<sizeof($b_points); $i++){
                                            echo '<li>'.$b_points[$i].'</li>';
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                   
                                    <h4><strong><?php echo convertCurrency($featured_itm["ap_price"]); ?></strong><br />Onwards</h4>
                                    <a href="<?php echo BASE_URL."booking/".$featured_itm["slug"]; ?>" class="know_but">BOOK NOW</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="testimonial_section">
    <div class="container">
        <div class="testimonial_section_text_area">
        <?php echo getRecordFlied(DB_COMMON_CONTENT,"main_title='customer_review'","descript");?> 
        </div>

        <div class="testimonial_slider_area">
            <div id="owl-two" class="owl-carousel owl-theme">
                <?php
                $sql_list_review = "SELECT * FROM " . DB_C_REVIEW . "  WHERE 1 AND status!='D' ORDER BY id DESC";
                $qry_list_review = mysqli_query($link, $sql_list_review);
                $num_list_review = mysqli_num_rows($qry_list_review);
                if ($num_list_review > 0) {
                    $list_reviews = mysqli_fetch_all($qry_list_review, MYSQLI_ASSOC);
                    foreach ($list_reviews as $review) {
                ?>
                        <div class="item">
                            <div href="#" class="testimonial_box1">
                                <p><?php echo ucfirst($review["review"]); ?></p>
                                <h2><?php echo ucfirst($review["name"]); ?><span>(<?php echo ucfirst($review["reviewer_type"]); ?>)</span></h2>
                                <p>
                                    <?php
                                    for ($i = 1; $i <= $review["rating"]; $i++) {
                                        echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                        if ($i >= 5) {
                                            break;
                                        }
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
include "01footer.php";
?>

<script>
    $(document).ready(function(){
        console.log("readyyyyy.....");
        var cityId=null; var appTypeId=null;
        $(document).on("click", ".city_item_class", function() {
            cityId=($(this).attr("id")).split("-")[1];
            $(".city_item_class").css({"font-weight":""});
            $(this).css({"font-weight":"bold"});
            appTypeId=null;
            $("#apartment_list_head").html("");
            $("#apartment_list").html("");
        });
        $(document).on("click", ".app_type_item_class", function() {
            appTypeId=($(this).attr("id")).split("-")[1];
            $(".app_type_item_class").find("h2").css({"color":""});
            $(this).find("h2").css({"color":"#ffff4e"});
            var txt_app_type=$(this).find("h2").html();
            var txt_app_city=$(`#city_id-${cityId}`).find("p").html();
            $("#apartment_list_head").html(`${txt_app_city}, ${txt_app_type}`);
            if(cityId!=null && appTypeId!=null){
                console.log("Get appartments.......");
                var string_for_slug = $("#main_title").val();
                var slug_tbl = "<?php echo DB_APPARTMENT; ?>";
                $.ajax({
                    url: `<?php echo BASE_URL; ?>ajax_get_apartments.php?city_id=${cityId}&ap_type=${appTypeId}`,
                    success: function(result) {
                        //console.log(JSON.parse(result));
                        append_apartment_list(JSON.parse(result))
                    }
                });
            }
        });

        function append_apartment_list(data){
            $("#apartment_list").html("Data Not Found.");
            if(data.length>0){
                $("#apartment_list").html("");
                for (const x in data) {
                    //console.log("x",data[x]);
                    var apartment=data[x];
                    var ap_images=JSON.parse(apartment["ap_images"]);
                    var bulletPoints=JSON.parse(apartment["ap_bullet_points"]);
                    var html_bulletPoints="";
                    for (const y in bulletPoints){
                        if(y<3){
                            html_bulletPoints=html_bulletPoints+`<li>${bulletPoints[y]}</li>`;
                        }
                    }
                    var box=`
                    <div class="col-lg-4 col-sm-6">
                        <div class="box1">
                            <div class="img_area">
                                <img src="uploads/appartment/${ap_images[0]}" alt="" />
                                <span class="tag">eXCLUSIVE</span>
                            </div>
                            <div class="text_area">
                                <a href="<?php BASE_URL ?>booking/${apartment["slug"]}" class="book_now_but">book now</a>
                                <div class="bulding_box_heading">
                                    <h2>${apartment["ap_name"]}</h2>
                                </div>
                                <div class="bulding_box_mid_area">
                                    <div class="row align-items-center">
                                        <div class="col-6 area">
                                            <p>${apartment["ap_name"]}</p>
                                            <p>${apartment["city"]}, ${apartment["country"]}</p>
                                        </div>
                                        <div class="col-6 price">
                                            <h3>${apartment["ap_price"]}</h3>
                                            <p>Onwards</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bulding_buttom_area">
                                    <ul>
                                        ${html_bulletPoints}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    $("#apartment_list").append(box);
                }
            }
        }
    });
</script>