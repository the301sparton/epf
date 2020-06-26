<?php session_start(); ?>
<?php
include_once("Comp.php");
?>
<?php
	$cnt = $_POST['vcnt'];
	
	if($cnt==1)
	{ loadCoList(); }
	else if($cnt==2)
	{ getCo($cnt);		}
	else if($cnt==3)
	{ saveCo();		}
	else if($cnt==4)
	{ getCo($cnt);		}
	else if($cnt==5)
	{ delco();}
	else if($cnt==6)
	{  saveBill();}
	else if($cnt==7)
	{  delbill();	   }
	else if($cnt==8)
	{  listbill();   }

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
	function listbill()
	{
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$cono = $_POST['cono'];
		$st="select billid,billno,bdate,amt1,amt2,amt3,dtl3,dtl2,dtl1,remark from bill where cono=" .$cono;
		$st=$st. " ORDER BY `bdate` DESC ";
		if(!($res=mysql_query($st,$con)))
		{
			echo -1;
			return;
		}
		$st="";
		$n=0;
		while($row=mysql_fetch_array($res))
		{
			if($n==0)
			{
				$st=$st.$row['billid']."~".$row['billno']."~".$row['bdate']."~".$row['amt1']."~".$row['amt2']."~".$row['amt3']."~".$row['dtl1']."~".$row['dtl2']."~".$row['dtl3']."~".$row['remark'];
				$n=1;
			}
			else
			{
				$st=$st."|".$row['billid']."~".$row['billno']."~".$row['bdate']."~".$row['amt1']."~".$row['amt2']."~".$row['amt3']."~".$row['dtl1']."~".$row['dtl2']."~".$row['dtl3']."~".$row['remark'];
			}
		}
		echo $st;
	}
	function delbill()
	{
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$billid=$_POST['billid'];
		$st="delete from bill where billid=".$billid;	
		if(mysql_query($st,$con))
				echo 0;
			else
				echo -1;	
	}
		
	function saveBill()
	{
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$cono=$_POST['cono'];
		$billid=$_POST['billid'];
		$dtl1="Service Charges";$dtl2="Consultancy Charges";
		$ch1=$_POST['ch1'];$ch2=$_POST['ch2'];$ch3=$_POST['ch3'];		
		$dtstr = $_POST['dt'];
		$dt= strtotime($dtstr);
		if(date("m",$dt)<4)
		{
			$byr=date("Y",$dt)-1;
		}
		else
		{
		$byr=date("Y",$dt);
		}
		$fdt=$byr."-04-01";
		$dtl3=$_POST['dtl3'];
		$dtl2=$_POST['dtl2'];
		$dtl1=$_POST['dtl1'];
		$rem=$_POST['rem'];
		if($billid>0)
		{
			$st="update bill set bdate='".$dtstr."',cono=".$cono.",amt1=".$ch1.",amt2=".$ch2.",amt3=".$ch3;
			$st=$st.",dtl1='".$dtl1."',dtl2='".$dtl2."',dtl3='".dtl3."',remark='".$rem."' "." where billid=".$billid;
		}
		else
		{
			$mbillno=1;
			
			$st = "select max(billno) as mbillno from bill where `bdate`>='".$fdt . "'";
			if(!($res=mysql_query($st,$con)))
			{
				$mbillno = 1;
			}
			else
			{
				$row=mysql_fetch_array($res);
				$mbillno = (($row['mbillno']==NULL)?0:$row['mbillno'])+1;		
			}
			$st="insert into bill (bdate,cono,billno,dtl1,dtl2,dtl3,amt1,amt2,amt3,remark) values('";
			$st=$st.$dtstr."',".$cono.",".$mbillno.",'".$dtl1."','".$dtl2."','".$dtl3."',".$ch1.",".$ch2.",".$ch3.",'".$rem."')";
		}
//		echo $st;
		if(mysql_query($st,$con))
			echo 0;
		else
			{echo -1;return;}
	}
	function saveCo()
	{
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		$cono=$_POST['cono'];
		$st="select cono from co where cono=".$cono . " and `delflag`=0";
//		echo $st;
		if(!($res=mysql_query($st,$con)))
		{
			echo "-1";
			return ;
		}
		if(($row=mysql_fetch_array($res)))
		{
			$st="update co set cname='".$_POST['cname']."',addr='".$_POST['addr']."',epfno='".$_POST['epfno']."',ESIC='".$_POST['ESIC']."',";
			$st=$st."phone='".$_POST['phone']."',"."email='".$_POST['email']."',estddate='".$_POST['estddate']."',";
			$st=$st."epfrate=".$_POST['epfrate'].",penrate=".$_POST['penrate']." where cono=".$cono;
			if(mysql_query($st,$con))
				echo 0;
			else
				{echo -1;return;}
		}
		else
		{
			$arr1 = range('a','z');
			$arr2=range('0','9');
			$arr3=array('@','#','$','%','&','*','?','!');
			$arr=array_merge($arr1,$arr2,$arr3);	
			shuffle($arr);
			$pwd=$arr[0].$arr[1].$arr[2].$arr[3].$arr[4].$arr[5];
			
			$st="insert into co (cname,addr,phone,email,epfno,ESIC,estddate,epfrate,penrate,password) values (";
			$st=$st."'".$_POST['cname']."','".$_POST['addr']."','".$_POST['phone']."','".$_POST['email']."','";
			$st=$st. $_POST['epfno']."','".$_POST['ESIC']."','".$_POST['estddate']."',".$_POST['epfrate'].",".$_POST['penrate'].",'".$pwd."')";
			if(mysql_query($st,$con))
			{	echo 0;$cono= mysql_insert_id($con); }
			else
			{echo -1; return;}
		}
		$odtls=$_POST['odtls'];
//		echo $odtls;
		$arr=explode("|",$odtls);
		for($i=0;$i<count($arr);$i++)	
		{
			$arrt=explode("~",$arr[$i]);
			if(strlen(trim($arrt[1]))>0)
			{
				if($arrt[0]>0)
				{
	 			  $st="update `partners` set `pname`='".$arrt[1]."', `designation`='".$arrt[2]."' where `pid`=".$arrt[0];
				}
				else
				{
				  $st="insert into `partners` (`cono`,`pname`,`designation`) values (".$cono.",'".$arrt[1]."','".$arrt[2]."')";
				}
//				echo $st;
				mysql_query($st,$con);
			}
			else
			{
				if(strlen(trim($arrt[0]))>0)
				{
					$st="delete from `partners` where `pid`=".$arrt[0];
					mysql_query($st,$con);
				}
			}
		}
	}
	function delco()
	{
		$cono=$_POST['cono'];
		$pwd = $_POST['pwd'];
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		if($_SESSION["user"]=="Super User")
		{	$id="suravi"; 
			$st="select `password` from `susers` where `id` ='".$id."'";
			if(!($res=mysql_query($st,$con)))
			{
				echo -2;
				return;
			}
			else 
			{
				if(!($row=mysql_fetch_array($res)))
				{
					echo -3;
					return;
				}	
							
			}
			if($row['password']==$pwd)
			{
				$st = "update `co` set `delflag`=1 where `cono`=".$cono;
				if(mysql_query($st,$con))
					echo 0;
				else
					{echo -4;}
			}
			else
			{	echo -5; }
		}
		else
		{	echo -1 ; }
	}
	function getCo($cnt)
	{
		$cono=$_POST['cono'];
		$st="select `cono`,`cname`,`addr`,`epfno`,`ESIC`,`epfrate`,`penrate`,`estddate`,`phone`,`email` from `co` where `cono`=".$cono ." and `delflag`=0";
		$con=connect();
		mysql_select_db("vaico112_epf", $con);
		if(!($res=mysql_query($st,$con)))
		{
			echo -1;
			return;
		}
		else 
		{
			if(!($row=mysql_fetch_array($res)))
			{
				echo -1;
				return;
			}	
			if($cnt==2)
			{
				function __autoload($cl)
				{
					include $cl.".php";
				}
				$temp=new Comp();
				$temp->cono=$row['cono'];$temp->cname=$row['cname'];$temp->epfrate=$row['epfrate'];
				$temp->penrate=$row['penrate'];$temp->addr=$row['addr'];$temp->estddate=$row['estddate'];
				$temp->epfno=$row['epfno'];$temp->esic=$row['ESIC'];
				$_SESSION['co']= new Comp();
				$_SESSION['co']=$temp;
				echo 0;
			}
			else
			{
				$temp=$row['cono']."~".$row['cname']."~".$row['addr']."~".$row['phone']."~".$row['email'];
				$temp=$temp."~".$row['estddate']."~".$row['epfno']."~".$row['ESIC']."~".$row['epfrate']."~".$row['penrate'];
				$st="select `pid`,`pname`,`designation` from `partners` where `cono`=".$row['cono'];
				if(($res=mysql_query($st,$con)))
				{
					$odtls="";$n=0;
					while($row=mysql_fetch_array($res))
					{
						$odtls=$odtls."|".$row['pid']."~".$row['pname']."~".$row['designation'];
					}
					$temp=$temp.$odtls;
				}				
				echo $temp;
			}
		}
	}
	
//"select cono,coname,estddate,epfno,addr,epfrate,email,epfrate,penrate,password from co "	
	function loadCoList()
	{		
		$conam=trim($_POST['conam'])."%";	
		$recno=$_POST['recno']-1;
		$st="select `cono`,`cname`,`epfno`,`ESIC`,`password` from `co` where `delflag`=0 ";
		$st=$st." and `cname` like '".$conam."' limit ".$recno.", 10";
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
		while($row=mysql_fetch_array($res))
		{
			if($n==0)
			{
				$st=$st.$row['cono']."~".$row['cname']."~".$row['epfno']."~".$row['ESIC']."~".$row['password'];
				$n=1;
			}
			else
			{
				$st=$st."|".$row['cono']."~".$row['cname']."~".$row['epfno']."~".$row['ESIC']."~".$row['password'];
			}
		}
		echo $st;
	}

?>
