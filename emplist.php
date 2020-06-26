<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	function seleEmp()
	{
//		alert("1");
		rs= document.getElementById("dlist").rows;
		wind=window.open("form3aO.html");
		doc1 = wind.document;
		cnt=0;
		var i;
		for(i=1;i<rs.length;i++)
		{
			if(document.getElementById("h"+i).checked==true)
			{
//				alert(i);
				vid = "c"+(i-1)+"0";
				vsrno = document.getElementById(vid).innerHTML;
//				alert(vsrno);
				vfyyr = window.parent.document.getElementById("tfyyr").value
				temp="&fyyr="+vfyyr+"&srno="+vsrno
				temp = "n="+Math.random()+temp+"&vcnt=4"
	//		alert(temp);
				xmlhttp.onreadystatechange=printRepo;
				xmlhttp.open("POST","repoajax.php",false);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
				xmlhttp.send(temp); 
			}
		}
		wind.print();
	}

	function seleEmp1()
	{
		
		rs= document.getElementById("dlist").rows;
		//alert(rs);
		cnt=0;
		var i;
		var srnolist;
		srnolist="(0";
		for(i=1;i<rs.length;i++)
		{
			if(document.getElementById("h"+i).checked==true)
			{
				vid = "c"+(i-1)+"0";
//		alert(vid);
				vsrno = document.getElementById(vid).innerHTML;
				srnolist=srnolist+","+vsrno;
			}
		}
		srnolist=srnolist+")";
		
//		vid = "c"+(i-1)+"0";
//		alert(vid);
//		vsrno = document.getElementById(vid).innerHTML;
//		alert(vsrno);
		vfyyr = window.parent.document.getElementById("tfyyr").value
//		alert(vfyyr);
		temp="&fyyr="+vfyyr+"&srnolist="+srnolist
		temp = "n="+Math.random()+temp+"&vcnt="+repono
		xmlhttp.onreadystatechange=showRepo1;
		xmlhttp.open("POST","oreports.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	} 

	function printRepo()
	{
		if(xmlhttp.readyState==4)
		{
			st=xmlhttp.responseText;
			if(st=="-") return;
			cnt++;
			var divid = "div"+cnt;
		
			arr1=st.split("|");
			tst=""
			arr=arr1[0].split("~");
//			var wind2= window.open("form3a.html")
//			var doc = wind2.document;
//			alert(st);
			window.parent.document.getElementById("entrydiv").style.visibility="hidden";
			var doc=window.parent.document.getElementById("forms").contentWindow.document;
//			var vhc1=doc.getElementById("hc1");
//			vhc1.innerHTML=arr[0];
			doc.getElementById("hc1").innerHTML=arr[0];			
			doc.getElementById("hc2").innerHTML=arr[1];			
			doc.getElementById("hc3").innerHTML=arr[2];			
			doc.getElementById("hc4").innerHTML=arr[3];			
			doc.getElementById("hc5").innerHTML=arr[4];			
			doc.getElementById("hc6").innerHTML=arr[5];			
			doc.getElementById("hc7").innerHTML=arr[6]+"%";		
			twages=0;tsh1=0;tsh2=0;tsh3=0;
			for(i=1;i<arr1.length;i++)
			{
				arr=arr1[i].split("~");
				doc.getElementById("c"+arr[0]+"1").innerHTML=arr[1];			
				doc.getElementById("c"+arr[0]+"2").innerHTML=arr[2];			
				doc.getElementById("c"+arr[0]+"3").innerHTML=arr[3];			
				doc.getElementById("c"+arr[0]+"4").innerHTML=arr[4];			
				twages=twages+parseInt(arr[1]);tsh1=tsh1+parseInt(arr[2]);
				tsh2=tsh2+parseInt(arr[3]);tsh3=tsh3+parseInt(arr[4]);
			}	
			
			doc.getElementById("t1").innerHTML=twages;
			doc.getElementById("t2").innerHTML=tsh1;
			doc.getElementById("t3").innerHTML=tsh2;
			doc.getElementById("t4").innerHTML=tsh3;
			doc.getElementById("ccname").innerHTML=doc.getElementById("hc5").innerHTML
			div1 = doc1.getElementById("main");
			ndiv = doc1.createElement('div');
			var stylest="border:#000000 thin solid;width:670px;height:1000px; page-break-after:always; ";		
			ndiv.setAttribute("style",stylest);
			ndiv.innerHTML = doc.getElementById("f3a").innerHTML
			div1.appendChild(ndiv);
//			wind2.close();
		}
	}		
	function showRepo1()
	{
		if(xmlhttp.readyState==4)
		{
			st=xmlhttp.responseText;
			
//			alert(repono);
			window.parent.document.getElementById("entrydiv").style.visibility="hidden";
			var doc=window.parent.document.getElementById("forms").contentWindow.document;
			if(repono==103) //Form 10d3
			{
				tarr=st.split("^");
				st=tarr[1];
				tarr1=tarr[0].split("~");
				doc.getElementById("sname").innerHTML=tarr1[0];
				doc.getElementById("cname").innerHTML="For "+tarr1[1];
			}
			if(repono==114) //Form 10d3
			{
				//alert(st);
				tarr=st.split("^");
				//st=tarr[1];
				tarr1=tarr[0].split("~");
				cname1 = tarr1[0].split("@@");
				doc.getElementById("cname1").value=cname1[1];
			}
			arr2=st.split("|");
			for(j=0;j<arr2.length;j++)
			{
//				alert(arr2[j]);
				arr1=arr2[j].split("~");
				tst=""
				console.log(arr1);
				for(i=0;i<arr1.length;i++)
				{
//					alert(arr1[i]);
						console.log(arr1[i]);
					arr=arr1[i].split("@@");
					//alert(arr[0]+","+arr[1]);
					
					if(repono==103)
					{
						doc.getElementById(arr[0]).innerHTML=arr[1];				
					}
					else
					{
						doc.getElementById(arr[0]).value = arr[1];			
					}
				}	
			}
		}
	}		
	
	function showRepo()
	{
		if(xmlhttp.readyState==4)
		{
			st=xmlhttp.responseText;
			arr1=st.split("|");
			tst="";
			arr=arr1[0].split("~");
			//			alert(st);
			window.parent.document.getElementById("entrydiv").style.visibility="hidden";
			var doc=window.parent.document.getElementById("forms").contentWindow.document;
			doc.getElementById("hc1").innerHTML=arr[0];			
			doc.getElementById("hc2").innerHTML=arr[1];			
			doc.getElementById("hc3").innerHTML=arr[2];			
			doc.getElementById("hc4").innerHTML=arr[3];			
			doc.getElementById("hc5").innerHTML=arr[4];			
			doc.getElementById("hc6").innerHTML=arr[5];			
			doc.getElementById("hc7").innerHTML=arr[6]+"%";		
		twages=0;tsh1=0;tsh2=0;tsh3=0;
		for(i=1;i<arr1.length;i++)
		{
			arr=arr1[i].split("~");
			doc.getElementById("c"+arr[0]+"1").innerHTML=arr[1];			
				doc.getElementById("c"+arr[0]+"2").innerHTML=arr[2];			
				doc.getElementById("c"+arr[0]+"3").innerHTML=arr[3];			
				doc.getElementById("c"+arr[0]+"4").innerHTML=arr[4];			
				twages=twages+parseInt(arr[1]);tsh1=tsh1+parseInt(arr[2]);
				tsh2=tsh2+parseInt(arr[3]);tsh3=tsh3+parseInt(arr[4]);
			}	
			doc.getElementById("t1").innerHTML=twages;
			doc.getElementById("t2").innerHTML=tsh1;
			doc.getElementById("t3").innerHTML=tsh2;
			doc.getElementById("t4").innerHTML=tsh3;
			doc.getElementById("ccname").innerHTML=doc.getElementById("hc5").innerHTML
		}
	}		
	
	
	function chkpgno()
	{
		vpgno=document.getElementById("pgno").value
		if(vpgno<0) vpgno=1
		if(vpgno>1)
		{
			vpgno--;
			document.getElementById("pgno").value=vpgno;
			showlist();
		}
	}
	
	function prevpg()
	{
		vpgno=document.getElementById("pgno").value
		if(vpgno>1)
		{
			vpgno--;
			document.getElementById("pgno").value=vpgno;
			showlist();
		}
	}
	function nextpg()
	{
		ros=document.getElementById("dlist").rows
		if(ros.length>=10)
		{
			vpgno=document.getElementById("pgno").value
			vpgno++;
			document.getElementById("pgno").value=vpgno;
			showlist();
		}	
	} 
	function showlist()
	{
		pg=document.getElementById("pgno").value
		getxmlhttp();
		if(pgno==1)
		{
			recno=1
		}
		else
		{
			recno = (pg-1)*10+1
		}
		temp="&recno="+recno
		temp = "n="+Math.random()+temp+"&vcnt=41"
//		alert(temp)
		xmlhttp.onreadystatechange=showRec;
		xmlhttp.open("POST","repoajax.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(temp); 
	}
function markall()
{
	v=document.getElementById("chkall").value;
	rs= document.getElementById("dlist").rows;
	for(i=1;i<rs.length;i++)
	{
		document.getElementById("h"+i).checked=document.getElementById("chkall").checked;
	}
}
function showRec()
{
	if(xmlhttp.readyState==4)
	{
		st=xmlhttp.responseText;
//		alert(st);
		arr=st.split("|");
		st="<table id='dlist' width='500' border='0' cellpadding='5' cellspacing='0'  style='overflow:scroll;'>"
		
/*		st=st+"<tr><td></td><td colspan='2' style='background-color:#CCCC00'>"
		st=st+"<input type='button' value='<<' id='prev' onclick='prevpg()' />"
		st=st+"<input type='text' size='6' value='1' id='pgno' onchange='chkpgno()' />"
    	st=st+"<input type='button' value='>>' id='next' onclick='nextpg()' /></div></td></tr>" */
		st=st+"<tr style='background-color:#DDFF00'><td width='60px' style='visibility:hidden;'>Sr.No.</td><td class='list_back'><div align='left' class='style1'>Emp. Name &nbsp; <input type='button' value='Print' onclick='seleEmp()'/><input type='button' value='Show' onclick='seleEmp1()'/></div></td>"
		st=st+"<td width='60px' class='list_back'> <div align='center' class='style1'>All &nbsp; <input type='checkbox' id='chkall' value='1' onclick='markall()' /></div></td></tr>"
		for(i=0;i<arr.length;i++)
 		{
			row=arr[i].split("~")
//				alert(row[0])
			if(row[0]=="") continue;
			st=st+"<tr style='background-color:#DDFFFF;min-height:20px;'>"
			st=st+"<td style='visibility:hidden;' id='c"+i+"0' >"+row[0]+"</td>"
//			alert("c"+i+"0");
			
			st=st+"<td id='c"+i+"1' align='left' >"+row[1]+"</td>"
			st=st+"<td id='c"+i+"2'><input type='checkbox' value='1' id='h"+(i+1)+"'</td></tr>"
//			st=st+"<td id='c"+i+"2'><input type='button' value='Select' onclick='seleEmp("+i+")'</td></tr>"

		}
		st=st+"</table>"
//		alert(st);
		document.getElementById("dtls").innerHTML=st		
	}
}
</script>
</head>
<body style="margin:auto"  >
<table width="400px">
    <tr><td  align="center">
    <div  >
    <input type="button" value="<<" id="prev" onclick="prevpg()" />
    <input type="text" size="6" value="1" id="pgno" onchange="chkpgno()" />
    <input type="button" value=">>" id="next" onclick="nextpg()" /> 
    </div>
	</td></tr>	
    <tr><td ><div id="dtls"></div></td></tr>
    </table>
	<script type="text/javascript">
		var wind;
		var doc1;
		var repono;
		repono = <?php echo $_GET['repono']; ?>;
		var cnt=0;
	    showlist();
    </script>
</body>
</html>
