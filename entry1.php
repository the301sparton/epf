 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/datepickercontrol.js"></script>
<script type="text/javascript" src="js/jsroutines.js"></script>

<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"> 

<link rel="stylesheet" type="text/css" href="css/css1.css" />
<style>
.tdtitle { background-color: #e5e1d0 ; color:#900; font-weight:bold; height:20px; padding-top:5px; }
.tbl1td1 { height:27px; padding-left:5px;}
</style>
<script type="text/javascript">
	var xmlhttp;
	function getxmlhttp()
	{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}
	else  
	{
	// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  }
	}
	function deleteRec()
	{
		if(window.parent.vsrno==0)
			return;
		getxmlhttp();
		temp=""
		temp=temp+ "&srno="+window.parent.vsrno;
		temp = "n="+Math.random()+temp+"&vcnt=21"
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.onreadystatechange=checkDelResult;
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
     function checkDelResult()
     {
  	if(xmlhttp.readyState==4)
	{
//		alert(xmlhttp.responseText);
		if(xmlhttp.responseText=='0')
		{ 	alert("Deleted Successfully");}
		else
		{
			alert("Failed To Delete");
		}
	}       
         
     }
function saveRec()
{
	errst="";
	if(document.getElementById("empno").value.length==0)
	{
		errst = "Emp.No. cannot be blank.</br>" ;
	}
	if(document.getElementById("pfno").value.length==0)
	{
		errst = errst + "P.F. No. cannot be blank.</br>";
	}
	if(document.getElementById("uanno").value.length==0)	
	{
		errst = errst + "UAN No. cannot be blank.</br>";
	}
	if(document.getElementById("jdate_epf").value.length==0)	
	{
		errst = errst + "Joining date cannot be blank.</br>";
	}
	if(document.getElementById("sname").value.length==0)	
	{
		errst = errst + "Subscriber Name cannot be blank.</br>";
	}
	if(document.getElementById("bdate").value.length==0)	
	{
		errst = errst + "Birth date cannot be blank.</br>";
	}
//	errst="";  //Make it comment when testing is over
	if(errst.length>0)
	{		document.getElementById("errmsg").innerHTML=errst;}
	else
	{
		getxmlhttp();
		temp=""
		noflds = window.parent.arrflds1.length;
		for(i=2;i<noflds;i++)
		{
			if(i==8)
			{	
				temp=temp+"&sex="+((document.getElementById("sexM").checked==true)?'M':'F'); 
			}
			else if(i==11)
			{
				temp=temp+"&relationship="+((document.getElementById("chkhusband").checked==true)?'S':'F'); 		
			
			}
			else if(i==7) 
			{temp = temp + "&"+ window.parent.arrflds1[i]+"="+(document.getElementById(window.parent.arrflds1[i-1]).value); }			
			else
			{
				temp = temp + "&"+ window.parent.arrflds1[i]+"="+(document.getElementById(window.parent.arrflds1[i]).value);}
		}
		temp = "n="+Math.random()+temp+"&vcnt=1"
//		alert(temp);
		xmlhttp.onreadystatechange=checkResult;
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
}	
function checkResult()
{
	if(xmlhttp.readyState==4)
	{
//		alert(xmlhttp.responseText);
		if(xmlhttp.responseText=='0')
		{ 	alert("Failed to save the record");}
		else
		{
			window.parent.vsrno=parseInt(xmlhttp.responseText);
//			alert(window.parent.vsrno);
		    window.parent.document.getElementById("call").src="entry2.php"; 
		}
	}
}
function chkemp(pempno)
{
	vempno=parseInt(pempno);
	if(vempno==0) return;
	getxmlhttp();
	temp = "n="+Math.random()+"&empno="+vempno+"&vcnt=3"
	xmlhttp.onreadystatechange=showdtls;
	xmlhttp.open("POST","ajaxroutines.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(temp);
}
function showdtls()
{
//	alert(xmlhttp.readyState);
	if(xmlhttp.readyState==4)
	{
		st=xmlhttp.responseText;
	//alert(st);
		if(!isNaN(st))
		{
			document.getElementById("pfno").value = st;
		//	document.getElementById("penno").value = st;
			window.parent.vsrno=0;
			return;
		}
		if(st=='-')
		{
			window.parent.vsrno=0;
			 return;
		}
//alert("X1");	
	arr = st.split("~");
		window.parent.vsrno=arr[0];
		nflds = window.parent.arrflds1.length;
		for(i=2;i<nflds;i++)
		{
//alert(i);
			if(i==7) continue;
			if(i==8)
			{
				if(arr[8]=='M')
					document.getElementById("sexM").checked=true;
				else
					document.getElementById("sexF").checked=true;
			}
			else if(i==11)
			{
				if(arr[11]=='F')
					document.getElementById("chkhusband").checked=false;
				else
					document.getElementById("chkhusband").checked=true;
			}
			else
			{	
				document.getElementById(window.parent.arrflds1[i]).value = arr[i];
				
			}
		}
	}
}
function clearForm()
{
	n=window.parent.arrflds1.length;
	for(i=0;i<n;i++)
	{
		if(i==1 || i==7 || i==8 || i==11) continue;
		document.getElementById(window.parent.arrflds1[i]).value="";
	}
	window.parent.vsrno=0;
}
</script>
</head>

<body bgcolor="#Ece9de">
<script type="text/javascript">
	if(window.parent.vsrno>0)
	{
		getxmlhttp();
		temp = "n="+Math.random()+"&srno="+window.parent.vsrno+"&from=0&to=20&vcnt=4"
		xmlhttp.onreadystatechange=showdtls;
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp);
	}
</script>

<!-- Begin For datetimepicker control -->
<input type="hidden" id="DPC_TODAY_TEXT" value="today">
<input type="hidden" id="DPC_BUTTON_TITLE" value="Open calendar...">
<input type="hidden" id="DPC_MONTH_NAMES" value="['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']">
<input type="hidden" id="DPC_DAY_NAMES" value="['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
<!-- end For datetimepicker control -->
<table width="830"  border="0" cellpadding="0" cellspacing="0">
  <tr><td > 
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    
  <input type="hidden" id="srno" name="srno" />
  <table width="815" border="0" >
      <tr>
	 	   <td width="110" class="tbl1td1">Emp.No</td>
 	      <td width="145"><input type="text" id="empno" name="empno" size="20" onblur="chkemp(this.value)" /></td>
       	  <td width="100" class="tbl1td1">P.F. No.</td>
       	  <td width="189"><input type="text" id="pfno" name="pfno" size ="20"/></td>
       	  <td width="102"><span class="tbl1td1">UAN A/c No</span></td>
       	  <td width="143"><input type="text" id="uanno" name="uanno" size="20"/></td>
	   </tr>
	  <tr>
    		<td  class="tbl1td1">AAdhar  No.</td><td><input type="text" id="aadhaarno" name="aadhaarno" size="20" /></td>

 		    <td  class="tbl1td1">Joining Date</td>
		<td ><input type="text" name="jdate_epf" id="jdate_epf" size="10" datepicker="true" datepicker_format="YYYY-MM-DD"><font size="-2">(yyyy-mm-dd)</font> </td>
            
<!-- 		    <td><input type "text"  name="joining_date" id="DPC_joining_date" size="20" /></td> -->
 		    <td><span class="tbl1td1">Sex</span></td>
 		    <td><label>
 		      <input type="radio" name="sex" checked="checked"  id="sexM" value="M" />
 		      Male</label>
              <label>
                <input type="radio" name="sex" id="sexF" value="F" />
            Female</label></td>
  	  </tr>  
  </table>
<tr>
    		<td class="tdtitle">Enter Full Name</td>
  </tr>
  <tr><td>
      <table width="800" border="0" >
        <tr>
        <td class="tbl1td1">Subscriber</td>
        <td ><input type="text" id="sname" name="sname" size="60" onblur="proper(this.id)" /></td>
        <td rowspan="5"><div style="color:#FF0000; text-align:left; vertical-align:top;" id="errmsg"></div></td>
        </tr>
        <tr>
        <td class="tbl1td1">Father/Husband</td>
        <td><input type="text" id="fname" name="fname" size="60" onblur="proper(this.id)"  />
        <span>Is Husband?<input type="checkbox" value="1"  id='chkhusband' /></span>
        </td>
        
        </tr>
        <tr>
        <td class="tbl1td1">Mothers madien</td>
        <td><input type="text" id="mmname" name="mmname" size="60" onblur="proper(this.id)"  /></td>
        </tr>
        <tr>
        <td class="tbl1td1">any other name</td>
        <td><input type="text" id="oname" name="oname" size="60" onblur="proper(this.id)" /></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>(name before marriage in case ladies)</td>
        </tr>
      </table>
  </td></tr>
  <tr>
    <td class="tdtitle">Place and Date Of Birth</td>
  </tr>
  <tr><td >
      <table width="820" >
        <tr>
            <td width="142" class="tbl1td1">Nationality</td>
            <td width="140"><input type="text" id="nationality" name="nationality" size="20" onblur="proper(this.id)"  /></td>
            <td width="97" class="tbl1td1">Birth date</td>
            <td width="196"><input type="text" name="bdate" id="bdate" size="10" datepicker="true" datepicker_format="YYYY-MM-DD">
            <font size="-2">(yyyy-mm-dd)</font></td>
            <td width="77" class="tbl1td1" >Town</td>
            <td width="140"><input type="text" id="btown" name="btown" size="20" onblur="proper(this.id)" /></td>
        </tr>
        <tr>
          <td class="tbl1td1">District</td><td><input type="text" id="bdist" name="bdist" size="20" onblur="proper(this.id)"  /></td>
          <td class="tbl1td1">State</td>
          <td><input type="text" id="bstate" name="bstate" size="20" onblur="proper(this.id)" /></td>
          <td><span class="tbl1td1">Nation</span></td>
          <td><input type="text" id="bnation" name="bnation" size="20" onblur="proper(this.id)"  /></td>
          </tr>
      </table>
  </td></tr>
  <tr>
	<td class="tdtitle">Nominee</td>
  </tr>
  <tr><td>
      <table width="820" border="0">
          <tr>
            <td class="tbl1td1">Full Name</td>
            <td ><input type="text" id="nominee" name="nominee" size="50" onblur="proper(this.id)" /></td>
            <td class="tbl1td1">Relation</td>
            <td><input type="text" id="nomineeRel" name="nomineeRel" size="20" onblur="proper(this.id)" /></td>
          </tr>
     </table>
  </td></tr>
  <tr>
    <td bgcolor="e5e1d0">&nbsp;</td>
  </tr>
  <tr>
    <td ><div style="float:right">
    <input type="button" onclick="saveRec()" name="submit1" value="  Next  " class="btn_color"  /><input type="button" value="  Cancel  " class="btn_color" onclick="clearForm()" /><input type="button" value="  delete  " class="btn_color" onclick="deleteRec()"  /><input type="button" value="  Exit  " class="btn_color"  />
    </div></td></tr>
</table>
</form>
</body>
</html>
