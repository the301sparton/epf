<?php session_start(); ?>
<?php

error_reporting(E_ERROR | E_PARSE);
	include_once('Comp.php');?>
<?php
	date_default_timezone_set('Asia/Kolkata');
	$cnt = $_POST['vcnt'];
//	echo $cnt;
	function __autoload($cl)
	{
		include $cl.".php";
	}
	function dom($m,$y)
	{
		if($m==4||$m==6||$m==9||$m==11)
			return 30;
		else if($m<>2)
			return 31;
		else
		{
			if($y%4==0)
				return 29;
			else
				return 28;
		}
	}
	function monno($st)
	{
		$marr = array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
		$p=$marr[$st];
		return $p;
	}
	
function datediff($ldt,$jdt)
{
	$diff1=new mydt();
	$y1=$ldt->format('Y');$m1=$ldt->format('m');$d1=$ldt->format('d');	
	$y2= $jdt->format('Y');$m2=$jdt->format('m');$d2=$jdt->format('d');	
	if($d1>=$d2)
	{
		$diff1->d=$d1-$d2;
	}
	else
	{
		$diff1->d=$d1+dom($m2,$y2)-$d2;
		$m2++;
		if($m2>12)
		{
			$m2=1;$y2++;
		}
	}
	if($m1>=$m2)
	{
		$diff1->m=$m1-$m2;
	}
	else
	{
		$diff1->m=$m1+12-$m2;
		$y2++;
	}
	$diff1->y=$y1-$y2;
	return $diff1;
}


		
function connect()
{
	$dbhost     = "localhost";  
	$dbname     = "vaico112_epf";  
	$dbuser     = "vaico112_dbadmin";  
	$dbpass     = "test_23";  
	
	//	$con = mysql_connect("localhost","root","");
	$con = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
	if (!$con)
	{
	 die('Could not connect: ' . mysql_error());
	}
	return $con;
}
$cnt=$_POST['vcnt'];
//echo $cnt;
if($cnt==106)
	form5if();
else if($cnt==110)
	form19();
else if($cnt==1101)
	form19new();
else if($cnt==105)
	form2();
else if($cnt==104)
	form10c();
else if($cnt==107)
	form5();
else if($cnt==108)
	form5only();
else if($cnt==109)
	form13();
else if($cnt==101)
	form10d1();
else if($cnt==102)
	form10d2();
else if($cnt==103)
	form10d3();
else if($cnt==111)
	form20();
else if($cnt==112)
	form31();
else if($cnt==113)
	breakstat();
else if($cnt==114)
	form20();
else if($cnt==115)
	form20();
else if($cnt==116)
    formaattendance();
function form31()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	
	$st = "select `srno`,`sname`,`fname`,`pfno`,`wages`,`uanno` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$st='cname2@@'.$_SESSION['co']->cname.','.$_SESSION['co']->addr.'~epfno@@'.$pfno;
		$st=$st.'~sname@@'.$row['sname']."~fname@@".$row['fname'];
		$st=$st."~cname1@@"."For ".$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}

function form10d2()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`pfno`,`uanno`,`sex`,`nationality`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
	if($row=$sql->fetch())
	{
		$ldt=new DateTime($row['l_date']);
		$st='epfno@@'.$pfno.'~sname@@'.$row['sname'].'~sname1@@'.$row['sname'].'~fname@@'.$row['fname'].'~sex@@'.$row['sex'].'~coname1@@'.$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}
function form10d3()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st="select max(`fyyear`) as `lfyyear` from `monthly` where `srno`in ".$srnolist. " and `pension`>0 and `instno`=12";
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	if(!($row=$sql->fetch()))
	{
		die("No record found");
	}
	$fyyr=$row[0];
//	echo $fyyr;
	$st="select `sname`,`instno`,`year`,`month`,`wages`,`pension` from `monlist` where `fyyear`=".$fyyr . " and `srno` in ".$srnolist. " order by `instno`";
//	echo $st;
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$n=0;
	while($row=$sql->fetch())
	{
		if($n>0) 
		{	$st=$st."|";}
		else
		{	$st=$st.$row['sname']."~".$_SESSION['co']->cname."^";}
		$n++;
		$m=monno($row['month']);$y=$row['year'];
		$st=$st."year".$n."@@".$row['year']."~month".$n."@@".$row['month']."~nodays".$n."@@".dom($m,$y);
		$st=$st."~wages".$n."@@".$row['wages']."~pension".$n."@@".$row['pension'];
	}
	echo $st;
}

function form20()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$ldt=new DateTime($row['l_date']);
		$st='cname@@'.$_SESSION['co']->cname.','.$_SESSION['co']->addr.'~epfno@@'.$pfno.'~sname@@'.$row['sname']."~fname@@".$row['fname']."~l_date@@".$ldt->format("d-m-Y");
		$st=$st."~l_reason@@".$row['l_reason']."~cname1@@".$_SESSION['co']->cname."~cname2@@".$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}





