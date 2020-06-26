<?php
error_reporting(E_ALL ^ E_DEPRECATED);?>
<?php
$con=mysql_connect("localhost","vaico112_dbadmin","test_23") or die("Could not connect");
mysql_select_db("vaico112_epf",$con) or die("could not connect database");
?>
