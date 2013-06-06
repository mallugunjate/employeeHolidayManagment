<?php
require_once '../config.php';
require_once '../lib.php';
global $USER;
global $CFG;
?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <?php
          if(requiredlogin()){
            if(isadmin()){
              $homeurl = $CFG->wwwroot.'/admin';
            }elseif(isemployee()){
              $homeurl  = $CFG->wwwroot.'/user';
            }  
          }else{
            $homeurl = '#';
          }
        ?>
        <li><a href="<?php echo $homeurl ?>">Home</a></li>
        <li><a href="#">About</a></li>
        <?php
          global $USER;
          if($USER->id){
            echo '<li><a href="'.$CFG->wwwroot.'/public/logout.php">Logout</a></li>';    
          }
        ?>
        
      </ul>
    </div>
  </div>
</div><!-- /.navbar -->