function form13()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`pfno`,`uanno`,jdate_epf from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$jdt=new DateTime($row['jdate_epf']);
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$st='cname@@'.$_SESSION['co']->cname.','.$_SESSION['co']->addr.'~epfno@@'.$pfno.'~sname@@'.$row['sname']."~fname@@".$row['fname']."~jdate_epf@@".$jdt->format("d-m-Y");
		$st=$st."~cname1@@".$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}

function form2()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`bdate`,`sex`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
	// echo $st;
//	exit;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		// echo $pfno;
	try {
    $bdt = new DateTime($row['bdate']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}	
	//	echo "xx";
		$st='cname@@'.$_SESSION['co']->cname.'~sex@@'.$row['sex'].'~epfno@@';
		$st=$st.$pfno.'~bdate@@'.$bdt->format("d-m-Y").'~sname@@'.strtoupper($row['sname'])."~fname@@";
		$st=$st.$row['fname'];
		//echo $st;
	}
	else
	{
		echo "-";
	}
	echo $st;
}
function breakstat()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`jdate_epf`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$ldt=new DateTime($row['l_date']);

		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];

		$jdt=new DateTime($row['jdate_epf']);
		$st='cname@@'.$_SESSION['co']->cname.','.$_SESSION['co']->addr.'~epfno@@'.$pfno.'~sname@@'.$row['sname']."~l_date@@".$ldt->format("d-m-Y")."~jdate_epf@@".$jdt->format("d-m-Y").'~cname1@@'.$_SESSION['co']->cname;
		if($jdt->format('d-m-Y')=='01-01-1900' || $ldt->format('d-m-Y')=='01-01-1900')
		{
			echo $st;
			return;
		}	
		
		$diff = $jdt->diff($ldt);
/*		$diff1 = datediff($ldt,$jdt); */
		$st=$st."~d1@@".$diff->d."~d2@@".$diff->d;
		$st=$st."~m1@@".$diff->m."~m2@@".$diff->m;
		$st=$st."~y1@@".$diff->y."~y2@@".$diff->y;
		
		$dtstr = $jdt->format('Y')."-03-31";
		$tdt = new DateTime($dtstr);
		if($tdt>$ldt)
		{
			$st=$st."~t1_1@@".$jdt->format('d-m-y')." To ".$ldt->format('d-m-y')."~t2_1@@NIL";
		}
		else
		{
			if($jdt->format('m')<4)
			{	$yr=$jdt->format('y'); }
			else
			{	$yr=($jdt->format('y')) + 1; 
				$tdt = $tdt->modify('+1 year');
			}
			$st=$st."~t1_1@@".($jdt->format('d-m-y'))." To ".($tdt->format('y'))."~t2_1@@NIL";
			$yr=$tdt->format('y');
			$n=2;
			$tdt = $tdt->modify('+1 year');
			while($ldt>$tdt)
			{
				$st=$st."~t1_".$n."@@".$yr." To ".(($tdt->format('y')))."~t2_".$n."@@NIL";
				$tdt = $tdt->modify('+1 year');
				$yr=$tdt->format('Y');
				$n++;
			}
			$st=$st."~t1_".$n."@@".$yr." To ".$ldt->format('d-m-y')."~t2_".$n."@@NIL";;
		}	
	}
	else
	{
		echo "-";
	}
	echo $st;
}
function form10d1()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`bdate`,`sex`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$ldt=new DateTime($row['l_date']);
		$bdt=new DateTime($row['bdate']);
		$st='cname@@'.$_SESSION['co']->cname.'~caddr@@'.$_SESSION['co']->addr.'~sex@@'.$row['sex'].'~epfno@@';
		$st=$st.$pfno.'~bdate@@'.$bdt->format("d-m-Y").'~sname@@'.$row['sname']."~fname@@";
		$st=$st.$row['fname']."~l_date@@".$ldt->format("d-m-Y")."~l_reason@@".$row['l_reason'].'~sname1@@For '.$row['sname'];
	}
	else
	{
		echo "-";
	}
	echo $st;
}

function form19()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$ldt=new DateTime($row['l_date']);
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$st='cname@@'.$_SESSION['co']->cname.'~caddr@@'.$_SESSION['co']->addr.'~epfno@@'.$pfno.'~sname@@'.$row['sname']."~fname@@".$row['fname']."~ldate@@".$ldt->format("d-m-Y");
		$st=$st."~lreason@@".$row['l_reason']."~cname1@@".$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}
