<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<?php
 session_start(); ?>
<?php
	include_once("db.php");
 $cono=$_POST['cono'];

$st="select * from temp2";
if(!($res=mysql_query($st,$con)))
{ 
	echo "-";
	return;
}
$st="insert into `master` (`cono`,`empno`,`uanno`,`aadhaarno`,`jdate_epf`,`jdate_pen`,`sex`,`sname`,`fname`,";
$st=$st."`relationship`,`bdate`,`email`) values ";
$n=0;
$epfrate=12;$penrate=8.33;
while(($row=mysql_fetch_array($res))) {
	$tst="";
	if($n>0) {
		$tst=$tst.",";}
	$n++;
	$tst =$tst."(".$cono.",".$row['uanno'].",".$row['uanno'].",'".$row['aadhaarno']."','".$row['jdate_epf'];
	$tst=$tst."','".$row['jdate_pen']."','".$row['sex']."','".$row['sname']."','".$row['fname']."','";
	$tst=$tst.$row['relationship']."','".$row['bdate']."','".$row['email']."')";
	$st=$st.$tst;
}
if(!(mysql_query($st,$con)))
{
	die($st);
	echo 'Unsuccessful';
}	
else
{
	echo 'Done';
}
?>