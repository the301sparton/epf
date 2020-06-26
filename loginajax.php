<?php



 session_start(); ?>
<?php include_once('Comp.php');?>

<?php
	$ch=$_POST['vcnt'];
	switch($ch)
	{
		case 1 :
			login();break;
		case 2 :
			logout();break;
		case 3 :
			chkpwd();break;
		case 31 :
			chkUan();break;
		case 4 :
			changepwd();break;
	}
 
	function __autoload($cl)
	{
		include $cl.".php";
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
	function changepwd()
	{
		$opwd=$_POST['opwd'];
		$npwd=$_POST['npwd'];
		if(chkpwd1($opwd)==0)
		{
			if($_SESSION["user"]=="Super User")
			{
				$st="update `susers` set `password`='".$npwd."' where `id`='suravi'";
			}
			else
			{
				$st="update `co` set `password`='".$npwd."' where `cono`=".$_SESSION['co']->cono;
			}
			if(!($con=connect()))
			{
				echo 4;return;
			}
			if(($res=mysql_query($st,$con)))
				echo 0;
			else
				echo 1;
		}
	}
	function chkUan()
	{
		$epfno=$_POST['epfno'];
		if(!($con=connect()))
		{
			echo 0;return;
		}
		$st="select `uanno` from `temp` where `srno`=".$epfno;
		if(($res=mysql_query($st,$con)))
		{
			if(($row=mysql_fetch_array($res)))
			{
				echo $row['uanno'];return;
			}
		}
		echo 0;
	}
	function chkpwd1($pwd)
	{
		if(!($con=connect()))
		{
			echo 4;return;
		}
		if($_SESSION["user"]=="suravi")
		{	$id="suravi"; 
			$st="select `id`,`password` from `susers` where `id` =".$id;
		}
		else
		{	$id=$_SESSION['co']->cono; 
			$st="select `password` from `co` where `cono`=".$id;
		}
		if(($res=mysql_query($st,$con)))
		{
			if(($row=mysql_fetch_array($res)))
			{			
				if(strcmp($pwd,$row['password'])==0)
				{ return 0; }
			}
		}
		return 1;
	}
	function chkpwd()
	{
		$pwd=$_POST['pwd'];
		if(!(isset($_SESSION["user"])))
		{
			echo 3;return;
		}
		echo chkpwd1($pwd);
	}
	
	function login()
	{
		$id = $_POST["id"];
		$pwd = $_POST["pwd"];
		$flag=0;
		if($id=="suravi")
		{
			$st="select `id`,`password` from `susers` where `id` = 'suravi'";
	//		echo $st;exit;
			if(!($con=connect()))
			{
//			    echo "101";exit;
				$flag=-1;
			}
			else if(($res=mysql_query($st,$con)))
			{
//			     print_r($res);exit;
				if(($row=mysql_fetch_array($res)))
				{
	//			    echo $row['0'].",".$row[1];exit;
					if(strcmp($pwd,$row['password'])==0)
					{
						$_SESSION['user']="Super User";
						$flag=1;
					}
				}
			}
		}
		else
		{
			$st="select `cono`,`cname`,`estddate`,`epfno`,`addr`,`phone`,`email`,`epfrate`,`penrate`,`password` from `co` where `cono`=".$id;
			if(!($con=connect()))
			{
				$flag=-1;
			}
			else if(($res=mysql_query($st,$con)))
			{
				if(($row=mysql_fetch_array($res)))
				{
					if(strcmp($pwd,$row['password'])==0)
					{
						$temp=new Comp();
						$temp->cono=$row['cono'];$temp->cname=$row['cname'];$temp->epfrate=$row['epfrate'];
						$temp->penrate=$row['penrate'];$temp->addr=$row['addr'];$temp->estddate=$row['estddate'];
						$temp->epfno=$row['epfno'];
						$temp->email=$row['email'];
						$_SESSION['co']= new Comp();
						$_SESSION['co']=$temp;
						$_SESSION['user']=$temp->cname;
						$flag=2;
					}
				}
			}
		}
		echo $flag;
	}
	function logout()
	{
		unset($_SESSION['co']);
		unset($_SESSION['user']);
	}

							 