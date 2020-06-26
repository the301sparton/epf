<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<?php
function monno($mon) {
 //   echo $mon;
	$arrmon=array("Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12,"Jan"=>1,"Feb"=>2,"Ar1"=>13,"Ar2"=>14,"Ar3"=>15);
	$mno = $arrmon[$mon];
	return $mno;
}

function convDate($dt) {
    $yr=substr($dt,7,2);
    if($yr>50) {$yr='19'.$yr;} else {$yr='20'.$yr;}
 //   echo substr($dt,3,3);
    $mno = monno(substr($dt,3,3));
   // echo $mno;exit;
    if(strlen($mno)<2) {$mno="0".$mno; }
    $dy = substr($dt,0,2);
    if(strlen($dy)<2) {$dy="0".$dy; }
    $dt=$yr."-".$mno."-".$dy;
    return $dt;
}
?>
<?php
include_once("db.php");
	if(isset($_POST["submit"]))
	{
	    $uopt=$_POST['uopt'];
//	    echo $uopt;
		$filename=$_FILES["file"]["tmp_name"];
//		echo $filename;
		if($_FILES["file"]["size"] > 0)
		{ 		  	
			$file = fopen($filename, "r");
//			echo $uopt;
			if($uopt=='Monthly') {
    			mysql_query("delete from temp1",$con);
    	//		$st= "<table border='1'><tr><th>UAN</th><th>Name</th><th>Salary</th></tr>";
    			$tst="";
    			$st="insert into temp1 (`empno`,`ename`,`salary`) values ";
    			$n=0;
    			while (($lData = fgetcsv($file, 10000, ",")) !== FALSE)
    			{ 	
    	//			$tst=$tst."<tr><td>".$ldata[0]."</td><td>".$ldata[1]."</td><td>".$ldata[2]."</td></tr>";
    				if($n>0) {
    				$tst=$tst.","; }
    				$n++;
    				$tst=$tst."(".$lData[0].",'".$lData[1]."',".$lData[2].")";
    			}	
    			$st=$st.$tst;
    			if(!(mysql_query($st,$con)))
    			{
    				die($st);
    				echo 'Unable to upload the data';
    			}	
    			else
    			{
    				$st="select * from temp1";
    				if(!($res=mysql_query($st,$con)))
    				{ 
    					echo "-";
    					return;
    				}
    				$st= '<div id="datatbl"><form action="uploadMonthly2.php" method="post" name="upload_excel">';
    				$st=$st.'<span>Year <input type="text" id="tyear" name="tyear" size="5" /><span>month<select name="month"';
    				$st=$st.'id="month" name="month"><option>January</option><option>February</option><option>March</option>';
    				$st=$st.'<option>April</option><option>May</option><option>June</option><option>July</option>';
    				$st=$st.'<option>August</option><option>September</option><option>October</option>';
    				$st=$st.'<option>November</option><option>December</option></select></span>';
    				$st=$st.'<span>Co. No.<input type="text" id="cono" name="cono" size="5"/><input type="submit" value="Save"/></form></br/><br/>';
    				$tst="";
    				$tst=$tst."<table border='1'><tr><th>Sr.No.</th><th>UAN</th><th>Name</th><th>Salary</th></tr>";
    				$n=0;
    				while(($row=mysql_fetch_array($res))) {
    					$n++;
    					$tst=$tst."<tr><td>".$n."</td><td>".$row['empno']."</td><td>".$row['ename']."</td><td>".$row['salary']."</td></tr>";
    				}
    				$tst=$tst."</table>";
    				echo $st;echo $tst;
    			}
			}
		else {
 //   			echo "2";
  			mysql_query("delete from temp2",$con);
    	//		$st= "<table border='1'><tr><th>Emp.No.</th><th>Name</th><th>Salary</th></tr>";
    			$tst="";
    			$st="insert into temp2 (`uanno`,`sname`,`sex`,`bdate`,`jdate_epf`,`fname`,`relationship`,`email`,`aadhaarno`) values ";
    			$n=0;
    			while (($lData = fgetcsv($file, 10000, ",")) !== FALSE)
    			{ 	
    	//			$tst=$tst."<tr><td>".$ldata[0]."</td><td>".$ldata[1]."</td><td>".$ldata[2]."</td></tr>";
    				if($n>0) {
    				$tst=$tst.","; }
    				$n++;
    				$lData[4]=convDate($lData[4]);
 //   				echo $lData[4];
    				$lData[5]=convDate($lData[5]);
    				$lData[3]=substr($lData[3],0,1);
    				$lData[7]=substr($lData[7],0,1);
    			//	echo $lData[7];
    				
    				$tst=$tst."(".$lData[0].",'".$lData[2]."','".$lData[3]."','".$lData[4]."','".$lData[5]."','".$lData[6]."','".$lData[7]."','".$lData[10]."','".$lData[11]."')";
    			}	
    			$st=$st.$tst;
    			if(!(mysql_query($st,$con)))
    			{
    				die($st);
    				echo 'Unable to upload the data';
    			}	
    			else
    			{
    				$st="select * from temp2";
    				if(!($res=mysql_query($st,$con)))
    				{ 
    					echo "-";
    					return;
    				}
    				$st= '<div id="datatbl"><form action="uploadMaster.php" method="post" name="upload_excel">';
   				$st=$st.'<span>Co. No.<input type="text" id="cono" name="cono" size="5"/><input type="submit" value="Save"/></form></br/><br/>';
    				$tst="";
    				$tst=$tst."<table border='1'><tr><th>Sr.No.</th><th>UAN No.</th><th>Name</th><th>Sex</th><th>B.Date</th><th>J.Date</th><th>F.Name</th><th>Rel.</th>";
    				$tst=$tst."<th>Email</th><th>Adhar No.</th></tr>";
    				$n=0;
    				while(($row=mysql_fetch_array($res))) {
    					$n++;
    					$tst=$tst."<tr><td>".$n."</td><td>".$row['uanno']."</td><td>".$row['sname']."</td><td>".$row['sex']."</td><td>".$row['bdate']."</td>";
    					$tst=$tst."<td>".$row['jdate_epf']."</td><td>".$row['fname']."</td><td>".$row['relationship']."</td><td>".$row['email']."</td><td>".$row['aadhaarno']."</td></tr>";
    				}
    				$tst=$tst."</table>";
    				echo $st;echo $tst;
    			}
			}		    
	}
	else {
	echo "File is invalid";return;
	}
	}
			
?>