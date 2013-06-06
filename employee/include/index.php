<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>
<em>Page Specific Content Text</em>
 
  Lorem ipsum dolor sit amet, consectetuer adipiscing 
  elit, sed nonummy nibh euismod tincidunt ut laoreet 
  dolore magna aliat volutpat. Ut wisi enim ad minim 
  veniam, quis nostrud exercita ullamcorper 
  suscipit lobortis nisl ut aliquip ex consequat.
 
 
 
  Duis autem vel eum iriure dolor in hendrerit in 
  vulputate velit molestie consequat, vel illum 
  dolore eu feugiat nulla facilisis ats eros et 
  accumsan et iusto odio dignissim qui blandit 
  prasent up zzril delenit augue duis dolore te 
  feugait nulla facilisi. Lorem euismod tincidunt 
  erat volutpat.
<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Page Specific Title Text";
  //Apply the template
  include("master.php");
?>