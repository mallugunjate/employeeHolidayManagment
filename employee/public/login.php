<?php 
require_once '../config.php';
require_once '../user/lib.php';
require_once '../lib.php';
global $USER;
global $CFG;
@session_start();
  $flag = 0;  
  if (requiredlogin()){
    header('Location:'.$CFG->wwwroot.'/public/logout.php');  
  }
  if(isset($_REQUEST['submit'])){
    $username = trim(@$_REQUEST['username']);
    $pwd = md5(trim(@$_REQUEST['password']));
    $newuser =  new user();
    $res = $newuser->login($username,$pwd);
    if($res){
      global $USER;
      $_SESSION['USER'] = $USER;
      if($USER->flag){
        header('Location:'.$CFG->wwwroot.'/admin');
      }else{
        header('Location: '.$CFG->wwwroot.'/user');
      }
    }else{
      $flag = 1;
      
    }
  }
?>
<?php

  //Buffer larger content areas like the main page content
  ob_start();
?>
<div class="span7 offset3">
  <?php
  if($flag){
    echo '<div class="alert alert-danger">';
        echo "Invalid Username or password please try again.";
      echo '</div>';
  }
  ?>
<form class="form-horizontal well" method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Leave Management Login </legend>
    </div>
    
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username:<span style="color:red">*</span></label>
      <div class="controls">
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
      </div>
    </div>
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password:<span style="color:red">*</span></label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
      </div>
    </div>
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success" name='submit' type=submit>Login</button>
      </div>
    </div>
    <span style="color:red" class="controls">* Marked fields are compulsary.</span>
  </fieldset>
</form>
</div>
<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Login";
  //Apply the template
  require_once "../master.php";
?>
<script src="<?php echo $CFG->wwwroot?>/assets/js/validation.js"></script>