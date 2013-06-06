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
    var_dump("You are noty authorized to view this page");
    exit;
  }
  if(isset($_GET['id'])){
  	$eid =  $_GET['id'];
  	$query = "DELETE FROM `employee` WHERE id=$eid";
  	$rs = $DB->delete($query);
  	if($rs){
  		echo '<div align="center" class="alert alert-success">';
  			echo "Employee details has been deleted Successfully";
  		echo '</div>';
  		header('Refresh: 4; URL='.$CFG->wwwroot.'/admin/update_employee_detail.php');
  	}else{
  		echo '<div class="alert alert-danger">';
  			echo "Something went wrong";
  		echo '</div>';
  	}
  }
  /*
   * Query to get employee details
   */

  $sql = "SELECT `id`, `emp_id`, `first_name`, `last_name`, `address`, `username`, `email`, `mobile_number`, `telephone_number`, `password`
  		  FROM `employee`" ;
  $result=$DB->select($sql);

?>
<div class=row-fluid>
  <div class=span3>
    <?php require_once 'adminpanel.php'; ?>
  </div>
  <div class=span9>
    <form class="form-horizontal" action='<?php echo $CFG->wwwroot?>/admin/update_employee_detail.php' method="POST">
      <fieldset>
        <div id="legend">
          <legend class="">Upadate Employee Details</legend>
        </div>
        <div class="btn-toolbar">
</div>
<div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
           <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Address</th>
          <th>MobileNo</th>
          <th>Action</th>
          <th style="width: 36px;"></th>
        </tr>
      </thead>
      <tbody>
      	<?php $i=1;?>
        <?php foreach ($result['result'] as $key){?>
        <tr>
          <td><?php echo $i++?></td>
          <td><?php echo $key['first_name']." ".$key['last_name']?></td>
          <td><?php echo $key['username']?></td>
          <td><?php echo $key['email']?></td>
          
          <td><?php echo $key['address']?></td>
          
          <td><?php echo $key['mobile_number']?></td>
          <td>
              <a href="<?php echo $CFG->wwwroot?>/admin/edit_employee.php?id=<?php echo $key['id']?>"><i class="icon-pencil"></i></a>
              <a href="<?php echo $CFG->wwwroot?>/admin/update_employee_detail.php?id=<?php echo $key['id']?>" role="button" data-toggle="modal"  onclick="return confirm('Are you sure you want to delete?')"><i class="icon-remove"></i></a>
          </td>
        </tr>
       <?php }?>
      </tbody>
    </table>
</div>
<!-- <div class="pagination">
    <ul>
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div> -->
<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text">Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal" onclick="">Delete</button>
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