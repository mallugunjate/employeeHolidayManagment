<?php 
  require_once ('../config.php');
  require_once ('../lib.php');
  require_once ('../dblib.php');
  global $CFG;
  global $CFG;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isadmin();
  if(!$rs){
    var_dump("You are noty authorized to view this page");
    exit;
  }
  $sql = "SELECT e.id,e.emp_id,e.first_name,e.last_name	FROM employee as e";

  $result=$DB->select($sql);
  foreach ($result['result'] as $index){
  	$leavefrom =date('Y-m-d',@$index['leave_from']);
  	//echo "<br/>";
  	//echo $leavefrom = @$index['leave_from'];
  	$leaveto =date('Y-m-d',@$index['leave_to']);
  	
  }
?>
<div class=row-fluid>
  <div class=span3>
    <?php require_once 'adminpanel.php'; ?>
  </div>
  <div class=span9>
    <form class="form-horizontal" action='' method="POST">
      <fieldset>
        <div id="legend">
          <legend>Select The Fields To Generate Leave Reports</legend>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="employee">Employee Name:</label>
          <div class="controls">
            <!-- <input type="text" id="employeename" name="employeename" placeholder="" class="input-xlarge"> -->
            <select class="input-xlarge" name="employeeid" >
            <?php
				$employeeid = -9;
				if(isset($_REQUEST['employeeid'])){
					$employeeid = $_REQUEST['employeeid'];
				}
			foreach ($result['result'] as $key ) {   
				if($employeeid == $key['id']){
					echo '<option value="'.$key['id'].'" selected>'.$key['first_name'].' '.$key['last_name'].'</option>';
				}else{
					echo '<option value="'.$key['id'].'">'.$key['first_name'].' '.$key['last_name'].'</option>';
				}	
           }?> 		  				
    		    </select>
            
            <p class="help-block">Select employee Name</p>
          </div>
        </div>
          <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="Datefrom">Select Dates:</label>
          <div class="controls">
            <input type="text" class="datepicker" placeholder="From" id="datefrom" name="datefrom">
            <input type="text" class="datepicker" placeholder="To" id="dateto" name="dateto">
            <p class="help-block">Select the date range</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" type=submit name=submit onclick="generate_repor();">Generate Reports</button>
          </div>
        </div>
      </fieldset>
    </form>
    </div>
    
    <?php 
    if (isset($_POST['submit'])) {
    	$employeeid = @$_POST['employeeid'];
    	//var_dump($_POST);exit;
    	$datefromunix		= strtotime(@$_POST['datefrom']);
    	$datefrom[]		= date('Y-m-d',$datefromunix);
    	$datetounix 		= strtotime(@$_POST['dateto']);
    	$dateto[]		= date('Y-m-d',$datetounix);
    	
    	$start = new DateTime($datefrom[0]);
    	$end = new DateTime($dateto[0]);
    	$newend = (string)$end->format('Y m d');;
    	$newstart = (string)$start->format('Y m d');;
		$sql = "SELECT e.id,e.emp_id,e.first_name,e.last_name,el.leave_from,el.leave_to
				FROM employee as e
				JOIN employee_leave as el ON e.id = el.emp_id
				WHERE id = $employeeid AND ((FROM_UNIXTIME(leave_from,'%Y %m %d') between '$newstart' AND '$newend') 
				OR (FROM_UNIXTIME(leave_to,'%Y %m %d') between '$newstart' AND  '$newend'))
				";
		$result=$DB->select($sql);
		
		/*	Get Holiday List in b/w datefrom and dateto	*/
			$holidayq = "SELECT *,FROM_UNIXTIME(holiday_start,'%Y-%m-%d') as date
	    							 FROM holiday_list
	          		          WHERE  FROM_UNIXTIME(holiday_start,'%Y %m %d') >= '$newstart' AND FROM_UNIXTIME(holiday_start,'%Y %m %d') <= '$newend'";
	    		$holiday=$DB->select($holidayq);
	    		$holidaydates = array();
	    		$i=0;
	    		foreach ($holiday['result'] as $key => $value){
					$total = $value['no_of_holiday'];
    				$j=0;
    				$newdate = $value['date'];
    				while($total--){
						if($j==0){
							if (!checkweekend($newdate)){
								$holidaydates[$i++] = $newdate;	
							}
							$j++;
						}else{
							list($y,$m,$d) = explode('-',$newdate);
							$incholidaydate = Date('Y-m-d',mktime(0,0,0,$m,$d+1,$y));
							if(!checkweekend($newdate)){
								$holidaydates[$i++] = $incholidaydate;
							}
						}
    				}			 
	    		}
	    		// best stored as array, so you can add more than one
	    		$holidays = $holidaydates;
	    		//var_dump($holidays);
		/*	ENd of Holiday List	*/

    ?> 
 
  <div class=span8>
      <fieldset>
      <div class="">
      <?php
      if (!$result['count']) {
			echo "<div class='alert'><strong>Employee didn't took any Leave between the given date </strong></div>";
		}
      ?>
      <table class="table table-striped">
    <thead>
    <tr>
    <th>Employee Id</th>
    <th>Employee Name</th>
    <th>Month</th>
    <th>Leave Dates</th>
    <th>Total</th>
    <th style="waidth: 36px;"></th>
    </tr>
    </thead>
    <tbody>
            <?php 
            $days = 0;
            $totalLeaves = 0;
            foreach ($result['result'] as $key){
	            //Count No. Of Holidays
            	$leavefrom =date('Y-m-d',@$key['leave_from']);
				$leaveto =date('Y-m-d',@$key['leave_to']);
	       		
				$start = new DateTime($leavefrom);
				$start->format('Y-m-d');	
				$end = new DateTime($leaveto);
				$end->format('Y-m-d');
				//Add to include end date
					$end->modify('+1 day');
					$interval = $end->diff($start);
				// total days
		    		$days = $interval->days;
		    	
		    	// create an iterateable period of date (P1D equates to 1 day)
		    		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		    		$newend = (string)$end->format('Y m d');
		    		$newstart = (string)$start->format('Y m d');
	    		foreach($period as $dt) {
	    			$curr = $dt->format('D');
	    			// for the updated question
	    			if (in_array($dt->format('Y-m-d'), $holidays)) {
	    				$days--;
	    			}
	    
	    			// substract if Saturday or Sunday
	    			if ($curr == 'Sat' || $curr == 'Sun') {
	    				$days--;
	    			}
	    		}
	    		$totalLeaves += $days;
	    		//End of Holiday Count
            ?>
            <tr>
              <td><?php echo $key['emp_id']?></td>
              <td><?php echo $key['first_name']." ".$key['last_name']?></td>
              <td><?php 
		              	if( date('M',$key['leave_from']) === date('M',$key['leave_to'])) {
			              	echo date('M',$key['leave_from']);
			            }else{
			              echo date('M',$key['leave_from']).' - '.date('M',$key['leave_to']); 
		            	}
               ?></td>
              <td><?php if (date('d/m/Y',$key['leave_from']).'-'.date('d/m/Y',$key['leave_to'])) {
              	           echo date('d/m/Y',$key['leave_from']).'-'.date('d/m/Y',$key['leave_to']);
                           }else{
                                 echo "Select Dates";
                                }  ?></td>
              <td><?php if($days){
              	         echo $days;
                         }
                         ?>
              </td>		 
            </tr>
			<?php  }  ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
           	<tr>
	           	<td></td>
	           	<td></td>
	           	<td></td>
	           	
	           	<td><strong>Total Leaves:</strong></td>
	           	<td><strong><?php echo $totalLeaves;?></strong></td>
           	</tr>
			</tbody>
        </table>
    <?php  }  ?>
        </div>
      </fieldset>
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
<script src="../assets/js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
    $('.datepicker').datepicker();
    
});
<script type="text/javascript" src="../assets/js/jquery-1.9.1.min.js"></script>
<script src="../assets/js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker().on('changeDate', function(){
	    $(this).datepicker('hide');
	  });
    
});
</script>
