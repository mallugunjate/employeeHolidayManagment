<?php
require_once ('../config.php');
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
$conn   = mysql_connect('localhost','root','') or die ('Could not connect to database:'.mysql_error());
$dbname = 'moodle';
mysql_select_db($dbname,$conn);
	$get_records="SELECT shortname,data
	              FROM mdl_user INNER JOIN (mdl_user_info_field 
			      INNER JOIN mdl_user_info_data ON mdl_user_info_field.id = mdl_user_info_data.fieldid) 
			      ON mdl_user.id = mdl_user_info_data.userid
	              WHERE mdl_user_info_data.userid=mdl_user.id";
	$res=mysql_query($get_records);
	$results =mysql_fetch_array($res,MYSQL_ASSOC);
	//var_dump($results[education]->data);exit;
	//var_dump($results);exit;
	
	//$result =(string)$results;
	//$results = new object();
	//print_r($result);
	foreach ($results as $one)
	$insert_records = "INSERT INTO rpt_user
	                   (batchid,batchidno,nurse_name,gender,date_of_birth,state,eduction,joining_date,department_posting,caste,religion,contact_number,father_husband_name,trainee_address,district,pincode) 
						VALUES( $result[bid]->data,
							    $result[bidno]->data,
								$result[nurse]->data,
								$result[gender]->data,
								$result[dob]->data,
								$result[state]->data,
								$result[education]->data,
								$result[joindate]->data,
								$result[departpost]->data,
								$result[caste]->data,
								$result[religion]->data,
								$result[cantactnumber]->data,
								$result[fathername]->data,
								$result[traineeaddress]->data,
								$result[district]->data,
								$result[pincode]->data,
								
	                            )";
		print_r($results[bid]->data);exit;
	/* $insert_records = "INSERT INTO rpt_user
	(batchid,batchidno,nurse_name,gender,date_of_birth,state,eduction,joining_date,department_posting,caste,religion,contact_number,father_husband_name,trainee_address,district,pincode)
	VALUES(157,15701,'abc','male','10-07-1988'
	)"; */
	$executed=mysql_query($insert_records);
	//var_dump($executed);exit;
	
/* 	if ($results !==''){
		//var_dump($results);exit;
		$records[] = new object();
		$results->
		$results->name;
		$records->batchid;
		$records->batchidno;
		$records->nurse_name;
		$records->gender;
		$records->date_of_birth;
		$records->state;
		$records->eduction;
		$records->joining_date;
		$records->department_posting;
		$records->caste;
		$records->religion;
		$records->contact_number;
		$records->father_husband_name;
		$records->trainee_address;
		$records->district;
		$records->pincode;
		$DB->insert_record('rpt_user', $records,true);
		
				
	} */
    			
	
	
?>
<html>
<head>
<title>Report</title>
</head>
<body>
<form name="report" action="" method="POST">
<div align="center">
<br><br>
<input type="submit" value="Get Reports"><br>
</div>
</form>
</body>
</html>


	