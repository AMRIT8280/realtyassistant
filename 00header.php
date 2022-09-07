<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <title><?php echo get_siteconfig('website_name')." - ".$pageName;?></title>
  <link type="image/ico" rel="icon" href="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('favicon'); ?>">

  <!-- Bootstrap CSS -->
  <link href="<?php echo BASE_URL;?>lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="<?php echo BASE_URL; ?>lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>lib/animate/animate.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.theme.default.min.css">
  <!-- Main Stylesheet File -->
  <link href="<?php echo BASE_URL; ?>css/style.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>css/media_screen.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>css/page_loader.css" rel="stylesheet">
  
  <script src="<?php echo BASE_URL; ?>js/sweetalert.min.js"></script>
  
</head>

<body>
<div class="page-loader" style="display: block;">
     <div class="loader"></div>
</div>
<div class="group_box">
    <div class="cross"><img src="<?php echo BASE_URL; ?>images/cross.png" alt="" /></div>   
    <h2>+91 123 456 7890</h2>
    <p>Know More Call for Appointment</p> 
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Your Name" class="input_style1" />
        <input type="text" name="email" placeholder="E Mail" class="input_style1" />
        <input type="text" name="phone" placeholder="Mobile " class="input_style1" />
        <textarea  name="remarks" class="textarea_style1" placeholder="Remarks"></textarea>
        <input type="submit" name="sumitUserQuery" value="Submit" class="submit_style1" />
    </form>
    <?php
        if(isset($_POST["sumitUserQuery"])){
            $resultSendQuery=sendUserQuery($_POST);
            print_r($resultSendQuery);
        }
    ?>
</div>
<div class="group">
    <img src="images/header_contact.jpg" alt="" class="group_but" />
</div>

<section class="header_section">
    <div class="logo_and_menu_section">
        <div class="container">
        <div class="logo_area">
            <a href="<?php echo BASE_URL; ?>home"><img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" alt="" /></a>
        </div>

        <div class="logo_right_area">
        <?php if(!empty($_SESSION['user_name_id'])){ ?>
            <a href="<?php echo BASE_URL; ?>profile"><i class="fa fa-user" aria-hidden="true"></i> Profile</a> 
            <a onclick="return confirm('Are you sure to Logout?');" href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            <?php }else{?>   
            <a href="<?php echo BASE_URL; ?>signin"><i class="fa fa-user" aria-hidden="true"></i> Login</a> 
            <a href="<?php echo BASE_URL; ?>signup"><i class="fa fa-lock" aria-hidden="true"></i> Sign Up</a>

            <?php }?>
        </div>
    </div>
    </div>

    <?php
        $banner_ID="id=2";
        if($pageName=="home"){
            $banner_ID="id=1";
        }else if($pageName=="booking"){
            $banner_ID="id=2";
        }else if($pageName=="buy"){
            $banner_ID="id=3";
        }else if($pageName=="Terms-and-Conditions"){
            $banner_ID="id=4";
        }
        
        $filename=stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"image_name")));
        if(pathinfo($filename, PATHINFO_EXTENSION)=="mp4"){
        ?>
        <div class="header_slider_area">
            <div class="header_slider_area_img_area">
                <video autoplay muted loop id="myVideo">
                    <source src="<?php echo BASE_URL; ?>uploads/banner/<?php echo $filename;?>" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>    
            </div>
            <div class="header_slider_area_text_area">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"main_title")));?></h2>
                        <h3><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"sub_title")));?></h3>
                        <p><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"description")));?></p>
                        <!-- <a href="#" class="header_but">Read More</a> -->
                    </div>
                </div>    
                </div>
            </div>
        </div>
        <?php
        }else{
        ?>
        <div class="booking_header">
            <div class="booking_header_img_area">
                <img src="<?php echo BASE_URL; ?>uploads/banner/<?php echo $filename;?>" alt="" />
            </div>
            <div class="header_slider_area_text_area">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"main_title")));?></h2>
                        <h3><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"sub_title")));?></h3>
                        <p><?php echo stripslashes(br2nl(getRecordFlied(DB_BANNER,$banner_ID,"description")));?></p>
                        <!-- <a href="#" class="header_but">Read More</a> -->
                    </div>
                </div>    
                </div>
            </div>
        </div>
        <?php
        }
    ?>
</section>