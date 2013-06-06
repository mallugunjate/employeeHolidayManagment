<?php 
  require_once ('../config.php');
  require_once ('../dblib.php');
  require_once ('../lib.php');
  global $DB;
  global $CFG;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isemployee();
  if(!$rs){
    var_dump("You are noty authorized to view this page");
    exit;
  }
global $USER;
  /*
   * Query to get employee details
   */
  $sql = "SELECT `id`, `emp_id`, `first_name`, `last_name`, `address`, `username`, `email`, `mobile_number`, `telephone_number`, `password`
  		  FROM `employee` 
  		  WHERE id=$USER->id";
  $result=$DB->select($sql);
  foreach ($result['result'] as $key){
  }
?>
<div class=row-fluid>
  <div class=span4>
    <?php require_once 'panel.php'; ?>
  </div>
  <div class=span8>
  <form class="form-horizontal"  method="POST">
    <fieldset>
        <div id="legend">
          <legend class="">User Profile</legend>
        </div>
           <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="empid">Employee Id:</label>
          <div class="controls">
            <input type="text" id="empid" name="empid" placeholder="<?php echo $key['emp_id'];?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="firstname">First Name:</label>
          <div class="controls">
            <input type="text" id="firstname" name="firstname" placeholder="<?php echo $key['first_name']; ?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="lastname">Last Name:</label>
          <div class="controls">
            <input type="text" id="lastname" name="lastname" placeholder="<?php echo $key['last_name'];?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="address">Address:</label>
          <div class="controls">
            <textarea id="address" name="address" placeholder="<?php echo $key['address'];?>" class="input-xlarge" disabled="true"></textarea>
          </div>
        </div>
            <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="username">Username:</label>
          <div class="controls">
            <input type="text" id="username" name="username" value="<?php echo $key['username'];?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail:</label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="<?php echo $key['email'];?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="mobilenumber">Mobile Number:</label>
          <div class="controls">
            <input type="text" id="mobilenumber" name="mobilenumber" placeholder="<?php echo $key['mobile_number'];?>" class="input-xlarge" disabled="true">
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="telephone">Telephone Number:</label>
          <div class="controls">
            <input type="text" id="telephone" name="telephone" placeholder="<?php echo $key['telephone_number'];?>" class="input-xlarge" disabled="true">
          </div>
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
<script src="<?php echo $CFG->wwwroot?>/assets/js/validation.js"></script>