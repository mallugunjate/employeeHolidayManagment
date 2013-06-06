<?php 
require_once '../config.php';
session_start();
session_destroy();
global $CFG;
header('Location:'.$CFG->wwwroot.'/public/login.php');

?>
