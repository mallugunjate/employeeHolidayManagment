<?php
require_once('config.php');
require_once ('lib.php');
global $CFG;
global $DB;
global $USER;
class db{
	var $conn;
	public function db()
	{
		global $CFG;

		$this->conn   = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass) or die ('Could not connect to database:'.mysql_error());
		mysql_select_db($CFG->dbname) or die('couldnot select database:'.mysql_error());
		# code... for persistance connection using sqli
	}

	/*
		for inserting in db 
		param: 
		
	*/
	public function insert($query)
	{
		$check = mysql_query($query,$this->conn);
		//var_dump($query);exit;
		if ($check) {
			return mysql_insert_id();
		}else{
			return false;
		}
	}

	/*
		for update in db 
		param: 
		
	*/
	public function update($query)
	{
		$check = mysql_query($query,$this->conn);
		//var_dump($check);
		if ($check) {
			return true;
		}else{
			return false;
		}
	}

	/*
		for select from db 
		param: 
		
	*/
	public function select($query)
	{
		$check = mysql_query($query,$this->conn);
		//var_dump($query);exit;
		if ($check) {
			$queryresult = array();
			$i = 0;
			$tnum = mysql_num_rows($check);
			while ($i < $tnum ){
				$queryresult[$i] = mysql_fetch_row($check,MYSQL_ASSOC);
				$i++;
			}
				$arr = array('result' => $queryresult,
						'count'=> mysql_num_rows($check));
			return $arr;
		}else{
			return false;
		}
	}

	/*
		for select from db 
		param: 
		
	*/
	public function delete($query)
	{
		$check = mysql_query($query,$this->conn);
		//var_dump($check);exit;
		if ($check) {
			return true;
		}else{
			return false;
		}
	}
}
?>