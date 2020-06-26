<?php



 session_start(); ?>
<?php
	$cnt = $_GET['vcnt'];
	
	if($cnt==1)
	  echo "<script type='text/javascript'>alert('1')</script>";
	{ updatemaster1(); }
	else if($cnt==2)
	{ updatemaster2(); }
	else if($cnt==2)
	{ gettos();}
	else if($cnt==3)
	{ gettime(); }
	else if($cnt==6)
	{ chklogin(); }
	else if($cnt==7)
	{	showlist();}
	else if($cnt==8)
	{	showrepo1();}
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
	function updatemaster1()
	{
		$nflds=15;
		$con=connect();
		mysql_select_db("epf", $con);
		$res = mysql_query("describe master",$con);
		while($row=mysql_fetch_array($res))
		{
			$dtype[$row[0]]=$row[1];
			$dvalue[$row[0]]=$row[4];
		}
	 	$flds = array_keys($_GET);
		$sql = "select srno from master where cono=".$_SESSION['cono']." and empno=".$_GET['empno'];
		$res=mysql_query($sql,$con);
		if($res==NULL)
		{
			$st = "insert into master(cono"
			for($i=1;$i<$nflds;$i++)
			{
				$st=$st.",".$fld[$i];
			}
			$st=$st.")values(".$_SESSION['cono']
			for($i=1;$i<$nflds;$i++)
			{
				if($_GET[$fld[$i]]==NULL)
					$_GET[$fld[$i]]=$dvalue[$fld[$i]];
				if($dtype[$fld[$i]]=="N")
					$st=$st.",".$_GET[$fld[$i]];
				else
					$st=$st.",'".trim($_GET[$fld[$i]])."'";
				
			}
			$st=$st.")";
		}
		else
		{
			$row=mysql_fetch_array($res);
			vsrno=$row['srno'];
			$st="update master set "
			for($i=1;$i<$nflds;$i++)
			{
				
				if($_GET[$fld[$i]]==NULL)
					$_GET[$fld[$i]]=$dvalue[$fld[$i]];
				$st=$st.$_GET[$fld[$i]]."="
				if($dtype[$fld[$i]]=="N")
					$st=$st.$_GET[$fld[$i]];
				else
					$st=$st."'".trim($_GET[$fld[$i]])."'";
			}
			$st=$st." where srno=".vsrno
		}
		$n=mysql_query($st,$con);					
	}
	
	
	function showrepo1()
	{
		$dfrom=$_GET['dfrom'];
		$dto=$_GET['dto'];
		$con=connect();
		$st ="select * from `reslist1` where `tdate`>='".$dfrom."' and `tdate`<='".$dto."' and memid=".$_SESSION['$s_id'];
//		echo $st;
		$res = mysql_query($st);
		if($res!=NULL)
		{
			$st="<table border='1'>";
 			$st=$st. "<tr><th>S.N.</th><th>Bus Id.</th><th>Source</th><th>Destination</th><th>Fair</th><th>Date</th><th>Seat No.</th></tr>";
			$n=0;
			$tot=0;
			while(($row=mysql_fetch_array($res)))
			{
				$n++;
				$st=$st."<tr><td>".$n."</td><td>".$row['busid']."</td><td>".$row['from']."</td><td>".$row['to']."</td>";
				$st=$st."<td>".$row['fair']."</td><td>".$row['tdate']."</td><td align='center'>".$row['seatno']."</td></tr>";
				$tot=$tot + $row['fair'];
			}	
			$st=$st. "<tr><td colspan=7 align='center' >Total Fair=Rs.".$tot."</td></tr>";
			$st=$st."<tr><td colspan=7 align='center'><a href='report1.php'>Back</a></td></tr>";
			$st=$st."</table>";
			echo $st; 
		}
	}
 	function showlist()
 	{
 		$con=connect();
		$st = "select mname,cperson,loginid,memid,address,phone,emailid,password,role from members";
		
		$res = mysql_query($st);
		$st="<table border='1'>";
 		$st=$st. "<tr><th>edit</th><th>Member</th><th>Contact Person</th><th>Login Id</th></tr>";
		$n=0;
 		while($row=mysql_fetch_array($res))
		{
			$n++;
			$st=$st."<tr><td><input type='button' value='Edit' onclick='show(".$n.")' \></td>";
			$m=0;
			for($i=0;$i<9;$i++)
			{
				$m++;
				
				if($m<4)
				{	$st	=$st."<td id='f".$m.$n."'>".$row[$i]."</td>";}
				else
				{	$st	=$st."<td id='f".$m.$n."' style=' display:none;' >".$row[$i]."</td>";}
			}
			$st=$st."</tr>";
		}	
		$st = $st."</table>";
		echo $st;
	}
	function chklogin()
	{
		$vlogin=$_GET['vlogin'];
		$con = connect();
		$st = "select `loginid` from `members` where `loginid`='".$vlogin."'";
//		echo $st;
		$res = mysql_query($st);
		if($row=mysql_fetch_array($res))
		{
			echo "Already Used";
		}
		else
		{
			echo "Available";
		} 
	}
	
	
	function getreslist()
	{
		$dt = $_GET['dt'];
		$busid=$_GET['busid'];
		$con=connect();
		$st = "select `seatno` from `reserve` where `tdate`='".$dt."' and `busid`=".$busid ;
		$res = mysql_query($st);
		$reslist="";
		$flag=0;
		while(($row = mysql_fetch_array($res)))
		{
			if($flag==0)
			{
				$reslist=$reslist.$row['seatno'];
				$flag=1;
			}
			else
			{
				$reslist=$reslist.','.$row['seatno'];
			}
		}
		echo $reslist;
	}
	function resseats()
	{
//		echo "qq";
		$dt = $_GET['dt'];
		$busid=$_GET['busid'];
		$slist = $_GET['slist'];
		$arr = explode(",",$slist);
		//	if(count($arr)==0) return;
		$con=connect();
		$st = "INSERT INTO `travels`.`reserve`(`tdate` ,`busid` ,`memid` ,`seatno` ) VALUES ";
		for($i=0;$i<count($arr);$i++)
		{
			if($i>0) $st=$st.",";
			$st=$st."('".$dt."','".$busid."','".$_SESSION['$s_id']."','".$arr[$i]."')";
		}
		mysql_query($st);
		mysql_close($con);
		echo $st; 
	}
	
	function gettos()
	{
//		echo $from;
	    $from = $_GET['vfrom'];
		$con = connect();
		$st = "select distinct `to` from `buses` where `from`='".$from."'" ;
		
		$res = mysql_query($st);
		$tost="";
		while(($row = mysql_fetch_array($res)))
		{
			$tost= $tost . "<option value='".$row['to']."'>".$row['to']."</option>";
		}
		echo $tost; 
	}	
	function gettime()
	{
		$from = $_GET['vfrom'];
		$to = $_GET['vto'];
		$con = connect();
		$st = "select `busid`,`dtime` from `buses` where `from`='".$from."' and `to`='".$to."'" ;
		$res = mysql_query($st);
		$dtimest="";
		while(($row = mysql_fetch_array($res)))
		{
			$dtimest= $dtimest . "<option value='".$row['busid']."'>".$row['dtime']."</option>";
		}
		echo $dtimest;
	} 
?>