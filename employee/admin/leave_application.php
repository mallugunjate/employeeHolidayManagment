<?php 
  require_once ('../config.php');
  require_once ('../lib.php');
  require_once ('../dblib.php');
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
  $sql = "SELECT id,first_name,last_name FROM employee";
  $result=$DB->select($sql);
  //var_dump($result);exit;
  //var_dump($result['result']);
  if(isset($_POST['submit'])){
	$empid 			= @$_POST['employeeid'];
  	$phonenumber 	= @$_POST['phonenumber'];
  	$datefrom		= strtotime(@$_POST['datefrom']);
  	$dateto 		= strtotime(@$_POST['dateto']);
  	//query to insert
  	$sql = "INSERT INTO employee_leave(emp_id,contact_number,leave_from,leave_to)
  						  VALUES('$empid','$phonenumber','$datefrom','$dateto')";
  	//var_dump($sql);
  	$insert=$DB->insert($sql);
    if (isset($insert)){?>
    	<div align="center" class="alert alert-success"> 
    	<?php echo "Leave days added successfully";
    	echo '</div>';
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
    <form class="form-horizontal" action='' method="POST">
      <fieldset>
        <div id="legend">
          <legend class="">Fill the leave application</legend>
        </div>
        	<span style="color:red" class="controls">* Marked fields are compulsary.</span>
    	    <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="employee">Employee Name:</label>
          <div class="controls">
            <!-- <input type="text" id="employeename" name="employeename" placeholder="" class="input-xlarge"> -->
            <select class="input-xlarge" name="employeeid" >
            <?php 
				$employeeid = -9;
				if(isset($_REQUEST['employeeid'])){
					$employeeid = $_REQUEST['employeeid'];
				}
				foreach ($result['result'] as $key ) {            
					if($employeeid == $key['id']){
						echo '<option value="'.$key['id'].'" selected>'.$key['first_name'].' '.$key['last_name'].'</option>';
					}else{
						echo '<option value="'.$key['id'].'">'.$key['first_name'].' '.$key['last_name'].'</option>';
					}
           }?> 		  				
    		    </select>
            
            <p class="help-block">Select employee Name</p>
          </div>
		<div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="phonenumber">Contact Number While On leave:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="phonenumber" name="phonenumber" placeholder="" class="input-xlarge">
            <p class="help-block">Enter 10 digits phone number</p>
          </div>
        </div>
          <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="Datefrom">Leave From:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" class="datepicker" id="datefrom" name="datefrom">
            <p class="help-block">Leave starts from</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="dateto">Leave To:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" class="datepicker" id="dateto" name="dateto">
            <p class="help-block">Leave end date not less than start date</p>
          </div>
        </div>
        
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type=submit>Save Details</button>
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
<script src="<?php echo $CFG->wwwroot?>/assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $CFG->wwwroot?>/assets/js/validation.js"></script>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker().on('changeDate', function(){
	    $(this).datepicker('hide');
	  });
	
});
</script>
