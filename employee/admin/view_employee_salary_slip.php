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
?>
<div class=row-fluid>
	<div class=span4>
		<?php require_once 'adminpanel.php'; ?>
	</div>
	<div class=span8>
		<h3>List of Salary slip</h3>
		<form method=get>
			<select name=employeeid>
 		<?php
 			$query = "SELECT * FROM employee"; 
			$rs = $DB->select($query);
			$employeeid = -9;
			if(isset($_REQUEST['employeeid'])){
				$employeeid = $_REQUEST['employeeid'];
			}
			foreach ($rs['result'] as $key => $value) {
				if($employeeid == $value['id']){
					echo '<option value="'.$value['id'].'" selected>'.$value['first_name'].' '.$value['last_name'].'</option>';
				}else{
					echo '<option value="'.$value['id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
				}	
			}
			?>
			</select>
			<button class='btn btn-info' type=submit name=submit>Get Salary Slip</button>
		</form>
			<?php
			if(isset($_REQUEST['submit'])){
				$eid = $_REQUEST['employeeid'];
				$query = "SELECT * FROM employee_salary_slip WHERE emp_id = $eid ORDER BY slip_id desc"; 
				$rs = $DB->select($query);
				//var_dump($rs);
		 		if ($rs['count']) {
	 		 	foreach ($rs['result'] as $key => $value) {
					$line = $value['pdf_file_name'];
					$line = substr($line,0,strlen($line)-4);
					echo "<div class=well><a href='".$CFG->wwwroot."/admin/view_salary_slip.php?slip_id=".$value['slip_id']."' class=popup2 >Get Salary Slip for \t".$line.": <button class='btn btn-info' type='submit' name='submit' >View Salary Slip</button></a></div>";
				}
			}else{
				echo '<div class="alert alert-warning">';
			 		echo "No Salary Sleep uploaded";
				echo '</div>';
			}	
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


<script type="text/javascript">
	//initialize the 3 popup css class names - create more if needed
	var matchClass=['popup1','popup2','popup3'];
	//Set your 3 basic sizes and other options for the class names above - create more if needed
	var popup1 = 'width=400,height=300,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	var popup2 = 'width=800,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	var popup3 = 'width=1000,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	
	//When the link is clicked, this event handler function is triggered which creates the pop-up windows 
	function eventHandler() {
			var x = 0;
			var popupSpecs;
			//figure out what popup size, etc to apply to the click
			while(x < matchClass.length){
					if((" "+this.className+" ").indexOf(" "+matchClass[x]+" ") > -1){
						popupSpecs = matchClass[x];
						var popurl = this.href;
					}
			x++;
			}
		//Create a "unique" name for the window using a random number
		var popupName = Math.floor(Math.random()*10000001);
		//Opens the pop-up window according to the specified specs
		newwindow=window.open(popurl,popupName,eval(popupSpecs));
		return false;
	}

	//Attach the onclick event to all your links that have the specified CSS class names
	function attachPopup(){
		var linkElems = document.getElementsByTagName('a'),i;
		for (i in linkElems){
			var x = 0;
			while(x < matchClass.length){
				if((" "+linkElems[i].className+" ").indexOf(" "+matchClass[x]+" ") > -1){
					linkElems[i].onclick = eventHandler;
				}
			x++;
			}
		}
	}

	//Call the function when the page loads
	window.onload = function (){
	    attachPopup();
	}
</script>