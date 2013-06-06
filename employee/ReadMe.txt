/*** Implementation ************/
1.Create new database new Myql/phpmyadmin.

2.Import "employee.sql" file in Newly creatd database.

3.Open config.php and change the following.

	$CFG->dbhost    = 'localhost';                //give Your database hostname

	$CFG->dbname    = 'leave_module';              //newly created database name

	$CFG->dbuser    = 'root';                      //your database username
      
	$CFG->dbpass    = '';                           //your database password

	$CFG->wwwroot   = 'http://localhost/employee';  //change base url as per your server

	$CFG->dataroot  = 'F:/wamp/employeedata';       //Give the path where your pdf challen files will be stored. 
        
       $CFG->Username   = '*******@gmail.com';          //Gmail emailid to use for SMTP authentication

       $CFG->Password   = 'password';                   //Gmail Password to use for SMTP authentication
    

4.Now open in your brower 
	if you see login page login with following data
		username : 'admin';
		password : '123456';
	else 
		configure config.php again.


6.To change the logo image put logo in employee/logo/ folder and rename the image as logo.jpg

6.done