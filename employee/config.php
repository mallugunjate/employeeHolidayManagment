<?php  // Moodle configuration file
unset($CFG);
global $CFG;
$CFG = new stdClass();
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'leave_module';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->wwwroot   = 'http://localhost/employee';
$CFG->dataroot  = 'D:/wamp/employeedata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;
