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
<title>Dhawal Consultancy Welcomes you..Master Updation</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<style type="text/css">
<!--
.style3 {color: #E5E1D0}
-->
</style>
<script type="text/javascript">
	var vsrno=0;
	var arrflds1 = Array("srno","cono","empno","pfno","uanno","aadhaarno","jdate_epf","jdate_pen","sex","sname","fname","ishusband","mmname","oname","bdate","btown","bdist","bstate","bnation","nationality","nominee","nomineeRel");
	var arrflds2 = Array("caddr1","caddr2","ctown","cdistt","cstate","cpin","email","paddr1","paddr2","ptown","pdistt","pstate","ppin","wages","share1","share2","pension","left_job","l_date","l_reason","offDay","wageRate");
</script>
</head>

<body bgcolor="#205bc8" >
<script type="text/javascript">
<?php 
	if(!(isset($_SESSION["user"])))
	{
			echo('window.location.href="index.html";');
			
	}
?>
</script>

</script>
<table  align="center" cellpadding="0" cellspacing="0" style="max-width:900px; width:900px; border-width:0px;" >
  <tr>
  	<td  class="baner"></td>
  </tr>
  <tr>
    <td colspan="2" align="right" >
<iframe src="menu.php" width="900px" height="34px" frameborder="0" class="bck"  scrolling="no"></iframe></td>
  </tr>
 <tr><td colspan="2" align="left" style="color:#FFFFFF" >Welcome <?php echo $_SESSION['co']->cname;?></td></tr>
  
  <tr><td colspan="2" align="center">
  <iframe id="frm1" class="chpwd1" src="chpwd.html"></iframe></div></td></tr>
  <tr bgcolor="#ece9de" >
  	<td width="900">
   	  <div style="border-style:solid; border-right-color:#CCCCCC;  border-width:1px; border-bottom:none; border-left:none; border-top:none; padding:0; margin:5px 0px 0 0">
 		<table width="890" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:0 0 0 5px; ">
    		<tr>
        		<td width="885" ><img src="images/top.png" /></td>
	      	</tr>
    	  	<tr>
        		<td class="middletd" align="center">
            		<div style="margin:0px 10px 0px 10px; padding:0;" >
          				<table width="855" border="0" cellpadding="0px" cellspacing="0px;">
                    	    <tr>
                                <td height="38"  colspan="2" bgcolor="#Ece9de" class="bk_tab">
                                    <a href="entry1.php" target="call">
                                        <div class="but" >
                                            <p align="center">Entry1</p>
                                        </div>
                                    </a>
                                    <a href="entry2.php" target="call">
                                        <div class="but">
                                            <p align="center">Entry2</p>
                                        </div>
                                    </a>
                                    <a href="list.html" target="call">
                                        <div class="but">
                                            <p align="center">List</p>
                                        </div>
                                    </a>
                                    <a href="paidchalanEntry.html" target="call">
                                        <div class="but">
                                            <p align="center">Paid Chalan Entry</p>
                                        </div>
                                    </a>
                                </td>
                    		</tr>
                    		<tr>
                        		<td valign="top"><iframe src="entry1.php" width="850px" height="450px" frameborder="0" name="call"  id ="call" class="ifram"></iframe></td>
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
</body>
</html>
