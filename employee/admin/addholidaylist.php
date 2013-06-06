<?php 
  require_once '../config.php';
  require_once ('../lib.php');
  require_once ('../dblib.php');
	global $DB;
  global $CFG;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isadmin();
  if(!$rs){
    var_dump("You are noty authorized to view this page");
    exit;
  }

  global $CFG;
  if(isset($_POST['submit'])){
  	$startdate 			= strtotime(@$_POST['startdate']);
  	$noofdays 			= @$_POST['noofdays'];
  	$description 			= @$_POST['description'];
  	//query to insert
  	$sql = "INSERT INTO `holiday_list` (`id`, `holiday_start`, `no_of_holiday`, `description`) 
  			                VALUES (NULL, '$startdate', '$noofdays', '$description')";
  	//var_dump($sql);
  	$insert=$DB->insert($sql);
      if (isset($insert)){?>
      	<div align="center" class="alert alert-success"> 
      	<?php echo "Holiday lists are added";
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
    <form class="form-horizontal" action='<?php echo $CFG->wwwroot?>/admin/addholidaylist.php' method="POST">
      <fieldset>
        <legend>Add Holiday to list</legend>
        <span style="color:red" class="controls">* Marked fields are compulsary.</span>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="startdate"> Starting Date:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" class="datepicker" name='startdate' placeholder="DD/MM/YYYY">
            <p class="help-block">Select starting holiday date</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="noofdays"> Numaber of Holiday including Stating Date:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" name='noofdays' placeholder="number of days">
            <p class="help-block">Enter the holidays</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="description"> Description:</label>
          <div class="controls">
            <input type="text" name='description' placeholder="description">
            <p class="help-block">Enter description for holiday</p>
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

<script src="<?php echo $CFG->wwwroot?>/assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $CFG->wwwroot?>/assets/js/validation.js"></script>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker().on('changeDate', function(){
	    $(this).datepicker('hide');
	  }); 
});

</script>