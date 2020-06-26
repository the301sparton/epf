<?php



 session_start(); ?>
<?php
	include_once('Comp.php');?>
<?php
//	$_SESSION['cono']=1;
	$cnt = $_POST['vcnt'];
//	echo $cnt;
	function __autoload($cl)
	{
		include $cl.".php";
	}
//	$cono=$_SESSION['co']->cono;
	if($cnt==1)
	{ updatemaster1(); }
	else if($cnt==2)
	{ updatemaster2(); }
	else if($cnt==21)
	{ 	deleteRec();   }
	else if($cnt==3)
	{  chkemp(); 	   }
	else if($cnt==4)
	{	chksrno();     }
	else if($cnt==34 || $cnt==5)
	{	calc();     }
	else if($cnt==31)
	{	listRec();     }
	else if($cnt==32)
	{	saveRec();     }
	else if($cnt==33)
	{	updtMast();     }
	else if($cnt==35)
	{	remdata();     }

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
	function updtMast()
	{
		$cono=$_SESSION['co']->cono;
		$con = connect();
		$st=$_POST['data'];
		$arr=explode("|",$st);
		for($i=0;$i<count($arr);$i++)
		{
			$recs=explode("~",$arr[$i]);
			$st="update `master` set `wages`=".$recs[1].",`share1`=".$recs[2].",`share2`=".$recs[3].",`pension`=".$recs[4] ;
			$st=$st." where srno=".$recs[0];
//			echo $st;
			if(!(mysql_query($st,$con)))
			{
				echo -1;
				return;
			}
		}
		echo 0;
	}
	function remdata()
	{
		$cono=$_SESSION['co']->cono;
		$mon = $_POST['mon'];
		$yr = $_POST['yr'];
//		$monyr=explode("~",$recs[0]);
		if($mon=="Jan" || $mon=="Feb")
			$fyyear=$yr-1;
		else
			$fyyear=$yr;
//		echo $inno;
		$con=connect();
		$st="delete from `monthly` where `cono`=".$cono." and `month`='".$mon."' and `fyyear`=".$fyyear;
		if(!(mysql_query($st,$con)))
		{
			die($st);
			echo '1';
		}	
		else
		{
			echo '0';
		}
	}
	function deleteRec()
	{
		$cono=$_SESSION['co']->cono;
		$srno = $_POST['srno'];
		$st = "delete from master where `srno`=".$srno." and `cono`=".$cno;
//		echo $st;
		if(!(mysql_query($st,$con)))
		{
			die($st);
			echo '1';
		}	
		else
		{
			echo '0';
		}
	}
	function saveRec()
	{
		$cono=$_SESSION['co']->cono;
		$st=$_POST['data'];
		$recs = explode("#",$st);
		$monyr=explode("~",$recs[0]);
		if($monyr[0]=="Jan" || $monyr[0]=="Feb")
			$fyyear=$monyr[1]-1;
		else
			$fyyear=$monyr[1];
		$inno=instno($monyr[0]);
//		echo $inno;
		$con=connect();
		for($i=1;$i<count($recs);$i++)
		{
			$fld = explode("|",$recs[$i]);
			if($fld[0]==0) 
			{
			$st="insert into `monthly`(`srno`,`cono`,`month`,`year`,`fyyear`,`wages`,`share1`,`share2`,`pension`,`instno`) values(";
		$st=$st.$fld[6].",".$cono.",'".$monyr[0]."',".$monyr[1].",".$fyyear.",".$fld[2].",".$fld[3].",".$fld[4].",".$fld[5].",".$inno.")";
			}
			else
			{
		$st="update `monthly` set `wages`=".$fld[2].",`share1`=".$fld[3].",`share2`=".$fld[4].",`pension`=".$fld[5];
				$st=$st." where msrno=".$fld[1];
			}
//			echo $st;
			if(!(mysql_query($st,$con)))
			{
				die($st);
				echo '1';
			}	
			else
			{
				echo '0';
			}
		}
	}
	function lastday($mno,$yr)
	{
		if($mno==4||$mno==6||$mno==9||$mno==11)
		{ return 30; }
		else if($mno!=2)
		{ return 31; }
		else if($yr%4==0)
		{ return 29; }
		else
		{ return 28; }
	}
		
	function listRec()
	{
		$cono=$_SESSION['co']->cono;
		$recno=$_POST['recno']-1;	
		$mon = trim($_POST['mon']);
		$yr = trim($_POST['yr']);
		$con=connect();
		$rst="";
		$sernam = trim($_POST['sernam']);
		if($sernam=='-')
			$sernam="%";
		else
			$sernam=$sernam."%";
		mysql_select_db("vaico112_epf", $con);
		$flag=0;
		if(!(strlen($mon)==0 || strlen($yr)==0)) 
		{
//				echo "1";
//			exit;
//			$ldt= new DateTime();
//			$mno = monno($mon);
			$st= "select `srno`,`pfno`,`sname`,`wages`,`share1`,`share2`,`pension`,`bdate`,`msrno` from monlist";	

			$cond=" where `cono`=".$cono. " and sname like '".$sernam. "' and `month`='".$mon. "' and `year`=".$yr;
			$cond = $cond . " order by `srno` limit ".$recno.",10 " ;
			$flag=1;
		}
		else
		{
			$st = "select `srno`,`pfno`,`sname`,`wages`,`share1`,`share2`,`pension`,`bdate`, 0 as `msrno` from `master` " ;
			$cond=" where `left_job`=0 and `cono`=".$cono . " and sname like '".$sernam. "'  order by `srno` limit ".$recno.",10 ";
		}
		$st=$st . $cond;
//	return;
		if(!($res=mysql_query($st,$con)))
		{ 
			echo "-";
			return;
		}
		$nr1=mysql_num_rows($res);
		if($nr1==0)
		{
			echo 0;
			return;
		}
		$row = mysql_fetch_array($res);
		$srFrom=$row['srno'];			// get 1st srno to disp.
		mysql_data_seek($res,$nr1-1);	// Jump to last row	to get last srno to disp.
		$row=mysql_fetch_array($res);
		$srTo=$row['srno'];
		$rst='';
		mysql_data_seek($res,0); //Jump back to 1st row
		while(($row=mysql_fetch_array($res)))
		{
			$rst = $rst.$row['srno']."~".$row['pfno']."~".$row['sname']."~".$row['wages']."~".$row['share1']."~".$row['share2']."~".$row['pension']."~".$row['bdate']."~".$row['msrno']."~".$flag."|";
		}
		echo $rst;
	}		
	function calc()
	{
		$con=connect();
		$cono=$_SESSION['co']->cono;
		$epfrate = $_SESSION['co']->epfrate;
		$penrate= $_SESSION['co']->penrate;
		$sh1=0;$pen=0;$sh2=0;
		$wages=$_POST['wages'];
		$sh1=round($wages*$epfrate/100,0);
		if($wages>15000)
			$pwages=15000;
		else
			$pwages=$wages;
		$pen = round($pwages*$penrate/100,0);
		$sh2 = $sh1-$pen;

		if(isset($_POST['srno']))
		{
			if(isset($_POST['cdate']))
			{
				$dtarr=date_parse($_POST['cdate']);
				$cmon=$dtarr['month'];$cyr=$dtarr['year'];				
//					$cmon=date("n",$_POST['cdate']);$cyr=date("Y",$_POST['cdate']);
			}
			else
			{
				$cmon=date("n");$cyr=date("Y");
			}
			$st="select `bdate` from master where `srno`=".$_POST['srno'];
//			echo $st;
			if(($res=mysql_query($st,$con)))
			{
				if($row=mysql_fetch_array($res))
				{
					$bdt = strtotime($row['bdate']);
					$bmon=date("n",$bdt);$byr=date("Y",$bdt);
//					echo $cyr .",".$byr;
					if(($cyr-$byr)>58 || (($cyr-$byr)==58 && ($cmon>=$bmon)))
					{
//						echo "QQ";
						$sh2=$sh2+$pen;$pen=0;
					}
				}
			}
		}
		echo($sh1.",".$sh2.",".$pen);
	}
	function chksrno()
	{
		$cono=$_SESSION['co']->cono;
		$srno = $_POST['srno'];
		$from = $_POST['from'];
		$to = $_POST['to'];
		$st="select * from master where srno=".$srno;
		$con=connect();
//		mysql_select_db("vaico112_epf",$con);
		$res=mysql_query($st,$con);
		if(($row=mysql_fetch_array($res)))
		{
			$st="";
			for($i=$from;$i<=$to;$i++)
				$st=$st.$row[$i]."~";
			echo($st);
		}
	}
	function chkemp()
	{
		$cono=$_SESSION['co']->cono;
		$nflds=20;
		$empno = $_POST['empno'];
		$st = "select * from master where cono=".$cono." and empno=".$empno;
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$res=mysql_query($st,$con);
		
		if(($row=mysql_fetch_array($res)))
		{ 
			$st="";
			for($i=0;$i<$nflds;$i++)
				$st=$st.$row[$i]."~";
			echo($st);
		 }
		else
		{ 
			$st = "select max(pfno) as mpfno from master where cono=".$cono;
			$res=mysql_query($st,$con);
			if(($row=mysql_fetch_array($res)))
			{ 
				echo ($row['mpfno'])+1;	
			}
			else
			{
				echo 1;
			}		
		}
	}
				
	function updatemaster2()
	{
		$cono=$_SESSION['co']->cono;
		$nflds=count($_POST)-1;
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$res = mysql_query("describe master",$con);
		$dtype=array();$dvalue=array();
		while($row=mysql_fetch_array($res))
		{
			$dtype[$row[0]]=$row[1];
			$dvalue[$row[0]]=$row[4];
		}
	 	$flds = array_keys($_POST);
		$st="update master set ";
		for($i=1;$i<$nflds-1;$i++)
		{
			if($_POST[$flds[$i]]==NULL)
			{	$_POST[$flds[$i]]=$dvalue[$flds[$i]]; }
			$st=$st.(($i>1)?",":"") .$flds[$i]."=";
			if(substr($dtype[$flds[$i]],0,3)=="INT")
				$st=$st.$_POST[$flds[$i]];
			else
				$st=$st."'".trim($_POST[$flds[$i]])."'";
//				echo $st;
		}
		$st=$st." where srno=".$_POST['srno'];
//		echo $st;
		$n=mysql_query($st,$con);
		echo $n; 
	}

	function updatemaster1()
	{
		$cono=$_SESSION['co']->cono;
		$nflds=count($_POST)-2;
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		
		$res = mysql_query("describe master",$con);
		$dtype=array();$dvalue=array();
		while($row=mysql_fetch_array($res))
		{
			$dtype[$row[0]]=$row[1];
			$dvalue[$row[0]]=$row[4];
		}
	 	$flds = array_keys($_POST);

		$sql = "select srno from master where cono=".$cono." and empno=".$_POST['empno'];
//		echo $sql;
		$res=mysql_query($sql,$con);
		if(!($row = mysql_fetch_array($res)))
		{
			$st = "insert into master(cono";
			for($i=1;$i<=$nflds;$i++)
			{
				$st=$st.",".$flds[$i];
			}
			$st=$st.")values(".$cono;
			for($i=1;$i<=$nflds;$i++)
			{
				if($_POST[$flds[$i]]==NULL)
					$_POST[$flds[$i]]=$dvalue[$flds[$i]];
				if($dtype[$flds[$i]]=="N")
				{	$st=$st.",".$_POST[$flds[$i]];}
				else
				{	$st=$st.",'".trim($_POST[$flds[$i]])."'";}
				
			}
			$st=$st.")";
			if(mysql_query($st,$con)>0)
				echo mysql_insert_id($con);
			else
				echo 0;
//			echo $st;
		}
		else
		{
			$vsrno=$row['srno'];
			$st="update master set empno=".$_POST['empno'];
			for($i=2;$i<$nflds-1;$i++)
			{
				if($_POST[$flds[$i]]==NULL)
				{	$_POST[$flds[$i]]=$dvalue[$flds[$i]]; }
				$st=$st.",".$flds[$i]."=";
				if(substr($dtype[$flds[$i]],0,3)=="INT")
					$st=$st.$_POST[$flds[$i]];
				else
					$st=$st."'".trim($_POST[$flds[$i]])."'";
//				echo $st;
			}
			$st=$st." where srno=".$vsrno;
//			echo $st;
			if(mysql_query($st,$con)>0)
				echo $vsrno;
			else
				echo 0;
		}
	} 
?>