<?php session_start(); ?>
<?php 
	include_once('Comp.php');
?>
<?php
	function __autoload($cl)
	{
		include $cl.".php";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.title {text-align:right; padding-right:5px;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body style="margin:auto; background-color:#FFFFCC">
<?php 

	if(!(isset($_SESSION["user"])))

	{

			echo('window.location.href="index.html";');

			

	}

?>

<table border="1" >
<tr><td colspan="2"><font size="+2"><b>Change your password</b></font></td></tr>
<tr><td class="title">Enter current password</td><td><input type="password" id="tpwd"  /></td></tr>
<tr><td class="title">Enter current password</td><td><input type="password" id="tnpwd1"  /></td></tr>
<tr><td class="title">Enter current password</td><td><input type="password" id="tnpwd2" /></td></tr>
<tr><td colspan="2" align="right"><input type="button" value="Submit" onclick="chpwd()" /></td></tr>
</table>
</body>
</html>
