<?php 
	require_once '../config.php';
    global $CFG;
    require_once ('../lib.php');
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
  $rs = isadmin();
  if($rs){
    require_once '../admin/adminpanel.php';
  }
    //check if user is admin else display u don't have permission
?>     
<!-- NAVIGATION PANEL FOR ADMIN -->
<ul class="nav  nav-tabs nav-stacked">
	<li class="nav-header">my profile </li>
	<li><a href="<?php echo $CFG->wwwroot?>/user/changepwd.php">Change Password</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/user/viewprofile.php">View Profile</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/user/view_salary_slip.php">View Salary Slip</a></li>
	<li><a href="<?php echo $CFG->wwwroot?>/user/view_leave.php">View Leave</a></li>
</ul>
    