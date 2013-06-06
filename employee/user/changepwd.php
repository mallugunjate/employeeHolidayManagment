<?php 
  require_once ('../config.php');
  require_once ('../dblib.php');
  require_once ('../lib.php');
  global $CFG;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isemployee();
  if(!$rs){
    var_dump("You are not authorized to view this page");
    exit;
  }
  /*
   * Get values from from 
   */
  if(isset($_POST['submit'])){
  $password 	= md5(@($_POST['password']));
  //var_dump($_POST['newpwd']);
  global $USER;
  //query to insert 
  $sql = "UPDATE `employee` SET `password`= '$password'
          WHERE id=$USER->id";
  //print_r($sql);exit;
  $update=$DB->update($sql);
  if (isset($update)){?>
  	<div align="center" class="alert alert-success"> 
  	<?php echo "Password has been changed successfully";
  	echo '</div>';
  }else{
	echo '<div class="alert alert-warning">';
 		echo "Something went wrong";
	echo '</div>';
  }
}
?>
<script type="text/javascript" src="<?php echo $CFG->wwwroot?>/assets/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo $CFG->wwwroot?>/assets/js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker();
});
</script>
<div class=row-fluid>
  <div class=span4>
    <?php require_once 'panel.php'; ?>
  </div>
  <div class=span8>
    <form class="form-horizontal" action='' method="POST">
      <fieldset>
        <legend>Change Password</legend>
        <span style="color:red" class="controls">* Marked fields are compulsary.</span>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="newpwd">New Password:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="password" id="password" name='password' placeholder="Enter new password">
            <p class="help-block"></p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="confirmpwd">Confirm Password:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="password" name='password_confirm' placeholder="Re-enter password to confirm">
            <p class="help-block"></p>
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type="submit">Submit</button>
          </div>
      </fieldset>
    </form>
    </div>
</div>
<?php
 //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "admin";
  //Apply the template
  require_once "../master.php";
?>

