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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript">
	var xmlhttp;
	function getxmlhttp()
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else  
		{
		// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  
		}
	}

function logout()
{
	getxmlhttp();
	temp = "n="+Math.random()+"&vcnt=2"
	xmlhttp.open("POST","loginajax.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(temp); 
	window.parent.location.href="index.html";
}

</script>
</head>
<body class="bck" >
 <?php 
 if(isset($_SESSION['co']))
 {?>	
    <?php 
	if(isset($_SESSION['user']))
	{
		if($_SESSION['user']=='Super User')
		{?>
    <div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onClick="window.parent.location.href='master.php'" >Co. List</div>
  <?php }}?>
    <div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onclick="window.parent.document.getElementById('frm1').className='chpwd'" >Change Password</div>	<div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onclick="window.parent.document.getElementById('frm2').className='chpwd'" >Get UAN</div>
    <div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onClick="window.parent.location.href='form2.php'" >Master Updation</div>
    <div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onClick="window.parent.location.href='Reports.php'" >Reports</div>
    <?php } ?>
    <div class="menudiv" onMouseOver="this.className='menudiv1'" onMouseOut="this.className='menudiv'" onClick="logout();" >Log Out</div>
    
</body>
</html>
