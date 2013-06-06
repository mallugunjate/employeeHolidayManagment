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
    var_dump("You are noty authorized to view this page");
    exit;
  }
?>

<?php
	if(isset($_REQUEST['submit'])){
		$slipid = $_REQUEST['slip_id'];
		$query = "SELECT * FROM employee_salary_slip WHERE slip_id = ".$slipid." ORDER BY slip_id desc";
		$rs = $DB->select($query);
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".$rs['result'][0]['pdf_file_name']);
		@readfile($rs['result'][0]['pdf_file_location'].$rs['result'][0]['pdf_file_name']);
		exit;
	}
	?>

<?php
?>
<div class=row-fluid>
	<div class=span4>
		<?php require_once 'panel.php'; ?>
	</div>
	<div class=span8>
		<h3>List of Salary slip</h3>
 		<?php
 			$query = "SELECT * FROM employee_salary_slip WHERE emp_id = $USER->id ORDER BY slip_id desc"; 
			$rs = $DB->select($query);
	 		if ($rs['count']) {
	 		 	foreach ($rs['result'] as $key => $value) {
					$line = $value['pdf_file_name'];
					$line = substr($line,0,strlen($line)-4);
					echo "<div><form method=post>Get Salary Slip for \t".$line.": <input type=hidden name=slip_id value=".$value['slip_id']."><button class='btn btn-info' type='submit' name='submit' onClick='window.open('http://localhost/employee/admin/view_employee_salary_slip.php');' >View Salary Slip</button></form></div>";
					

				}
			}else{
				echo '<div class="alert alert-warning">';
			 		echo "No Salary Sleep uploaded";
				echo '</div>';
			}	
		?>	
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