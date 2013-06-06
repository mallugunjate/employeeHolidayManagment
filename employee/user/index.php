<?php 
  require_once ('../config.php');
  require_once ('../dblib.php');
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
  /*
   * Get values from from 
   */
?>
<div class=row-fluid>
	<div class=span4>
	<?php require_once 'panel.php'?>
	</div>
	<div class=span8>
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
