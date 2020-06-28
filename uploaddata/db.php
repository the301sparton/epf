<?php
error_reporting(E_ALL ^ E_DEPRECATED);?>
<?php
    $con = mysql_connect("localhost","u353330278_epfAdmin","test_123","u353330278_epf");
    if (!$con)
    {
     die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("u353330278_epf", $con);
?>
