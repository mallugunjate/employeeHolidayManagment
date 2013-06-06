<?php 
	require_once '../config.php';
	require_once ('../lib.php');
    global $CFG;
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
  requiredlogin();
  $rs = isadmin();
  if(!$rs){
    var_dump("You are noty authorized to view this page");
    exit;
  }
    //check if user is admin else display u don't have permission
?>     
<!-- NAVIGATION PANEL FOR ADMIN -->
<ul class="nav  nav-tabs nav-stacked">
	<li class="nav-header">Admin Panel</li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/employee_detail.php">Add New Employee</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/update_employee_detail.php">Update Employee</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/leave_application.php">Employee Leave</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/employee_reports.php">Generate Employee Reports</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/employee_salary_slip.php">Upload Salary Slip</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/admin/addholidaylist.php">Add Holiday List</a></li>
  <li><a href="<?php echo $CFG->wwwroot?>/admin/view_employee_salary_slip.php">Check Employee Salary Slip</a></li>  
</ul>
    <?php require_once '../user/panel.php'; ?>