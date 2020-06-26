<?php



 session_start(); ?>
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
<title>Dhawal Consultancy Welcomes you... Company Selection</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<style type="text/css">
<!--
.style3 {color: #E5E1D0}
-->
</style>
<script type="text/javascript">
 var fcono=0;
 var fcnam=""; 
</script>
</head>

<body bgcolor="#205bc8">
<table  align="center" cellpadding="0" cellspacing="0" style="max-width:900px; width:900px; border-width:0px;" >
  <tr>
  	<td  class="baner"></td>
  </tr>
  <tr>
    <td colspan="2" align="right" >
<iframe src="menu.php" width="900px" height="17px" frameborder="0" class="bck"  scrolling="no"></iframe></td>
  </tr>
<!--  
  <tr>
    <td class="bck" align="right" >
    <div class="menudiv">Log Out</div></td>
    </td> -->
  </tr>
  <tr bgcolor="#ece9de" >
  	<td width="900">
   	  <div style="border-style:solid; border-right-color:#CCCCCC;  border-width:1px; border-bottom:none; border-left:none; border-top:none; padding:0; margin:0 0">
 		<table width="890" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:0 0 0 5px; ">
    		<tr>
        		<td width="885"><div style="margin:4px 10px 0px 18px; padding:0;" >
<img src="images/top.png" /></div></td>
	      	</tr>
    	  	<tr>
        		<td class="middletd" align="center">
            		<div style="margin:0px 10px 0px 10px; padding:0;" >
          				<table width="1000" border="0" cellpadding="0px" cellspacing="0px;">
                    	    <tr>
                                <td height="38"  colspan="2" bgcolor="#Ece9de" class="bk_tab">
                                  <a href="colist.html" target="call">
                                        <div class="but" ><p align="center">co. List</p></div>
                                  </a>
                                  <a href="masterform.html"  target="call">
                                        <div class="but"><p align="center">Co. Update</p></div>
                                  </a>
                                 <a href="billexport.html"  target="call">
                                        <div class="but"><p align="center">Co. Export Bills</p></div>
                                  </a></td>

                    		</tr>
                    		<tr>
                        		<td valign="top"><iframe src="colist.html" width="850px" height="450px" frameborder="0" name="call"  id ="call" class="ifram"></iframe></td>
                    		</tr>
                        </table>
                  	</div>
        		</td>
      		</tr>
      		<tr>
		        <td><img src="images/bottom.png" /></td>
      		</tr>
    	</table></div>
	 </td>
  </tr>
  <tr>
    <td  bgcolor="#205BC8"><p class="site_maint">Site maintained by Vaikuntha Computers</p>    </td>
  </tr>
</table>
<script type="text/javascript">
<?php 
	if($_SESSION["user"]!="Super User")
	{ 
		echo('window.location.href="index.html"');
	}
?>
</script>
</body>
</html>
