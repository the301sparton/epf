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
	if($cnt==1)
	{ saveRec(); }
	else if($cnt==2)
	{ delRec(); }
	else if($cnt==3)
	{  listRec(); 	   }

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
	function saveRec()
	{
		$cono=$_SESSION['co']->cono;
		$st=$_POST['data'];
		$recs = explode("#",$st);
//		echo $st;
		$st="";
		if ($recs[0]==0)
		{
			$st="insert into paidchalan (`cono`,`month`,`pdate`,`fyyear`,`ac1`,`ac10`,`ac2`,`ac21`,`ac22`) values(";
			$st=$st.$cono.",'".$recs[1]."','".$recs[2]."',".$recs[3].",".$recs[4].",".$recs[5].",".$recs[6].",";
			$st=$st.$recs[7].",".$recs[8].")";
		}
		else
		{
	   	  $st="update paidchalan set `cono`=".$cono.",`month`='".$recs[1]."',`pdate`='".$recs[2]."'";
		  $st=$st.",`fyyear`=".$recs[3].",`ac1`=".$recs[4].",`ac10`=".$recs[5].",`ac2`=".$recs[6];
		  $st=$st.",`ac21`=".$recs[7].",`ac22`=".$recs[8]." where `id`=".$recs[0];
		}
//		echo $st;
		$con=connect();
		mysql_select_db("vaico112_epf", $con);

		if(!(mysql_query($st,$con)))
		{
			die("Failed to save");
			echo '1';
		}	
		else
		{
			echo '0';
		}
	}
	function delRec()
	{
		$vid=$_POST['id'];
		$con=connect();
		$st="delete from paidchalan where `id`=".$vid;
		mysql_select_db("vaico112_epf", $con);

		if(!(mysql_query($st,$con)))
		{
			die();
			echo '1';
		}	
		else
		{
			echo '0';
		}
		
	}
	function listRec()
	{
		$vfyyr=$_POST['fyyr'];
		$cono=$_SESSION['co']->cono;
	
		$st="select * from `paidchalan` where `cono`=".$cono." and `fyyear`=".$vfyyr;
//		echo $st;
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		if(!($res=mysql_query($st,$con)))
		{ 
			echo "-";
			return;
		}
		$st="";
		$n=0;
		while(($row=mysql_fetch_array($res)))
		{
			if($n>0) $st=$st."#";
			$st=$st.$row['pdate']."|".$row['month']."|".$row['ac1']."|".$row['ac10']."|".$row['ac2']."|";
			$st=$st.$row['ac21']."|".$row['ac22']."|".$row['id']."|".$row['fyyear'];
			$n++;
		}
		echo $st;
	}
	