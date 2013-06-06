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
    var_dump("You are not authorized to view this page");
    exit;
  }
 global $USER;
 $id = $_GET['id'];
	
  /*
   * Query to get employee details
   */
  $sql = "SELECT `id`, `emp_id`, `first_name`, `last_name`,
                  `address`, `username`, `email`, `mobile_number`,
                   `telephone_number`, `password`,flag
  		  FROM `employee` 
  		  WHERE id=$id";   
  //var_dump($sql);
  $result=$DB->select($sql);
  //var_dump($result);
  foreach ($result['result'] as $key){
  }
  /*
   * Get values from from
  */
  if(isset($_POST['submit'])){
  	//var_dump($_POST);
  	$empid 		= @$_POST['empid'];
  	$firstname 	= @$_POST['firstname'];
  	$lastname 	= @$_POST['lastname'];
  	$address 	= @$_POST['address'];
  	$username 	= (@$_POST['username']);
  	$email 		= @trim($_POST['email']);
  	$mobileno 	= @$_POST['mobilenumber'];
  	$telephone 	= @$_POST['telephone'];
  	if(isset($_POST['admin'])){
  		$flag = 1;
  		 
  	}else{
  		$flag = 0;
  	}
  	//query to insert
  	$sql = "UPDATE `employee` 
  			SET `emp_id`    =$empid,
  	            `first_name`='$firstname',
  	            `last_name` ='$lastname',
  	            `address`   ='$address',
  	            `username`  ='$username',
  	            `email`     ='$email',
  	            `mobile_number`='$mobileno',
  	            `telephone_number`='$telephone',
  	            `flag`=$flag
  	         WHERE id=$id";
  	$update=$DB->update($sql);
    if (isset($update)){
    	echo '<div align="center" class="alert alert-success">'; 
    		echo "Employee details has been updated Successfully. Page will auto redirect in few seconds.";
    	echo '</div>';
    	header('Refresh: 4; URL='.$CFG->wwwroot.'/admin/update_employee_detail.php');
    }else{
  	echo '<div class="alert alert-warning">';
   		echo "Something went wrong";
  	echo '</div>';
    }
  }
?>
<div class=row-fluid>
  <div class=span4>
    <?php require_once 'adminpanel.php'; ?>
  </div>
  <div class=span8>
  <form class="form-horizontal"  method="POST">
    <fieldset>
        <div id="legend">
          <legend class="">User Employee Details</legend>
        </div>
           <span style="color:red" class="controls">* Marked fields are compulsary.</span>
           <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="empid">Employee Id:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="empid" name="empid" value="<?php echo $key['emp_id'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="firstname">First Name:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="firstname" name="firstname" value="<?php echo $key['first_name']; ?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="lastname">Last Name:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="lastname" name="lastname" value="<?php echo $key['last_name'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="address">Address:</label>
          <div class="controls">
            <textarea id="address" name="address" class="input-xlarge"><?php echo $key['address'];?></textarea>
          </div>
        </div>
            <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="username">Username:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="username" name="username" value="<?php echo $key['username'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="email" name="email" value="<?php echo $key['email'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="mobilenumber">Mobile Number:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="mobilenumber" name="mobilenumber" value="<?php echo $key['mobile_number'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="telephone">Telephone Number:</label>
          <div class="controls">
            <input type="text" id="telephone" name="telephone" value="<?php echo $key['telephone_number'];?>" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <!-- Password -->
          <label class="control-label"  for="password_confirm">User Type:</label>
          <div class="controls">
            <input type="checkbox" name="admin" <?php
				if($key['flag']){
					echo 'checked';
				}?>> Admin User
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type="submit">Save Changes</button>
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