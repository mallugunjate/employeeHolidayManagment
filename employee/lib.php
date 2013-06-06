<?php
@session_start();
require_once('config.php');
require_once ('dblib.php');
/*check for user login*/
global $CFG;
	function viewpdf($file,$path)
	{
		global $CFG;
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".$file);
		@readfile($path.$file);
	}
	function isadmin()
	{	
		$user = $_SESSION['USER'];
		global $CFG;
		if($user->flag){
			return true;
		}else{
			return false;
		}
	}

	function isemployee()
	{	
		$user = $_SESSION['USER'];
		global $CFG;
		if($user->id){
			return true;
		}else{
			return false;
		}
	}

	function requiredlogin()
	{	global $CFG;
		if (!isset($_SESSION['USER'])){
		    $newuser =  new user();  
		}
		$user = $_SESSION['USER'];
		if($user->id){
			return true;
		}else{
			//header('Location: '.$CFG->wwwroot.'/public/login.php');
			//exit;
			return false;
		}
	}
	function checkweekend($date){
		$date1 = strtotime($date);
		$date2 = date("l", $date1);
		$date3 = strtolower($date2);
		if(($date3 == "saturday" )|| ($date3 == "sunday")){
			return true;
		} else {
			return false;
		}
	}
global $DB;
$DB = new db();
if (!isset($_SESSION['USER'])){
	$newuser =  new user();
}
global $USER;
$USER = $_SESSION['USER'];
?>