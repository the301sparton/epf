<?php session_start(); ?>
<?php 
//	echo "A";exit;
	include_once('Comp.php');
	?> 
<?php 
	date_default_timezone_set('Asia/Kolkata');

//	$_SESSION['cono']=1;
	$cnt = $_POST['vcnt'];
//	echo $cnt;exit;
	function __autoload($cl)
	{
		include $cl.".php"; 
	}
//	$cono=$_SESSION['co']->cono;
/*				$temp=new Comp();
				$temp->cono=1;$temp->cname="Test Co.";$temp->epfrate=12;
				$temp->penrate=8.33;$temp->addr="Railtoli Gondia";$temp->estddate="01/04/2000";
				$temp->epfno="NG/NAG/12345";
				$_SESSION['co']= new Comp();
				$_SESSION['co']=$temp; */
//				echo $cnt;exit;
	
	if($cnt==1)
	{ monlist(); }
	else if($cnt==2)
	{ form12a(); }
	else if($cnt==3)
	{ form6a(); }
	else if($cnt==5)
	{ chalan(); }
	else if($cnt==41)
	{	loademplist();  }
	else if($cnt==4)
	{	form3a();}
	else if($cnt==6)
	{ reconciliation(); }
	else if($cnt==7)
	{  form9();	}
	else if($cnt==8)
	{
	showAattRegister(); } 
	else if($cnt==81)
	{
		saveAttRegister();
	}
	else if($cnt==9)
	{	exportdata(); }
	else if($cnt==91)
	{
	    exportbills();
	}
	else if($cont==12)
	{	sendmail(); }

	function instno($st)
	{ 
		$marr = array("Mar"=>1,"Apr"=>2,"May"=>3,"Jun"=>4,"Jul"=>5,"Aug"=>6,"Sep"=>7,"Oct"=>8,"Nov"=>9,"Dec"=>10,"Jan"=>11,"Feb"=>12,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
		$p=$marr[$st];
		return $p;
	}
	function monno($st)
	{
		$marr = array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
		$p=$marr[$st];
		return $p;
	}

	function connect()
	{
		$con = mysql_connect("localhost","u353330278_epfAdmin","test_123");
		if (!$con)
		{
		 die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("u353330278_epf", $con);
		return $con;
	} 
function chalan()
{
	$mon=$_POST['mon'];$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;

	$con=connect();
	$st = "select * from `monsum` where `cono`=? and `month`=? and `fyyear`=?";
//	echo $st;
	$sql = $con->prepare($st);
	$sql->execute(array($cono,$mon,$fyyr));
	$st=$_SESSION['co']->cname."~".$_SESSION['co']->addr."~".$_SESSION['co']->epfno;
	if($row=$sql->fetch())
	{
		$st=$st."~".$row['twages']."~".$row['pwages']."~".$row['sh1']."~".$row['sh2']."~".$row['tpen']."~";
		$st=$st.$row['nemp']."~".$row['nemppen']."~".$row['fyyear']."~".$row['month']."~".$row['year'];
	}
	else
	{	$st="-";}
	
	echo $st;
}
function form6a()
{
//	echo "<script> alert 'a';</script>";
	$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
	$con=connect();
	$st= "select `srno`,`pfno`,`sname`,sum(`wages`) as twages,sum(`share1`) as tsh1 ,sum(`share2`) as tsh2 , sum(`pension`) as tpen from monlist where `cono`=? and `fyyear`=? group by `srno`,`pfno`,`sname`" ;
//	echo $st;
	$sql = $con->prepare($st);
	$sql->execute(array($cono,$fyyr));
	$st="";
	$st=$_SESSION['co']->cname."~".$_SESSION['co']->addr."~".$_SESSION['co']->epfno."~".$_SESSION['co']->epfrate;
	while($row=$sql->fetch())
	{
		$tot=$row['tsh1']+$row['tsh2']+$row['tpen'];
		$st=$st."|".$row['pfno']."~".$row['sname']."~".$row['twages']."~".$row['tsh1']."~".$row['tsh2']."~".$row['tpen']."~".$tot;
	}
	echo $st;
}
function monlist()
{
//	echo "t";exit;
	$mon=$_POST['mon'];$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
	
//	$cono=1;
	$con=connect();
	$st= "select `sname`,`pfno`,`uanno`,`wages`,`share1`,`share2`,`pension` from monlist where `cono`=? and `month`=? and `fyyear`=?" ;
//	echo $st;exit;
	$sql = $con->prepare($st);
	$sql->execute(array($cono,$mon,$fyyr));
	$st=$_SESSION['co']->cname."~".$_SESSION['co']->addr."~".$_SESSION['co']->epfno;
	$n=1;
	while($row=$sql->fetch())
	{
/*		if($n==1)
		{
			$st=$st.$row['pfno']."~".$row['sname']."~".$row['wages']."~".$row['share1']."~".$row['share2']."~".$row['pension'];$n++;
		}
		else
		{ */
			$st=$st."|".$row['uanno']."~".$row['sname']."~".$row['wages']."~".$row['share1']."~".$row['share2']."~".$row['pension'];$n++;
//		}
	}
	echo $st;
}
function form12a()
{
	$mon=$_POST['mon'];$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
	$con=connect();
	$st = "select `jdate_epf`,`l_date`,`left_job`,`instno` from `monlist` where `wages`>0 and `cono`=? and `month`=? and `fyyear`=?";
	$sql = $con->prepare($st);
//	echo $sql;
	$sql->execute(array($cono,$mon,$fyyr));
	$noemp=0;$nnemp=0;$nremp=0;
	while($row=$sql->fetch())
	{
		if($row['instno']>12)
		{
			$noemp++;
			continue;
		}
		if($row['instno']<11)
			$yr=$fyyr;
		else
			$yr=$fyyr+1;
		$mons = "JanFebMarAprMayJunJulAugSepOctNovDec";
		if($n=strpos($mons,$mon))
			$mno=$n/3+1;
		else
			$mno=date("n");
		if($mon=="Jan" || $mon=="Feb")
			$year=$fyyr+1;
		else
			$year=$fyyr;
		$cdt = mktime(0,0,0,$mno,1,$year);
		if($row['left_job']==0)
		{
		 	if($row['jdate_epf']<$cdt)
				$noemp++;
			else 
			{
				$dt1=date_parse($row['jdate_epf']);$dt2=date_parse($cdt);
				if($dt1['month']==$dt2['month'] && $dt1['year']==$dt2['year'])
					$nnemp++;
			}
		}
		else
			$nremp++;
	}	
	$st = "select * from `monsum` where `cono`=? and `month`=? and `fyyear`=?";
//	echo $st;
	$sql = $con->prepare($st);
	$sql->execute(array($cono,$mon,$fyyr));
	$st=$_SESSION['co']->cname."~".$_SESSION['co']->addr."~".$_SESSION['co']->epfno;
//	echo $st;

	if($row=$sql->fetch())
	{
		$st=$st."~".$row['twages']."~".$row['pwages']."~".$row['sh1']."~".$row['sh2']."~".$row['tpen']."~".$noemp."~".$nnemp."~".$nremp."~".$row['fyyear']."~".$row['month']."~".$row['year'];
	}
	else
	{	$st="-";}
	
	
	echo $st;
}
	function loademplist()
	{
		$cono=$_SESSION['co']->cono;
		$recno=$_POST['recno']-1;
	//	$st = "select `srno`,`sname` from `master` where `master`.`cono`=".$cono." limit ".$recno.", 10";
  		$st = "select `srno`,`sname` from `master` where `master`.`cono`=".$cono;
		
	//	echo $st;
		$con=connect();
		$sql = $con->prepare($st);
		$sql->execute(array());
		$st="";
		$n=0;
		while($row=$sql->fetch())
		{
			if($n==0)
			{
				$st=$st.$row['srno']."~".$row['sname'];
				$n=1;
			}
			else
			{
				$st=$st."|".$row['srno']."~".$row['sname'];
			}
		}
		echo $st;
	}
	function form3a()
	{
		$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;$srno=$_POST['srno'];
		$st = "select * from `form3a` where `fyyear`=? and `cono`=? and `srno`=? order by `instno`";
		$con = connect();
		$sql = $con->prepare($st);
		$sql->execute(array($fyyr,$cono,$srno));
		$st="1st April " . $fyyr . " to " . "31st March " . ($fyyr + 1) ."~";
		$n=0;		
		$nopaid=0;
		while($row=$sql->fetch())
		{
			if($n==0)
			{
				$st=$st.$_SESSION['co']->epfno."/".$row['pfno']."~".$row['sname']."~".$row['fname']."~";
				$st=$st.$_SESSION['co']->cname."~".$_SESSION['co']->addr."~".$_SESSION['co']->epfrate;
			}
			$st=$st."|".$row['instno']."~".$row['wages']."~".$row['share1']."~".$row['share2']."~".$row['pension'];
			if($row['wages']>0)
				$nopaid++;
			$n++;
		}
		if($nopaid==0)
			echo "-";
		else
			echo $st;
	}
	
	function reconciliation()
	{
		$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
		$sqlst = "select * from reconcil where `fyyear`=? and `cono`=?";
		$con = connect();
		$sql = $con->prepare($sqlst);
		$sql->execute(array($fyyr,$cono));
		$n=0;
		$st="";
		while($row=$sql->fetch())
		{
			if($n==0)
			{
				$st=$st.$_SESSION['co']->epfno."~".$_SESSION['co']->epfrate."~".$fyyr."~".$_SESSION['co']->cname;
			}
			$vac1=$row['share1']+$row['share2'];
			$vac2=round(($row['wages']*0.011<5?5:$row['wages']*0.011),0);
			$vac21=round($row['wages']*0.005,0);
			$vac22=round(($row['wages'] * 0.0001 < 2?2:$row['wages'] * 0.0001), 0);
			$ino=instno($row['month']);
			$st=$st."|".$ino."~".$row['noemp']."~".$row['wages']."~".$vac1."~".$row['pension']."~".$vac2."~".$vac21."~".$vac22;
			$n++;
		}
//		echo $st;
//		return;
		$st=$st."#";
		$sqlst = "select `ac1`,`ac10`,`ac2`,`ac21`,`ac22`,`pdate`,`month` from `paidchalan` where `fyyear`=? and `cono`=?";
		$sql = $con->prepare($sqlst);
		$sql->execute(array($fyyr,$cono));
		$n=0;
		while($row=$sql->fetch())
		{
			if($n>0) $st=$st . "|";
			$tot=$row['ac1']+$row['ac10']+$row['ac2']+$row['ac21']+$row['ac22'];
			$ino=instno($row['month']);
			$dt=new DateTime($row['pdate']);
			$st=$st.$ino."~".$row['ac1']."~".$row['ac10']."~".$row['ac2']."~".$row['ac21']."~".$row['ac22']."~".$tot."~".$dt->format("d-m-Y");
			$n++;
//			echo $st;
		}
		echo $st;
	}	
	function saveAttRegister()
	{
		$mon=$_POST['mon'];$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
		$datast=$_POST['datast'];
		$epfrate = $_SESSION['co']->epfrate;
		$penrate= $_SESSION['co']->penrate;
		$sh1=0;$pen=0;$sh2=0;
		$mno = monno($mon);
		$st="";
		$st1=$mno.",".(($mno>2)?$fyyr:$fyyr+1).",".$fyyr;
		$st1M="'".$mon."',".$fyyr.",".(($mno>2)?$fyyr:$fyyr+1);
		$instno = ($mno>2)?($mno-2):($mno+10);
		
		$dst = "delete from attendance where `month`=".monno($mon)." and `fyyear`=".$fyyr;
		$dst1= "delete from monthly where `month`='".$mon."' and `fyyear`=".$fyyr;

		$con=connect();
		$sql = $con->prepare($dst);
		$sql->execute();
		$sql = $con->prepare($dst1);
		$sql->execute(); 
	
		$st="insert into attendance(`srno`,`cono`,`month`,`year`,`fyyear`,d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31,wages,pf,esic) values ";

		$stM = "insert into monthly(`srno`,`cono`,`month`,`fyyear`,`year`,`wages`,`share1`,`share2`,`pension`,`instno`) values ";
			
//		echo $st;exit;
/*		for($i=1;$i<=31;$i++){
			$st=$st."d".$i.",";
//			echo $st;exit;
		}
		$st=$st." wages,pf,esic) values ";
//		echo $st;exit; */
		$arr = explode("|",$datast);
		$tcnt=0;
	//	print_r($arr);exit; 
		foreach($arr as $arrst) {
			if($tcnt>0){$st=$st.",";}
//			print_r($arrst);exit;
		   	$arr1=explode("~",$arrst);
	//		print_r($arr1);exit;
			$st2 = "(".$arr1[1].",".substr($arr1[1],0,5).",".$st1.",";
			$st2M= "(".$arr1[1].",".substr($arr1[1],0,5).",".$st1M.",";
			for($i=2;$i<33;$i++){ 
				$st2=$st2."'".$arr1[$i]."',";} 
			//	echo "ssss";exit;
//				echo $arr1[34];exit;
			$arr1[34]=(is_numeric($arr1[34])?$arr1[34]:0);
			$arr1[35]=(is_numeric($arr1[35])?$arr1[35]:0);
			$arr1[36]=(is_numeric($arr1[36])?$arr1[36]:0);
//			$arr1[34]=0;$arr1[35]=0;$arr1[36]=0;	
			$st2=$st2.$arr1[34].",".$arr1[35].",".$arr1[36].")";
	//		echo $st2;
			$sqlst = ($st).($st2);
			$wages = $arr1[34];
			$sh1=round($wages*$epfrate/100,0);
			if($wages>15000)
				$pwages=15000;
			else
				$pwages=$wages;
			$pen = round($pwages*$penrate/100,0);
			$sh2 = $sh1-$pen; 
			$st2M = $st2M.$wages.",".$sh1.",".$sh2.",".$pen.",".$instno.")";
			$sqlstM = ($stM).($st2M);
//			echo $sqlstM;exit;
	    $con=connect();
		$sql = $con->prepare($sqlst);
		$sql->execute();
		$sql = $con->prepare($sqlstM);
		$sql->execute();
		
	//		echo $st;exit;
			}   
			
		} 
//		echo $datast; exit; 
	
	
	function showAattRegister()  
	{
    	$mon=$_POST['mon'];$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
		$filtype=$_POST['filtype'];
		$fil1="";$fil2="";
		if($filtype=='temp3')
		{
			$fil1="temp3";$fil2="attRegTemp"; 
		} else { 
		$fil1="attendance";$fil2="attReg"; 
		}
//		echo "xxx";exit;
			
//		echo $fil1.",".$mon;exit;
	    $cono=$_SESSION['co']->cono;
	    $sqlst="select count(`srno`) as norecs from `".$fil1. "` where `cono`=".$cono." and `month`='".monno($mon)."' and `fyyear`=".$fyyr;
//		echo $sqlst;exit;
	    $con=connect();
	    $sql=$con->prepare($sqlst);
	    $sql->execute();
        $st="";$n=0;
		$row=$sql->fetch();
//		echo $row['norecs'];exit;
	    if($row['norecs']>0){
	        $sqlst="select * from `". $fil2 . "` where `month`=".monno($mon)." and `fyyear`=".$fyyr;
	//		echo $sqlst;exit; 
			$con=connect();
	        $sql1 = $con->prepare($sqlst);
	        $sql1->execute();
			$st="1#";
			$row1=$sql->fetch();
	//		echo $row1['month'];exit;
			while($row1=$sql1->fetch())
			{
		//		echo "test";exit;
				if($n>0) $st=$st . "|";
				$st=$st.$row1['srno']."~".$row1['cono']."~".$row1['sname'];
				for($i=1;$i<=31;$i++){
					$st=$st."~".$row1['d'.$i];
				}
				$st=$st."~".$row1['wages']."~".$row1['pf']."~".$row1['esic'];
				$n++;
			} 
			echo $st;
			//exit;
	    }
	    else {
	        $sqlst = "select `srno`,`cono`,`sname`,`wagerate` from `master` where `cono`=".$cono;
			$sql1 = $con->prepare($sqlst);
			$sql1->execute();
			$st="2#";
			while($row1=$sql1->fetch())
			{
				if($n>0) $st=$st . "|";
				$st=$st.$row1['srno']."~".$row1['cono']."~".$row1['sname']."~".$row1['wagerate'];
				$n++;
			}
		}
		echo $st;
	}
	function form9()
	{
		$cono=$_SESSION['co']->cono;
		$sqlst="select `cono`,`pfno`,`sname`,`sex`,`bdate`,`jdate_epf`,`jdate_pen`,`l_date`,`l_reason` from `master` where `cono`=?";
		$con = connect();
		$sql = $con->prepare($sqlst);
		$sql->execute(array($cono));
		$n=0;
		$st="";
		while($row=$sql->fetch())
		{
			if($n>0) $st=$st . "|";
			if(is_date($row['l_date']))
			{
				$dtarr=date_parse($row['l_date']);
				if($dtarr['year']=='1900')
				{	$ldtstr="";}
				else
				{
					$ldate=new DateTime($row['l_date']);
					$ldtstr=$ldate->format("d-m-Y");
				}
			}
			else
			{	$ldtstr="";}
			$dtarr=date_parse($row['jdate_pen']);
			if($dtarr['year']=='1900')
			{	$pdate=new DateTime($row['jdate_epf']);}
			else
			{
				$pdate=new DateTime($row['jdate_pen']);
			}
		
			$bdt=new DateTime($row['bdate']);$edate=new DateTime($row['jdate_epf']);
			$st = $st.$row['pfno']."~".$row['sname']."~".$bdt->format("d-m-Y")."~".$row['sex']."~";
			$st=$st.$edate->format("d-m-Y")."~".$pdate->format("d-m-Y")."~";
			$st=$st.$ldtstr."~".$row['l_reason'];
			$n++;
		}
		$sqlst="select `pname`,`designation` from partners where `cono`=?";
		$con = connect();
		$sql = $con->prepare($sqlst);
		$sql->execute(array($cono));
		$nst="";$n1=0;
		while($row=$sql->fetch())
		{
			if($n1==0)
			{
				$nst=$row['pname']."~".$row['designation'];
			}
			else
			{
				$nst=$nst."|".$row['pname']."~".$row['designation'];
			}
			$n1++;
		}
		echo trim($_SESSION['co']->cname)."~".trim($_SESSION['co']->addr)."~".$_SESSION['co']->epfno."#".$st."#".$nst;
	}
 
 function exportbills()
 {
 //    echo "xx";exit;
     $path= $_SERVER['DOCUMENT_ROOT'];
     $fdt=$_POST['sdt'];
     $edt=$_POST['edt'];
	$ofname = "bills_".$fdt."_".$edt.".csv";
	$fname = "export/".$ofname;
	$fname=strtolower($fname);
	$_SESSION['dfname']=$fname;
    $st = "select * from billlist where bdate>='".$fdt."' and bdate<='".$edt."'";
  //  echo $st;exit;
 	$con = connect();
 	$sql = $con->prepare($st);
	$sql->execute();
   $file=fopen($fname,"w+");
   $nst="";
 //  echo $st;exit;
   while($row=$sql->fetch())
   {
       $nst=$row['billno']."~".$row['bdate']."~".$row['cname']."~".$row['dtl1']."~".$row['amt1'];
       $nst=$nst."\r\n";
       fwrite($file,$nst);
 
      if($row['amt2']>0){
           $nst=$row['billno']."~".$row['bdate']."~".$row['cname']."~".$row['dtl2']."~".$row['amt2'];
       $nst=$nst."\r\n";
       fwrite($file,$nst);
       }
       if($row['amt3']>0){
           $nst=$row['billno']."~".$row['bdate']."~".$row['cname']."~".$row['dtl3']."~".$row['amt3'];
       $nst=$nst."\r\n";
       fwrite($file,$nst);
         }
      }
 	fclose($file);
	// Read and write for owner, read for everybody else
	chmod($fname, 0644);

	echo $fname;
}

function exportdata()
{ 
	$path= $_SERVER['DOCUMENT_ROOT'];
	$mon = $_POST['mon'];
	$fyyr=$_POST['fyyr'];$cono=$_SESSION['co']->cono;
		if($mon=="Jan" || $mon=="Feb")
			$year=$fyyr+1;
		else
			$year=$fyyr;
	$ofname = $mon.$year."_".$cono.".txt";
	$fname = "export/".$ofname;
	$fname=strtolower($fname);
	$_SESSION['dfname']=$fname;
//	echo $fname;
//	return;
	$st = "select monthly.month, monthly.fyyear, master.pfno, master.sname, monthly.wages, monthly.share1,";
	$st=$st." monthly.pension, monthly.share2, master.fname, master.bdate, master.sex, master.jdate_epf,";
	$st=$st." master.l_date, master.l_reason,master.uanno from master,monthly where master.srno=monthly.srno ";
	$st=$st." and monthly.cono=".$cono." and monthly.month='".$mon."' and monthly.fyyear=".$fyyr;
	$con = connect();
	$sql = $con->prepare($st);
	$sql->execute(array($cono,$mon,$fyyr));
	$n=0;
//	echo $st;
//	return;
	$file = fopen($fname,"w+");
	while($row=$sql->fetch())
	{
		$nst="";
	/*	$nst=$row['pfno']."#~#".$row['sname']."#~#".$row['wages']."#~#".$row['wages']."#~#".$row['share1']."#~#";
		$nst=$nst.$row['share1']."#~#".$row['pension']."#~#".$row['pension']."#~#".$row['share2']."#~#";
		$nst=$nst.$row['share2']."#~#0#~#0#~#0#~#0#~#0#~#0";
		if($mon=="Jan" || $mon=="Feb")
			$year=$fyyr+1;
		else
			$year=$fyyr;
		$dt = date_parse($row['jdate_epf']);
		
		if($dt['month']==monno($mon) && $dt['year']==$year)
		{
			$bdt=new DateTime($row['bdate']);$jdt=new DateTime($row['jdate_epf']);
			$nst=$nst."#~#".$row['fname']."#~#".$row['relationship']."#~#".$bdt->format("d/m/Y")."#~#".$row['sex'];
			$nst=$nst."#~#".$jdt->format("d/m/Y")."#~#".$jdt->format("d/m/Y");
		}
		else
		{
			$nst=$nst."#~##~##~##~##~##~#";
		}
		$dt = date_parse($row['l_date']);
		if($dt['month']==monno($mon) && $dt['year']==$year)	
		{
			$ldt=new DateTime($row['l_date']);
			$nst=$nst."#~#".$ldt->format("d/m/Y")."#~#".$ldt->format("d/m/Y")."#~#".$row['l_reason'];
		}
		else
		{
			$nst=$nst."#~##~##~#";
		}
		$nst=$nst."\r\n";
	*/	
//		echo $nst."*****";
		$pfno=$row['pfno'];
	//	$pfno=($row['uanno']>0)?$row['uanno']:$row['pfno'];	
		 	$nst=$row['uanno']."#~#".$row['sname']."#~#".$row['wages']."#~#".$row['wages']."#~#".$row['wages']."#~#".($row['wages']>15000?15000:$row['wages'])."#~#".$row['share1']."#~#";
		$nst=$nst.$row['pension']."#~#".$row['share2']."#~#0#~#0";
		$nst=$nst."\r\n";

		fwrite($file,$nst);
	}
	fclose($file);
	// Read and write for owner, read for everybody else
	chmod($fname, 0644);

	echo $fname;
//	return;
//header('Location: ftp://'.$fname);
 }

function is_date( $str ) 
{ 
  $stamp = strtotime( $str ); 
  
  if (!is_numeric($stamp)) 
  { 
     return FALSE; 
  } 
  $month = date( 'm', $stamp ); 
  $day   = date( 'd', $stamp ); 
  $year  = date( 'Y', $stamp ); 
  
  if (checkdate($month, $day, $year)) 
  { 
     return TRUE; 
  } 
  
  return FALSE; 
} 

	function sendmail()
	{
		$eid = $_POST['emailid'];
		$content=$_POST['content'];
/*		$mon=$_SESSION['mon'];
//		$st="select `empid`,`password` from `". $fil ."` where `email`like '%".$eid."%'";
//		echo $st;
		if(!($con=connect()))
		{
			echo "Sorry!! Operation Failed!!";
			return;
		}
		if($res=mysql_query($st,$con))
		{
			if(($row=mysql_fetch_array($res)))
			{ */
				$mail = new PHPMailer;

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'svr134.fastwebhost.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'ravikawde@dhawalconsultancy.com';                            // SMTP username
				$mail->Password = 'abcd@1234';                           // SMTP password
				$mail->SMTPSecure = 'SSL';                            // Enable encryption, 'ssl' also accepted

				$mail->From = 'ravikawde@dhawalconsultancy.com';
				$mail->FromName = 'Info';
				$mail->addAddress($eid);  // Add a recipient
				//$mail->addAddress('ellen@example.com');               // Name is optional
				$mail->addReplyTo('ravikawde@dhawalconsultancy.com', 'Info');
				//$mail->addCC('cc@example.com');
				//$mail->addBCC('bcc@example.com');

				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				/*$mail->addAttachment('E:\santosh\Gouri-1.jpg');         // Add attachments
				$mail->addAttachment('demming_dns.jpg', 'new.jpg'); */   // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Info';
				$mail->Body    = 'Your password: <b>'. $row['password'].'</b>';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				   echo 'Message could not be sent.';
				   echo 'Mailer Error: ' . $mail->ErrorInfo;
				   exit;
				}

				echo 'Message has been sent';
	}

	
?>