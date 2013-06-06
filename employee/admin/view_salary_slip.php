<?php
require_once '../config.php';
require_once '../lib.php';
  global $CFG;
  global $USER;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isemployee();
  if(!$rs){
    var_dump("You are not authorized to view this page");
    exit;
  }
?>
<?php
	if(isset($_REQUEST['slip_id'])){
		$slipid = $_REQUEST['slip_id'];
		$query = "SELECT * FROM employee_salary_slip WHERE slip_id = ".$slipid." ORDER BY slip_id desc";
		$rs = $DB->select($query);
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".$rs['result'][0]['pdf_file_name']);
		@readfile($rs['result'][0]['pdf_file_location'].$rs['result'][0]['pdf_file_name']);
		exit;
	}
	
	?>
