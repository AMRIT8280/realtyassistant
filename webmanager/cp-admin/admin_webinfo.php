<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
require_once("../authonication.php");
if(isset($_POST['mode']))
{
 if($_POST['mode']=='update') 						update();
}
else												disphtml("main();");


ob_end_flush();

function main(){?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Settings</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Website Info</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true">
              <!-- Content Alert part -->
                <?php if(isset($_SESSION['MSG_ALERT'])){?>
                <div id="hide_allert" class="alert  <?php  echo $_SESSION['DIV_CLASS']?> alert-dismissible"><strong><i class="fa <?php  echo $_SESSION['IMG_PATH']?> fa-fw"></i> Alert!</strong> &nbsp;&nbsp; 
					<?php  echo  $_SESSION['MSG_ALERT'];
						unset($_SESSION['MSG_ALERT']);
						unset($_SESSION['IMG_PATH']); 
						unset($_SESSION['DIV_CLASS']); 
					?>
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
                <?php }?>
                <!--End content Alert part -->
                <div class="panel-body" style="background: #eef9f0;border-radius: 4px;">
                <form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm"enctype="multipart/form-data">
                <table width="100%">
                    <tbody>
                      <tr>
                        <td>(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="100%"><div class="col-lg-12 form-group">
                        <label for="website_name" class="control-label">Site Name <font color="#ff0000">*</font></label>
                          <input type="text" id="website_name" class="form-control" name="website_name" placeholder="Website Name" value="<?php echo get_siteconfig('website_name'); ?>" autofocus required>				
                       </div></td>
                      </tr>
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <label for="email" class="control-label">Site Email</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                          <input type="email" id="email" class="form-control" name="email" placeholder="Website Email-Id" value="<?php echo get_siteconfig('email'); ?>">
                          </div>
                          </div>
                        <div class="col-lg-6 form-group">
                        <label for="phone" class="control-label">Site Contact No</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                          <input type="text" id="phone" class="form-control" name="phone" placeholder="Website Contact No." value="<?php echo get_siteconfig('phone'); ?>">
                          </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <label for="website_address" class="control-label">Head Office</label>
                           <textarea id="website_address" class="form-control" name="website_address" ><?php echo get_siteconfig('website_address'); ?></textarea>
                          </div>
                        <div class="col-lg-6 form-group">
                        <label for="city_address" class="control-label">City Office</label>
                            <textarea id="city_address" class="form-control" name="city_address" ><?php echo get_siteconfig('city_address'); ?></textarea>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%"><div class="col-lg-12 form-group">
                        <label for="time_zone" class="control-label">Time Zone</label>
						<?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                        <select name="time_zone" id="time_zone" class="form-control select">
                            <?php foreach ($tzlist as $tz) { ?>
                                <option value="<?php echo $tz; ?>" <?php if($tz == get_siteconfig('time_zone')){echo 'selected';} ?> ><?php echo $tz; ?></option>
                            <?php } ?>
                        </select>
                       </div></td>
                      </tr>
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <?php if(get_siteconfig('logo')){ ?>
                                <img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" alt="" width="200px;">
                        <?php } ?>
                       </div>
                       <div class="col-lg-6 form-group">
                        <?php if(get_siteconfig('favicon')){ ?>
                                <img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('favicon'); ?>" alt="" width="50px;">
                        <?php } ?>
                       </div></td>
                      </tr>
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <label for="logo" class="control-label">Upload Site Logo</label>
						<input type="file" class="form-control" id="logo" name="logo" value="" accept="image/*">
                       </div>
                       <div class="col-lg-6 form-group">
                        <label for="favicon" class="control-label">Upload Favicon</label>
						<input type="file" class="form-control" id="favicon" name="favicon" value="" accept="image/*">
                       </div></td>
                      </tr>
                      
                      <tr>
                        <td width="100%">
                        <div class="col-lg-12 form-group">
                        <hr style="border-top: 1px solid #6e5cff;" />
                        </div>
                        </td>
                     </tr>
                        
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <label for="email" class="control-label">Facebook Link</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-facebook-square fa-fw"></i></span>
                          <input type="link" id="fb" class="form-control" name="fb" placeholder="FB Link" value="<?php echo get_siteconfig('fb'); ?>">
                          </div>
                          </div>
                        <div class="col-lg-6 form-group">
                        <label for="phone" class="control-label">Twitter Link</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-twitter-square fa-fw"></i></span>
                          <input type="link" id="twitter" class="form-control" name="twitter" placeholder="Twitter Link" value="<?php echo get_siteconfig('twitter'); ?>">
                          </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%">
                        <div class="col-lg-6 form-group">
                        <label for="email" class="control-label">Instagram Link</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-instagram fa-fw"></i></span>
                          <input type="link" id="instagram" class="form-control" name="instagram" placeholder="Instagram Link" value="<?php echo get_siteconfig('instagram'); ?>">
                          </div>
                          </div>
                            <div class="col-lg-6 form-group">
                            <label for="email" class="control-label">Youtube Link</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-youtube fa-fw"></i></span>
                              <input type="link" id="youtube_link" class="form-control" name="youtube_link" placeholder="Youtube Link" value="<?php echo get_siteconfig('youtube_link'); ?>">
                              </div>
                          	</div>
                        </td>
                      </tr>
                      <?php  if($_SESSION['type_id']==1){?>
                      <tr>
                        <td colspan="3">
                            <input type="hidden" name="mode" value="update">
                            <input type="hidden" name="id" value="<?php  echo $_POST['id']?>">
                            <input type="submit" value="Submit" class="btn btn-success ">
                            <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
  	</div>
  </div>
</div>

<?php  }

function update()
{

	global $link;
	 
	 foreach($_POST as $k => $v){
		$sql_select= "SELECT * FROM ".CONFIG." WHERE _key ='".$k."'";
		$sql_query= mysqli_query($link,$sql_select);
		$sql_num= mysqli_num_rows($sql_query);
			
			if($sql_num > 0){
				$sql = "UPDATE ".CONFIG."
				SET
				
				value = '".$v."'
				WHERE
				_key = '".$k."'";
				$qry_update = mysqli_query($link,$sql) or die(mysqli_error($link));
			} else {
				$sql_inset_post = "INSERT INTO ".CONFIG." 
				SET 
				
				_key = '".$k."',			
				value = '".$v."'";
				$qry_inset	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));  
			}
		}
		
		
	 foreach($_FILES as $k => $v){
		 $sql_select= "SELECT * FROM ".CONFIG." WHERE _key ='".$k."'";
		 $sql_query= mysqli_query($link,$sql_select);
		 $sql_num= mysqli_num_rows($sql_query);
		 if(!empty($v['name'])){
			$upload_dir='../../uploads/admin/';
			$file_name_image='';
			$file_explode = explode(".",$v['name']);
			$file_name_image=time().rand(1111,9999)."_".str_replace(" ","_",$v['name']);
			$tmp_name=$v['tmp_name'];
			move_uploaded_file($tmp_name,$upload_dir.$file_name_image);
			
			if($sql_num > 0){
				$sql = "UPDATE ".CONFIG."
				SET
				
				value = '".$file_name_image."'
				WHERE
				_key = '".$k."'";
				$qry_update = mysqli_query($link,$sql) or die(mysqli_error($link));
			} else {
				$sql_inset_post = "INSERT INTO ".CONFIG." 
				SET 
				
				_key = '".$k."',			
				value = '".$file_name_image."'";
				$qry_inset	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));  
			}
		 }
		}
	  $_SESSION['MSG_ALERT'] = 'Your Web site information is successfully updated';
	  $_SESSION['IMG_PATH'] ="fa-check"; 
	  $_SESSION['DIV_CLASS'] ="alert-success"; 
	  redirect_cp('admin_webinfo');
	  exit();
	
  disphtml("main();");
}
?>

<script type="text/javascript">
	
	
	$(document).ready(function () {	
		$(':input').change(function() {
			$(this).val($(this).val().trim());
		});
//---------------------------------Edit validation   ----------------------------
	
		$('#edit_frm').validate({
		rules: {
		  email: 'required email',
		  facebook_link: 'required url',
		  twitter_link: 'required url',
		  google_link: 'required url',		  
		  contact: 'required',
		  address: 'required'
		  
		},
		messages: {
		email: {
            required: "Please provide a email",
            email: "Please enter a vaild email address"
        },
		facebook_link: {
            required: "Please provide a facebook url"
        },
		twitter_link: {
            required: "Please provide a twitter url"
        },
		google_link: {
		  required: "Please provide a linkdin url"
		},
		contact: {
            required: "Please provide a contact number"
        },
		address: {
            required: "Please provide a address"
        }
		},
		errorElement: 'label',
		errorPlacement: function (error, element) {
		  error.addClass('has-warning');
		  element.closest('.form-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('has-warning');
		  $(element).removeClass('has-success');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('has-warning');
		  $(element).addClass('has-success');
		},
         submitHandler: function(form) {
            form.submit();
        }
	  });
	  
	});
</script>