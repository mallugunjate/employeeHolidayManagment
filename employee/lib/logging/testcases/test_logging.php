<?php
require_once(dirname(__FILE__) . '/../logger.php');

$log_level = 'info';

$obj = new logger($log_level, 'testcases', '/tmp/', 'test_logging');

$obj->debug("printing debug message");
$obj->info("printing info message");
$obj->error("printing error message");
