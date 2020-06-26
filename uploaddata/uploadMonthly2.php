
<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<?php
 session_start(); ?>

<?php
	include_once('Comp.php');
     include_once("db.php"); ?>

<?php
	function monno($mon)
	{
		$arrmon=array("Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12,"Jan"=>1,"Feb"=>2,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
		$mno = $arrmon[$mon];
		return $mno;
	}
	function instno($st)
	{
		$marr = array("Mar"=>1,"Apr"=>2,"May"=>3,"Jun"=>4,"Jul"=>5,"Aug"=>6,"Sep"=>7,"Oct"=>8,"Nov"=>9,"Dec"=>10,"Jan"=>11,"Feb"=>12,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
		$p=$marr[$st];
		return $p;
	}
	function getSrNo($uan)
	{
	    $sst="select `srno` from `master` where `uanno` =".$uan;
//	    echo $st;
	    if(!($rres=mysql_query($sst,$con))){
	        echo "-";
	        return 0;
	    }
	    $row1=mysql_fetch_array($rres);
        echo $uan.",". $row1['srno'],";";
	    return $row1['srno'];
	}
	


$mon = substr($_POST['month'],0,3);
$yr=$_POST['tyear'];
$cono=$_SESSION['co']->cono;
//echo $cono;exit;
 $cono=$_POST['cono'];
if($mon=="Jan" || $mon=="Feb")
	$fyyear=$yr-1;
else
	$fyyear=$yr;
$inno=instno($mon);

//echo $mon.",".$yr.",".$co;
$st="select * from temp1";
if(!($res=mysql_query($st,$con)))
{ 
	echo "-";
	return;
}
$st="insert into `monthly` (`srno`,`cono`,`month`,`fyyear`,`year`,`wages`,`share1`,`share2`,`pension`,`instno`) values ";
$n=0;
$epfrate=12;$penrate=8.33;
$msg="";
while(($row=mysql_fetch_array($res))) {
		$wages=$row['salary'];
		$sh1=round($wages*$epfrate/100,0);
		if($wages>15000)
			$pwages=15000;
		else
			$pwages=$wages;
		$pen = round($pwages*$penrate/100,0);
		$sh2 = $sh1-$pen;
	$tst="";
	if($n>0) {
		$tst=$tst.",";}
	$n++;
    $sst="select `srno` from `master` where `uanno` =".$row['empno'];
//	    echo $sst."</br>";
    if(!($rres=mysql_query($sst,$con))){
        $vsrno=0;
	    }
	    else {
	         $row1=mysql_fetch_array($rres);
	         $vsrno=$row1['srno'];
	    }
	    if(is_null($vsrno)==true){
	        $msg=$msg. $row['ename']." has invalid uan"."</br>";
	    }
	$tst =$tst."(".$vsrno.",".$cono.",'".$mon."',".$fyyear.",".$yr.",".$wages.",".$sh1.",".$sh2.",".$pen.",".$inno.")";
	$st=$st.$tst;
}
if($msg=='') {
    if(!(mysql_query($st,$con)))
    {
    	die($st);
    	echo 'Unsuccessful';
    }	
    else
    {
    	echo "Done";
    }
}
else {
    echo $msg;
}
?>