function form19new()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$ldt=new DateTime($row['l_date']);
		$uanno=$row['uanno'];
		$st='uanno@@'.$uanno.'~sname@@'.$row['sname']."~fname@@".$row['fname']."~ldate@@".$ldt->format("d-m-Y");
		$st=$st."~lreason@@".$row['l_reason'];
	}
	else
	{
		echo "-";
	}
	echo $st;
}
function form10c()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`bdate`,`pfno`,`uanno`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono."   and`master`.`srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$bdt=new DateTime($row['bdate']);
		$ldt=new DateTime($row['l_date']);
		$st='cname@@'.$_SESSION['co']->cname.'~caddr@@'.$_SESSION['co']->addr.'~epfno@@';
		$st=$st.$pfno.'~bdate@@'.$bdt->format("d-m-Y").'~sname@@'.$row['sname']."~fname@@";
		$st=$st.$row['fname']."~ldate@@".$ldt->format("d-m-Y")."~lreason@@".$row['l_reason'].'~coname@@'.$_SESSION['co']->cname;
	}
	else
	{
		echo "-";
	}
	echo $st;
}	
function form5if()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`fname`,`bdate`,`pfno`,`uanno`,`sex`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `master`.`srno` in ".$srnolist;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$i=1;
	if($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$_SESSION['co']->epfno.'/'.$row['pfno'];
		$bdt=new DateTime($row['bdate']);
		$ldt=new DateTime($row['l_date']);
		$st=$st."sname1@@".$row['sname']."~fname1@@".$row['fname'];
		$st=$st."~sname2@@".$row['sname']."~ldate1@@".$ldt->format("d-m-Y")."~pfno1@@".$pfno;
		$st=$st."~coname2@@For M/S ".$_SESSION['co']->cname."~coname1@@".$_SESSION['co']->cname."~epfno1@@".$pfno;
		echo $st;
	}
	else
		echo "-";
}
function form5()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`bdate`,`pfno`,`uanno`,`bdate`,`jdate_epf`,`sex`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `master`.`srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$i=1;
	$st=$st."coname1@@".$_SESSION['co']->cname."~epfno1@@".$_SESSION['co']->epfno;
	$st=$st."~coname2@@".$_SESSION['co']->cname."~epfno2@@".$_SESSION['co']->epfno;
	
	while($row=$sql->fetch())
	{
		$pfno=($row['uanno']>0)?$row['uanno']:$row['pfno'];
		$st=$st."|";
		$bdt=new DateTime($row['bdate']);
		$ldt=new DateTime($row['l_date']);
		$jdt=new DateTime($row['jdate_epf']);
		$st=$st.'b'.$i.'1@@'.$pfno;
		$st=$st.'~b'.$i.'3@@'.$bdt->format("d-m-Y").'~b'.$i.'2@@'.$row['sname'].'~b'.$i.'4@@'.$row['sex'].'~b'.$i.'5@@'.$jdt->format("d-m-Y");
		$st=$st.'~c'.$i.'1@@'.$pfno;
		$st=$st.'~c'.$i.'2@@'.$row['sname'];
		$st=$st.'~c'.$i.'3@@'.$ldt->format("d-m-Y").'~c'.$i.'4@@'.$row['l_reason'];
		$i++;
	}
	$st=$st."|cname3@@".$_SESSION['co']->cname;
	if($i==0)
	{
		echo "-";
	}
	echo $st;
}	
function form5only()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`bdate`,`pfno`,`uanno`,`bdate`,`jdate_epf`,`sex`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `master`.`srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$i=1;
	$st=$st."coname1@@".$_SESSION['co']->cname."~epfno1@@".$_SESSION['co']->epfno;
	while($row=$sql->fetch())
	{
		$st=$st."|";
		$pfno=($row['uanno']>0)?$row['uanno']:$row['pfno'];
//		if($i>1) $st=$st."|";
		$bdt=new DateTime($row['bdate']);
		$ldt=new DateTime($row['l_date']);
		$jdt=new DateTime($row['jdate_epf']);
		$st=$st.'cname@@'.$_SESSION['co']->cname.'~b'.$i.'1@@'. $pfno;
		$st=$st.'~b'.$i.'3@@'.$bdt->format("d-m-Y").'~b'.$i.'2@@'.$row['sname'].'~b'.$i.'4@@'.$row['sex'].'~b'.$i.'5@@'.$jdt->format("d-m-Y");
		$i++;
	}
	if($i==0)
	{
		echo "-";
	}
	echo $st;
}	



function formaattendance()
{
	$cono=$_SESSION['co']->cono;
	$srnolist=$_POST['srnolist'];
	$st = "select `srno`,`sname`,`bdate`,`pfno`,`uanno`,`bdate`,`jdate_epf`,`sex`,`l_date`,`l_reason` from `master` where `master`.`cono`=".$cono." and `master`.`srno` in ".$srnolist;
//	echo $st;
	$con=connect();
	$sql = $con->prepare($st);
	$sql->execute(array());
	$st="";
	$i=1;
	$st=$st."coname1@@".$_SESSION['co']->cname."~epfno1@@".$_SESSION['co']->epfno;
	while($row=$sql->fetch())
	{
		$st=$st."|";
		$pfno=($row['uanno']>0)?$row['uanno']:$row['pfno'];
//		if($i>1) $st=$st."|";
		$bdt=new DateTime($row['bdate']);
		$ldt=new DateTime($row['l_date']);
		$jdt=new DateTime($row['jdate_epf']);
		$st=$st.'cname@@'.$_SESSION['co']->cname.'~b'.$i.'1@@'. $pfno;
		$st=$st.'~b'.$i.'2@@'.$row['sname'];
		$i++;
	}
	if($i==0)
	{
		echo "-";
	}
	echo $st;
}


?>