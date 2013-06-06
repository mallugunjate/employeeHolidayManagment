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
  $rs = isadmin();
  if(!$rs){
    var_dump("You are not authorized to view this page");
    exit;
  }
  /*
   * Get values from from 
   */
  if(isset($_POST['submit'])){
  	//var_dump($_POST);exit;
  $empid 		= @$_POST['empid'];
  $firstname 	= @$_POST['firstname'];
  $lastname 	= @$_POST['lastname'];
  $address 		= @$_POST['address'];
  $username 	= trim(@$_POST['username']);
  $email 		= @trim($_POST['email']);
  $mobileno 	= @$_POST['mobilenumber'];
  $telephone 	= @$_POST['telephone'];
  $password 	= @md5(trim($_POST['password']));
  if(isset($_POST['admin'])){
  		$flag = 1;
  		 
  	}else{
  		$flag = 0;
  	}
  $insert=false;
  //query to insert 
  $sql = "INSERT INTO employee(emp_id,first_name,last_name,address,username,email,mobile_number,telephone_number,password,flag)
                        VALUES('$empid', '$firstname','$lastname','$address','$username','$email','$mobileno','$telephone','$password',$flag)";
  $check = mysql_query("SELECT emp_id FROM employee WHERE  emp_id = '{$empid}'");
  
  //var_dump($check);exit;
	 if (mysql_num_rows($check) == 0) {
	 	$insert=$DB->insert($sql);
	 }
  if ($insert){
  	echo '<div align="center" class="alert alert-success">';
  	echo "Employee details has been added Successfully";
  	echo '</div>';
  }else{
	echo '<div align="center" class="alert alert-warning">';
 		echo "Employee Id $empid already exists. Please try new Id. OR Username should be unique ";
	echo '</div>';
  }
}?>
<div class=row-fluid>
  <div class=span4>
    <?php require_once 'adminpanel.php'; ?>
  </div>
  <div class=span8>
    <form class="form-horizontal"  method="POST">
      <fieldset>
        <div id="legend">
          <legend class="">Employee Details</legend>
        </div>
            <span style="color:red" class="controls">* Marked fields are compulsary.</span>
            <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="empid">Employee Id:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="empid" name="empid" placeholder="" class="input-xlarge">
            <p class="help-block">Enter employee id</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="firstname">First Name:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="firstname" name="firstname" placeholder="" class="input-xlarge">
            <p class="help-block">Enter first name</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="lastname">Last Name:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="lastname" name="lastname" placeholder="" class="input-xlarge">
            <p class="help-block">Enter last name</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="address">Address:</label>
          <div class="controls">
            <textarea id="address" name="address" class="input-xlarge"></textarea>
            <p class="help-block">Enter Address</p>
          </div>
        </div>
            <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="username">Username:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
            <p class="help-block">Please provide username</p>
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
            <p class="help-block">Please provide your E-mail</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="mobilenumber">Mobile Number:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="mobilenumber" name="mobilenumber" placeholder="" class="input-xlarge">
            <p class="help-block">Enter 10 digits phone number</p>
          </div>
        </div>

        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="telephone">Telephone Number:</label>
          <div class="controls">
            <input type="text" id="telephone" name="telephone" placeholder="" class="input-xlarge">
            <p class="help-block">Please provide telephone number with std code</p>
          </div>
        </div>

        <div class="control-group">
          <!-- Password-->
          <label class="control-label" for="password">Password:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
            <p class="help-block">Password should be at least 5 characters</p>
          </div>
        </div>

        <div class="control-group">
          <!-- Password -->
          <label class="control-label"  for="password_confirm">Password (Confirm):<span style="color:red">*</span></label>
          <div class="controls">
            <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
            <p class="help-block">Please confirm password</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Password -->
          <label class="control-label"  for="password_confirm">User Type:</label>
          <div class="controls">
            <input type="checkbox" name="admin" value="1"> Admin
            <p class="help-block">Select user type</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit">Save Details</button>
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
