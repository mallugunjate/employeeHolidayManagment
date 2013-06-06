<?php 
  require_once '../config.php';
  global $CFG;
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
  	$salaryslipdate = @$_POST['selectmonth'];
  	$file = @$_POST['file'];
  	$selectmonth	= strtotime($salaryslipdate);
  	$filename 		= $salaryslipdate.'.pdf';
  	$filelocation 	= $CFG->dataroot.'/'.$empid.'/';
  	//for pdf only 
	  	$allowedExts = array("pdf");
	  	$extension = end(@explode(".", $_FILES["file"]["name"]));
	  	if ((( $_FILES["file"]["type"] == "application/pdf")
	  			|| ($_FILES["file"]["type"] == "application/x-pdf")
	  			|| ($_FILES["file"]["type"] == "application/acrobat")
	  			|| ($_FILES["file"]["type"] == "applications/vnd.pdf")
	  			|| ($_FILES["file"]["type"] == "text/pdf")
	  			|| ($_FILES["file"]["type"] == "text/x-pdf")
	  			)
	  			&& ($_FILES["file"]["size"] < 2*1024*1024)
	  			&& in_array($extension, $allowedExts)){
	  		if ($_FILES["file"]["error"] > 0){
	  			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	  		}else{
          if(@mkdir($filelocation , 0777)){}
	  			if (file_exists($CFG->dataroot.'/'.$_FILES["file"]["name"])){
	  				move_uploaded_file($_FILES["file"]["tmp_name"],
                                  $filelocation.$filename);
            echo  '<div align="center" class="alert alert-waring">';
              echo  "File already exists & and is being updated."; 
            echo '</div>';
          }else{
	  			  move_uploaded_file($_FILES["file"]["tmp_name"],$filelocation.$filename);
            $sql = "INSERT INTO `employee_salary_slip`(`slip_id`, `emp_id`, `pdf_file_name`, `pdf_file_location`)
            VALUES (NULL,$empid,'$filename','$filelocation')";
            //var_dump($sql);
            $insert=$DB->insert($sql);
            if (isset($insert)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Stored in: ".$filelocation.$filename;
              echo '</div>';
            }	
	  			}
	  		}	
	  		}else{
	  		echo '<div class="alert alert-danger">';
	  			echo "Invalid file uploaded,Please upload once again, make sure file is pdf & size less then 2MB";
	  		echo '</div>';
	  	}
  }
  	//query to insert
  	
    
?>
<div class=row-fluid>
  <div class=span4>
    <?php require_once 'adminpanel.php'; ?>
  </div>
  <div class=span8>
    <form class="form-horizontal" action='' method="POST" enctype="multipart/form-data">
      <fieldset>
        <div id="legend">
          <legend class="">Upload Salary Slip For Employee</legend>
        </div>
    	    <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="employee">Employee Name:</label>
          <div class="controls">
            <!-- <input type="text" id="employeename" name="username" placeholder="" class="input-xlarge"> -->
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
          </div>
          <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="month">Select Month:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" class="datepicker" placeholder="MM/YYYY" name="selectmonth">
            <p class="help-block">Select Month to upload salary slip</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="salaryslip">Upload salary slip:<span style="color:red">*</span></label>
          <div class="controls">
           <input type="file" id="file" name="file" placeholder="" class="input-xlarge">
            <p class="help-block">Select file and upload</p>
          </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type="submit">Save</button>
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
	$('.datepicker').datepicker({
		 format: "mm-yyyy",
		 viewMode: "months",
		 minViewMode: "months"
		 
		}).on('changeDate', function(){
		    $(this).datepicker('hide');
		});
});
</script>
