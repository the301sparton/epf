<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../../student/Desktop/epf on Atul-pc/css/css1.css" />
<style type="text/css">
<!--
.tdtitle { background-color: #e5e1d0 ; color:#900; font-weight:bold; height:20px; padding-top:5px; }

.tbl1td1 {height:27px; padding-left:5px;}

.spac
{text-indent:5px;
}

-->
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
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  
		}
	}
	function calc()
	{
		sal = document.getElementById('wages').value
		vsrno=window.parent.vsrno
		temp = "&empno="+vsrno+"&wages="+sal
		getxmlhttp();
		temp = "n="+Math.random()+temp+"&vcnt=5"
//		alert(temp);
		xmlhttp.onreadystatechange=showCalcRes;
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
	function showCalcRes()
	{
		if(xmlhttp.readyState==4)
		{
			arr = xmlhttp.responseText.split(",");
			document.getElementById("share1").value=arr[0];
			document.getElementById("share2").value=arr[1];
			document.getElementById("pension").value=arr[2];
		}
	}
	
	function clearForm()
	{
		n=window.parent.arrflds2.length;
		for(i=0;i<n;i++)
		{
			if(i!=20) document.getElementById(window.parent.arrflds2[i]).value="";
		}
		window.parent.vsrno=0;
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
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
	function saveRec()
	{
		if(window.parent.vsrno==0)
		{
			alert("Start new record from Entry1");
		    window.parent.document.getElementById("call").src="entry1.php"; 
			return;
		}
		getxmlhttp();
		temp=""
		noflds = window.parent.arrflds2.length;
		for(i=0;i<noflds;i++)
		{
	//		alert(window.parent.arrflds2[i]);
			temp = temp + "&"+ window.parent.arrflds2[i]+"="+(document.getElementById(window.parent.arrflds2[i]).value);
		}
		temp=temp+ "&srno="+window.parent.vsrno;
//		alert(temp);
		temp = "n="+Math.random()+temp+"&vcnt=2"
//		alert(temp);
		xmlhttp.onreadystatechange=checkResult;
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
function checkResult()
{
	if(xmlhttp.readyState==4)
	{
	//	alert(xmlhttp.responseText)
		if(parseInt(xmlhttp.responseText)==0)
		{ 	alert("Failed to save the record");}
		else
		{
			window.parent.vsrno=0;
			window.parent.vsrnoStatus=0;
		    window.parent.document.getElementById("call").src="entry1.php"; 
			alert("Record Saved");
		}
	}
}
function showdtls()
{
	if(xmlhttp.readyState==4)
	{
		st=xmlhttp.responseText;
		if(st=='-')
		{
			window.parent.vsrno=0;
			 return;
		}
		arr = st.split("~");
		nflds = window.parent.arrflds2.length;
//		alert(nflds);
		for(i=0;i<nflds;i++)
		{
			document.getElementById(window.parent.arrflds2[i]).value = arr[i];		
		}
	}
}
function copyAddr()
{
	document.getElementById("paddr1").value = document.getElementById("caddr1").value
	document.getElementById("paddr2").value = document.getElementById("caddr2").value
	document.getElementById("ptown").value = document.getElementById("ctown").value
	document.getElementById("pdistt").value = document.getElementById("cdistt").value
	document.getElementById("pstate").value = document.getElementById("cstate").value
	document.getElementById("ppin").value = document.getElementById("cpin").value
}
function showContri()
{
	if(xmlhttp.readyState==4)
	{
		st=xmlhttp.responseText;
//		alert(st);
		arr = st.split(",");
		if(arr[0]>0) document.getElementById("share1").value=arr[0];
		if(arr[1]>0) document.getElementById("share2").value=arr[1];
		if(arr[2]>0) document.getElementById("pension").value=arr[2];
		
	}
}
</script>
</head>
<body  bgcolor="#Ece9de">
<script type="text/javascript">
//	alert(window.parent.vsrno);
	if(window.parent.vsrno>0)
	{
		getxmlhttp();
		temp = "n="+Math.random()+"&srno="+window.parent.vsrno+"&from=22&to=42&vcnt=4"
		xmlhttp.onreadystatechange=showdtls;
		xmlhttp.open("POST","ajaxroutines.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp);
	}
//	alert(window.parent.vsrno);

</script>

<table width="830px" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td colspan="3" scope="row" class="tdtitle">Corresspondace Address</td>
    <td colspan="5" span class="tdtitle" style=" padding-left:15px;"> Permanent Address <span style="color:#000066; padding-left:35px;">Same as Correspondance </span>
        <input type="checkbox" name="same_above" id="same_above2" onclick="copyAddr()" />    </td>
  </tr>
  <tr>
    <td height="120" colspan="3" scope="row"><table width="400" border="0" cellspacing="0" cellpadding="4" style="border:solid 1px #999999">
      <tr>
        <td width="75" height="30" scope="col" valign="bottom">Address1</td>
        <td colspan="3" scope="col" valign="bottom"><input type="text" id="caddr1" name="caddr1" size="45" /></td>
      </tr>
      <tr>
        <td scope="row">Address2</td>
        <td colspan="3"><input type="text" id="caddr2" name="caddr2" size="45" /></td>
      </tr>
      <tr>
        <td scope="row">Town </td>
        <td width="86"><input type="text" size="14" id="ctown" name="ctown"/></td>
        <td width="68"><span class="tbl1td1">District </span></td>
        <td width="150"><input type="text" size="14" id="cdistt" name="cdistt"/></td>
      </tr>
      <tr valign="top">
        <td scope="row" height="30">State</td>
        <td><input type="text" size="14" id="cstate" name="cstate"/></td>
        <td><span class="tbl1td1">PIN :</span></td>
        <td><input type="text" size="14" id="cpin" name="cpin"/></td>
      </tr>
    </table></td>
    <td colspan="5"><table align="right" width="400" border="0" cellspacing="0" cellpadding="4" style="border:solid 1px #999999">
      <tr valign="bottom">
        <td width="68" scope="col" height="30">Address1</td>
        <td colspan="3" scope="col"><input type="text" id="paddr1" name="paddr2" size="45" /></td>
      </tr>
      <tr>
        <td scope="row">Address2</td>
        <td colspan="3"><input type="text" id="paddr2" name="paddr2" size="45" /></td>
      </tr>
      <tr>
        <td scope="row">Town </td>
        <td width="85"><input type="text" size="14" id="ptown" name="ptown"/></td>
        <td width="68"><span class="tbl1td1">District </span></td>
        <td width="147"><input type="text" size="14" id="pdistt" name="pdistt"/></td>
      </tr>
      <tr valign="top">
        <td scope="row" height="30">State</td>
        <td><input type="text" size="14" id="pstate" name="pstate"/></td>
        <td><span class="tbl1td1">PIN :</span></td>
        <td><input type="text" size="14" id="ppin" name="ppin"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="78" height="41px" scope="row"><span class="tbl1td1">E-mail</span></td>
    <td colspan="7"><input type="text" id="email" name="email" size="45" /></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td width="220">&nbsp;</td>
    <td width="115">&nbsp;</td>
    <td width="282">&nbsp;</td>
    <td width="116">&nbsp;</td>
    <td width="19" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" class="tbl1td1" scope="row"><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78" height="36">Wages rate</td>
        <td  width="87"><input type="text" size="14" name="wageRate" id="wageRate" /></td>
        <td width="77" class="spac"> salary</td>
        <td width="150"><input type="text" size="14" name="wages" id="wages" onblur="calc()" /></td>
        <td width="90" class="spac"><span class="btn_color">Off Day</span></td>
        <td width="168"><select name="select" name="offDay" id="offDay">
          <option selected="selected" value="1">Sun</option>
          <option value="2">Mon</option>
          <option value="3">Tue</option>
          <option value="4">Wed</option>
          <option value="5">Thur</option>
          <option value="6">Fri</option>
          <option value="7">sat</option>
        </select>        </td>
      </tr>
    </table>
      <fieldset>
        <legend class="tdtitle">Contribution</legend>
          <table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="67" rowspan="2">Employee share</td>
            <td  width="93" rowspan="2"><input type="text" size="14" name="share1" id="share1" /></td>
            <td width="75" class="spac">Employer</td>
            <td width="162" rowspan="2"><input type="text" size="14" name="share2" id="share2"  /></td>
            <td width="88" rowspan="2">Pension</td>
            <td width="165" rowspan="2"><input type="text" size="14" name="pension" id="pension"  /></td>
          </tr>
          <tr>
            <td class="spac">Share</td>
          </tr>
        </table>
      </fieldset>
        <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="82" height="36" rowspan="2">Left job</td>
        <td width="84" rowspan="2"><input type="text" size="14" name="left_job" id="left_job" /></td>
        <td width="79" class="spac">Leaving</td>
        <td width="158" rowspan="2"><input type="text" size="14" name="l_date" id="l_date"  /></td>
        <td width="88" rowspan="2">Reason</td>
		<td width="159" rowspan="2">
        	 <select name="select" name="l_reason" id="l_reason">
                  <option selected="selected" value="R">RETIREMENT</option>
                  <option value="S">SUPERANNUATION(With pension)</option>
                  <option value="D">DEATH IN SERVICE</option>
                  <option value="P">PERMANENT DISABLEMENT</option>
                  <option value="C">CESSATION(Resigned)</option>
	        </select> </td>
<!--        <td width="159" rowspan="2"><input type="text" size="14" name="l_reason" id="l_reason" /></td>  -->
      </tr>
      <tr>
        <td class="spac"> date</td>
      </tr>
    </table>        </td>
  </tr>
  <tr>
    <td height="10px" colspan="8" class="tbl1td1" scope="row"></td>
  </tr>
  <tr>
    <th colspan="8" scope="row"><div style="float:right">
      <input type="button" value="  Next  " class="btn_color" onclick="saveRec()"  />
      <input type="button" value="  Cancel  " class="btn_color" onclick="clearForm()"  />
      <input type="button" value="  delete  " class="btn_color" onclick="deleteRec()"  />
      <input type="button" value="  Back  " class="btn_color"  />
    </div></th>
  </tr>
</table>
</body>
</html>
