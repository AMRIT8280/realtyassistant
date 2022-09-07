
<section class="top_footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 footer_box1">
                <h2>over view</h2>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Policy of Use</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-sm-6 footer_box2">
                <h2>connect with us</h2>
                <p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo get_siteconfig('phone');?></p>
                <p><i class="fa fa-envelope" aria-hidden="true"></i><?php echo get_siteconfig('email');?></p>
            </div>

            <div class="col-lg-3 col-sm-6 footer_box3">
                <h2>follow us</h2>
               <p>
               <a href="<?php echo get_siteconfig('fb'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> 
               <a href="<?php echo get_siteconfig('twitter'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a> 
               <a href="<?php echo get_siteconfig('instagram'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a> 
               <a href="<?php echo get_siteconfig('youtube_link'); ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a>
               </p>
            </div>
            
            <div class="col-lg-3 col-sm-6 footer_box4">
                <h2>Newsletter</h2>
                <form action="" method="POST">
                    <input type="email" name="newsletter_email" placeholder="Enter email" class="input_style2" required />
                    <input type="submit" value="Submit" name="newsletter_btn" class="submit_style2" />
                </form>
             </div>
            <?php
                if(isset($_POST["newsletter_btn"]) and !empty($_POST["newsletter_email"])){
                    $sql_insert = "INSERT INTO ".DB_NEWSLETTER."(`main_title`) VALUES ('".$_POST["newsletter_email"]."')";
                    if(mysqli_query($link, $sql_insert)){
                        echo '<script> swal("Great","Thanks for your subscription.","success");</script>';
                    }else{
                        echo '<script> swal("Opps","Something went wrong.","error");</script>';
                    }
                }
            ?>
        </div>
    </div>
</section>

<section class="copy_footer">
    <div class="container">
        <p><?php echo get_siteconfig('website_name');?> © rights reserved.2021</p>
    </div>
</section>


<!-- JavaScript Libraries -->
  
<script src="<?php echo BASE_URL;?>lib/jquery/jquery.min.js"></script>
<script src="<?php echo BASE_URL;?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL;?>lib/superfish/superfish.min.js"></script>
<script src="<?php echo BASE_URL;?>lib/wow/wow.min.js"></script>

<script src="<?php echo BASE_URL;?>js/owl.carousel.js"></script>
<!-- Template Main Javascript File -->
<script src="<?php echo BASE_URL;?>js/nav_menu.js"></script>
<script>
    $(document).ready(function(e) {
    //-----------------------loader-js----------------------------------
        $(function() {
            $(".page-loader").fadeOut(3000, function() {
                $(".wrap").fadeIn(1000);        
            });
        });
    });
</script>

</body>
</html>
