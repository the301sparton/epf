<?php session_start(); ?>

<?php 

	include_once('Comp.php');

?>

<?php

	function __autoload($cl)

	{

		include $cl.".php";

	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="X-UA-Compatible" content="IE=8" />

<title>Dhawal Consultancy Welcomes you..Reports Section</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/css.css" />

<style type="text/css">

<!--

.style3 {color: #E5E1D0}

.frm {

color:#0066CC;

padding:0;

margin:0;

text-indent:15px;

min-height:25px;

width:150px

}

.btn1

{ background:#CCAAFF;

  height:25px;

  width:155px;

  font-weight:700;

  text-align:center;

  vertical-align:middle;

 }

.btn

{ background:#CCDDFF;

  height:25px;

  width:155px;

  font-weight:700;

  text-align:center;

  vertical-align:middle;

 }



.login1

{background: url(images/common_st.jpg) no-repeat;

padding:0; margin:5px 0 0 0; height:30px}

.showdiv {visibility:visible;}

.hidediv {visibility:hidden;}

-->

</style>
<script>
var header_friendly="";
header_friendly='<div id = "prnmsg" style="position: relative; text-align: center; border-bottom: 2px solid black; font-family: verdana; font-size: 11px; padding: 5px; padding-top: 1px; color: darkred"><button style="cursor: pointer" onclick="document.getElementById(\'prnmsg\').style.visibility=\'hidden\';window.print(); parent.document.getElementById(\'ifr_friendly\').style.left=\'-10000px\'">PRINT</button> to print it. Click <button style="cursor: pointer" onclick="parent.document.getElementById(\'ifr_friendly\').style.left=\'-10000px\'">CLOSE</button>  to close this window without printing.<\/div>'
//var header_friendly='<div id = "prnmsg" style="position: relative; text-align: center; border-bottom: 2px solid black; font-family: verdana; font-size: 11px; padding: 5px; padding-top: 1px; color: darkred">This is a printer friendly version of the page. Click <button style="cursor: pointer" onclick="window.print(); parent.document.getElementById(\'ifr_friendly\').style.left=\'-10000px\'">PRINT</button> to print it. Click <button style="cursor: pointer" onclick="parent.document.getElementById(\'ifr_friendly\').style.left=\'-10000px\'">CLOSE</button>  to close this window without printing.<\/div>'
//var header_friendly='<div id = "prnmsg" style="position: relative; text-align: center; border-bottom: 2px solid black; font-family: verdana; font-size: 11px; padding: 5px; padding-top: 1px; color: darkred">This is a printer friendly version of the page. Click <button style="cursor: pointer" onclick="printme();">PRINT</button> to print it. Click <button style="cursor: pointer" onclick="parent.document.getElementById(\'ifr_friendly\').style.left=\'-10000px\'">CLOSE</button>  to close this window without printing.<\/div>'

function printer_friendly(which,left,top,width,height)
{
    document.getElementById("forms").contentWindow.print();
    return;
    do {
    inputs = window.frames["forms"].document.getElementsByTagName("input");
    st="";l=inputs.length;
    if(l==0) break;
        st=inputs[0].value;
        inputs[0].parentElement.innerHTML=st;
    }while (l>0);

	frames['ifr_friendly'].document.body.innerHTML=header_friendly+frames[which].document.body.innerHTML; 
	document.getElementById('ifr_friendly').style.left=left; 
	document.getElementById('ifr_friendly').style.top=top; 
	document.getElementById('ifr_friendly').style.width=width; 
	document.getElementById('ifr_friendly').style.height=height;

}
function emailit(which)
{
	var mailid='<?php echo $_SESSION['co']->email; ?>';
	 mailid = prompt("Enter Email id:",mailid);
	if(mailid.length==0 )
	{
		document.getElementById("msg1").innerHTML="Invalid email id.....";
		return;
	}
	vcontent=header_friendly+frames[which].document.body.innerHTML; 
	getxmlhttp();
	temp="&mailid="+mailid+"&content="+vcontent+"&vcnt=12";
//	alert(temp);
	temp = "n="+Math.random()+temp;
	xmlhttp.onreadystatechange=chkmail;
//		alert(temp);
	xmlhttp.open("POST","repoajx.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(temp); 
	
}


  function chkmail()
  {
  	if(xmlhttp.readyState==4)
	{
		var st1;
		st1=xmlhttp.responseText;
		alert(st1);
	}
  }




</script>
<script type="text/javascript">

var cdt = new Date()

var fyyr= cdt.getFullYear();

var mon="   ";

var xmlhttp;

var showOrepo = 0;

var vrepono;

vrepono=0;

function getxmlhttp()

	{

		if (window.XMLHttpRequest)

		{// code for IE7+, Firefox, Chrome, Opera, Safari

		  xmlhttp=new XMLHttpRequest();

		}

		else
		{

		// code for IE6, IE5

		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  

		}

	}



function getmon()

{

	mon=document.getElementById("tmon").value



}

function getfyyr()

{

	fyr=parseInt(document.getElementById("tfyyr").value)

	if(!isNaN(fyr))

		fyyr=fyr

//	alert(fyyr);

}

function exportmaster()

{

	getmon();getfyyr();

	temp = "";

	getxmlhttp();

	mon=prompt("Enter Month:","Feb");

	yr =prompt("Enter year :",fyyr);

	

	temp = "&mon="+mon+"&yr="+yr

	temp = "n="+Math.random()+temp+"&vcnt=91"

//		alert(temp);

	xmlhttp.onreadystatechange=showmsg;

	xmlhttp.open("POST","repoajax.php",true);

	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

	xmlhttp.send(temp); 

}

function exportdata()

{

	getmon();getfyyr();

	

	temp = "&mon="+mon+"&fyyr="+fyyr

	getxmlhttp();

	temp = "n="+Math.random()+temp+"&vcnt=9"

//		alert(temp);

	xmlhttp.onreadystatechange=showmsg;

	xmlhttp.open("POST","repoajax.php",true);

	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

	xmlhttp.send(temp); 

}

function showmsg()

{

	if(xmlhttp.readyState==4)

	{

		alert(xmlhttp.responseText);

		if(xmlhttp.responseText==-1)

		{	alert("Failed to export");}



		else

		{			

		fname = xmlhttp.responseText;

		st = "<a href='download.php'>Download it</a>";

		document.write(st);

/*		return;

		temp = "&fname="+fname ;

		temp = "n="+Math.random()

		alert(temp);

		xmlhttp.onreadystatechange=showmsg1;

		xmlhttp.open("POST","download.php",true);

		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

		xmlhttp.send(temp); */

		}

	}

}

function showmsg1()

{

	if(xmlhttp.readyState==4)

	{

		alert("hello");

		alert(xmlhttp.responseText);

	}

}





function showrepo(pn)

{

	n = parseInt(pn);

//	alert(n);

	if(n>100)

	{
	 //   alert("a1") 

		document.getElementById("entry").height='450px';  

		document.getElementById("entry").src="emplist.php?repono="+n;

		document.getElementById("entrydiv").style.visibility="visible";

		switch(n)

		{

			case 101 :

				document.getElementById("forms").src="forms/form10d1.html";break;

			case 102 :

				document.getElementById("forms").src="forms/form10d2.html";break;

			case 103 :

				document.getElementById("forms").src="forms/form10d3.html";break;

			case 104 :

				document.getElementById("forms").src="forms/form10c.html";break;

			case 105 :

				document.getElementById("forms").src="forms/form2.html";break;

			case 106 :

				document.getElementById("forms").src="forms/form5if.html";break;

			case 107 :

				document.getElementById("forms").src="forms/form5.html";break;

			case 108 :

				document.getElementById("forms").src="forms/form5only.html";break;

			case 109 :

				document.getElementById("forms").src="forms/form13.html";break;

			case 110 :

				document.getElementById("forms").src="forms/form19.html";break;

			case 1101 :

				document.getElementById("forms").src="forms/form19_new.html";break;

			case 111 :

				document.getElementById("forms").src="forms/form20.html";break;

			case 112 :

				document.getElementById("forms").src="forms/form31.html";break;

			case 113 :

				document.getElementById("forms").src="forms/breakstat.html";break;
			case 114 :

				document.getElementById("forms").src="forms/form20new.html";break;
			case 115 :

				document.getElementById("forms").src="forms/tcform.html";break;
			case 116 :
                alert("a");
				document.getElementById("forms").src="forms/attendance.html";break;

		}

	}

	else

	{

		switch(n)

		{

			case 1 :
	//			alert("A");
				document.getElementById("forms").src="sheet1.htm";break;

			case 2 :

				document.getElementById("forms").src="sheet2.htm";break;

			case 4 :

				document.getElementById("forms").src="sheet3.htm";break;

			case 3 :

				document.getElementById("forms").src="sheet5.htm";

				document.getElementById("entry").height='225px' 

				document.getElementById("entry").src="getChalanData.html";

				document.getElementById("entrydiv").style.visibility = "visible";break;

			case 5 :

				document.getElementById("entry").height='450px';  

				document.getElementById("entry").src="emplist.html";

				document.getElementById("entrydiv").style.visibility="visible";

				document.getElementById("forms").src="form3a.html";

	//			alert("A");

				break;

			case 6 :

				document.getElementById("forms").src="form9.html";break;

			case 7 :

				document.getElementById("forms").src="conciliation.html";break;

			case 8 :

	//			window.parent.location.href='attendance.html';break;
//				alert("a");

				document.getElementById("forms").src="attRegister.htm";break;

			case 9 :
			    window.parent.location.href='uploaddata/uploaddata.php'

		}

	}

}

function showrepo1()

{

	if(window.document.getElementById("orepodiv").style.visibility=="visible")

	{

		window.document.getElementById("orepodiv").style.visibility="hidden";
		window.document.getElementById("orepo").value="Show Xtra Reports";


	}

	else

	{

		window.document.getElementById("orepodiv").style.visibility="visible";

		window.document.getElementById("orepo").value = "Hide Xtra Reports";

	}

}

function printit()

{
  //  alert("X")

	window.document.frames("forms").focus();

	window.document.frames("forms").print();

}

</script>

</head>



<body bgcolor="#205bc8">

<script type="text/javascript">

<?php 
   // echo "test";exit;

	if(!(isset($_SESSION["user"])))

	{

			echo('window.location.href="index.html";');

			

	}

?>

</script>



<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>

    <td colspan="2" class="baner">&nbsp;</td>

  </tr>

  <tr><td colspan="2" align="center"></td></tr>

  <tr><td colspan="2" align="right" >

<iframe src="menu.php" width="900px" height="17px" frameborder="0" class="bck"  scrolling="no"></iframe></td>

  </tr>

  <tr><td colspan="2" align="left" style="color:#FFFFFF" >Welcome <?php echo $_SESSION['co']->cname;?></td></tr>

  <tr><td colspan="2" align="center">

  <iframe id="frm1" class="chpwd1" src="chpwd.html"></iframe></div></td></tr>
  <iframe id="frm2" class="chpwd1" src="getuan.html"></iframe></div></td></tr>



  <tr bgcolor="#ece9de" >

    <td width="194" valign="top"><table width="170px" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:5px 5px 5px 5px">

      <tr>

        <td><img src="images/top-login.png" width="170px" /></td>

      </tr>

      <tr>

        <td class="logmiddle"><div style="margin:0 5px 0 5px; padding:0" >

                      

          <table width="160px" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="92" height="29">Year:</td>

    <td width="88"><input type="text" id="tfyyr" size="6" maxlength="4" onchange="getfyyr()" /></td>

  </tr>

  <tr>

    <td>Month:</td>

    <td><select name="select" id="tmon" onchange="getmon()">

      <option value="Mar">Mar</option>

      <option value="Apr">Apr</option>

      <option value="May">May</option>

      <option value="Jun">Jun</option>

      <option value="Jul">Jul</option>

      <option value="Aug">Aug</option>

      <option value="Sep">Sep</option>

      <option value="Oct">Oct</option>

      <option value="Nov">Nov</option>

      <option value="Dec">Dec</option>

      <option value="Jan" >Jan</option>

      <option value="Feb">Feb</option>

      <option value="Ar1">Arr.1</option>

      <option value="Ar2">Arr.2</option>

      <option value="Ar3">Arr.3</option>

    </select></td>

  </tr>

</table>



          <div style="margin:10px 5px 10px 5px; border-style:solid; border-width:1px; border-color:#999999; width:150px" >

Select your choice          </div>

       

          <hr align="left" />

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(1)" value="Monthly Report" /></div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Export Monthly Data" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="exportdata()" /> </div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Export Master Data" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="exportmaster()" /> </div>

          </div>

         

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Form 12A" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(2)" /></div>

          </div>
        <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.classNme='btn1'" onmouseout="this.className='btn'" onclick="showrepo(1101)" value="Form 19 New" /></div></div>
          

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Chalan" onmouseover="this.className='btn1'" onmouseout="this.className='btn'"  onclick="showrepo(3)"  /></div>

          </div>

          

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Form 6A" onmouseover="this.className='btn1'" onmouseout="this.className='btn'"  onclick="showrepo(4)" /></div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Form 3A" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(5)" /></div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Form 9" onmouseover="this.className='btn1'" onmouseout="this.className='btn'"  onclick="showrepo(6)" /></div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Reconciliation" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(7)" /></div>

          </div>

          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Attendance" onmouseover="this.className='btn1'" onmouseout="this.className='btn'"  onclick="showrepo(8)" /></div>

          </div>
        <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Import Data" onmouseover="this.className='btn1'" onmouseout="this.className='btn'"  onclick="showrepo(9)" /></div>

          </div>
          <div class=" login1">

          <div align="left" class="frm"><input type="button" class="btn" value="Show Xtra Reports" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" id="orepo" onclick="showrepo1()" /></div>

          </div>

     	  <div id="orepodiv" style="visibility:hidden;">	

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(101)" value="Form 10d(1)" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(102)" value="Form 10d(2)" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(103)" value="Form 10d(3)" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(104)" value="Form 10C" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(105)" value="Form 2" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(106)" value="Form 5IF" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(107)" value="Form 5 & 10" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(108)" value="Form 5" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(109)" value="Form 13" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(110)" value="Form 19" /></div></div>
 
        <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.classNme='btn1'" onmouseout="this.className='btn'" onclick="showrepo(1101)" value="Form 19 New" /></div></div>
 
          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(111)" value="Form 20" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(112)" value="Form 31" /></div></div>

          <div class=" login1"><div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(113)" value="Break Stat." /></div></div>
          <div class=" login1">
          	<div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(114)" value="Form 20 New" />
          	</div>
      	  </div>

<div class=" login1">
          	<div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(115)" value="Form 13" />
          	</div>
      	  </div>
<div class=" login1">
          	<div align='center' class="frm"><input type="button" class="btn" onmouseover="this.className='btn1'" onmouseout="this.className='btn'" onclick="showrepo(116)" value="Attendance" />
          	</div>
      	  </div>

		  </div>
       </td>

      </tr>

      <tr>

        <td><img src="images/btl-login.png" width="170px" /></td>

      </tr>

    </table></td>

    <td  width="706" valign="top"><div style="border-style:solid; border-left-color:#CCCCCC;  border-width:1px; border-bottom:none; border-right:none; border-top:none; padding:0; margin:5px 10px 0 0">

      <table width="680px" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:0 0 0 5px; ">

        <tr>

          <td ><img src="images/top.png" /></td>

        </tr>

        <tr>

          <td class="middletd"> 

            <div style="margin:0 20px 0 10px; padding:0; width:650px; height:500px;"  >

            <iframe src="sampleRepo.html" name="forms" width="650px" height="500px" id="forms" allowtransparency="0" frameborder="0"></iframe>
			<iframe id="ifr_friendly" name="ifr_friendly" style="position: absolute; z-index: 10000; background: none repeat scroll 0% 0% white; left: -10000px; border: 1px solid black; top: 5%; width: 90%; height: 90%;"></iframe>

          <div style="left:0px; top:-500px; float:right; position:relative">
	          <input type="button" value="Print" onclick="printer_friendly('forms', '5%', '5%', '90%', '90%')" />
			  <input type="button" value="Email" onclick="emailit('forms')" /> 

          </div>

          <div id="entrydiv" style="visibility:hidden;left:0px; top:-550px; float:left; position:relative">

            <iframe id="entry"  name="entry" src="getChalanData.html" width="630px" height="225px" allowtransparency="0" frameborder="0"; ></iframe>

          </div>

          </td>

        </tr>

        <tr>

          <td><img src="images/bottom.png" /></td>

        </tr>

      </table>

    </div>

    <br /></td><tr><td colspan="2" bgcolor="#205BC8"><p class="site_maint">Site Powered by Vaikuntha Computers</p>    </td>

  </tr>

</table>
			<iframe id="ifr_friendly" name="ifr_friendly" style="position: absolute; z-index: 10000; background: none repeat scroll 0% 0% white; left: -10000px; border: 1px solid black; top: 5%; width: 100%; height: 100%;"></iframe>

<script type="text/javascript">

var vmon = cdt.getMonth()

if(vmon==0) 

	vmon=11;

else

	vmon=vmon-1;

//	alert(vmon)

if(vmon==0 || vmon==1)

{	vmon=vmon+10 }

else

{	vmon=vmon-2 }

//alert(vmon)

tmon.selectedIndex=vmon;

mon=tmon.value;

//alert(mon)

//alert(mon)

if(tmon.selectedIndex==9)

	fyyr=fyyr-1;

document.getElementById("tfyyr").value=fyyr;

// alert(document.getElementById("tmon").value);



</script>



</body>

</html>