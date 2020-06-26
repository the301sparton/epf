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
		$filename=$_FILES["file"]["tmp_name"];
//		echo $filename;
		if($_FILES["file"]["size"] > 0)
		{ 		  	
			$file = fopen($filename, "r");
			mysql_query("delete from temp3",$con);
			$tst="";
			$st="insert into temp3(`id`,`srno`,`cono`,`month`,`year`,`fyyear`,";
			for($i=1;$i<=31;$i++){
				$st.="d{$i}".",";
			}
			$st.="wages,pf,esic) values ";
    		$n=0;
			$tst="";
			$mon=0;$yr=0;
    		while (($lData = fgetcsv($file, 10000, ",")) !== FALSE)
    		{ 	
				if($n>0) {
					$mon=$lData[3];$yr=$lData[4];
				$tst=$tst.","; } 
				$n++; 
				$tst=$tst."(";
				for($j=0;$j<40;$j++){
					if($j>5 && $j<36){
						$tst=$tst."'".$lData[$j]."'".(($j<39)?",":""); 
					} else {
						$tst=$tst.$lData[$j].(($j<39)?",":""); 
					}
				}
				$tst=$tst.")"; 
			}	
			
//			print_r($tst);exit;
			$st=$st.$tst;
//			print_r($st);exit;
			if(!(mysql_query($st,$con)))
			{
				echo 'Unable to upload the data';
				die($st);
				return;

			}
			$st = "delete from attendance where `month`=".$mon." and `year`=".$yr;
			mysql_query($st,$con);
			
			$st1="insert into attendance (`srno`,`cono`,`month`,`year`,`fyyear`,";
			$st2 = " select `srno`,`cono`,`month`,`year`,`fyyear`,";
			for($i=1;$i<=31;$i++){
				$st1.="d{$i}".",";
				$st2.="d{$i}".",";
			}
			$st1.="wages,pf,esic)  ";
			$st2.="wages,pf,esic from temp3";
			$st1 = $st1 . $st2;
			mysql_query($st1,$con);
			?>
			<script>
			document.getElementById("forms").src="../attRegister.html";
			</script>
			<?php
    			
		}
	}
			
?>