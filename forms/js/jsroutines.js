// JavaScript Document
	function chknum(str)
	{
		if (isNaN(str))
			alert("Invalid data");
	}
function alltrim(str)
	{
		return str.replace(/^\s+|\s+$/g, '');
	}
	function proper(id) 
	{
		st = alltrim(document.getElementById(id).value);
        document.getElementById(id).value= st.toLowerCase().replace(/\b[a-z]/g, cnvrt);
        function cnvrt() 
		{
            return arguments[0].toUpperCase();
        }
    }
function trim(stringToTrim) 
{
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
	
/*	function fn1(id)
	{
		document.getElementById(id).className="menu2";
	//	this.class="menu2";
	}
	function fn2(id)
	{
		document.getElementById(id).className="menu1";
	}
	function start1()
	{
		$("#btn1").fadeOut(1000);
		$("#divn3").slideUp(4000,function()
		{
			$("#divn1").fadeOut(10000);
			$("#maindiv").fadeOut(10000,function(){
			gotopg("index1.php");})
						
		})
	}
	function gotopg(pg)
	{
		window.location.href("index.php?pg="+pg);
	}
	function saverow(n,opt)
	{
		st = "index.php?pg=3"
		vtid="t"+n+3;
		st = st + "&updtstatus="+opt+"&hall="+document.getElementById(vtid).value;
		vtid="t"+n+4;
		st = st + "&showno="+document.getElementById(vtid).value;
		vtid="t"+n+5;
		st = st + "&movie="+document.getElementById(vtid).value;
		vtid="t"+n+6;
		st = st + "&details="+document.getElementById(vtid).value;
		vtid="t"+n+7;
		st = st + "&stime="+document.getElementById(vtid).value;
		st = st + "&num="+Math.random();
		location.href=st;
	}
	function editrow(n)
	{
		vid="c"+n+"1"
		document.getElementById(vid).innerHTML="<input type='button' value='Update' onclick='saverow("+n+",2)'>"
		vid="c"+n+"2"
		document.getElementById(vid).innerHTML="<input type='button' value='Reset' onclick='reset()'>"
		for(i=3;i<=7;i++)
		{
			vid="c"+n+i;vtid="t"+n+i;st=document.getElementById(vid).innerHTML;
			if(i<5)
			{
				document.getElementById(vid).innerHTML="<input type='text' size='4' disabled='disabled' id='"+vtid+"' value='"+st+"'>"
			}
			else
			{
				document.getElementById(vid).innerHTML="<input type='text' id='"+vtid+"' value='"+st+"'>"
			}
		}
	}
	function delrow(n)
	{
		st = "index.php?pg=3"
		vtid="c"+n+3;
		st = st + "&updtstatus=3&hall="+document.getElementById(vtid).innerHTML;
		vtid="c"+n+4;
		st = st + "&showno="+document.getElementById(vtid).innerHTML;
		location.href=st;
	}
	
	function clearrow(n)
	{
		vtid="t"+n+3;
		document.getElementById(vtid).value="";
		vtid="t"+n+4;
		document.getElementById(vtid).value="";
		vtid="t"+n+5;
		document.getElementById(vtid).value="";
		vtid="t"+n+6;
		document.getElementById(vtid).value="";
		vtid="t"+n+7;
		document.getElementById(vtid).value="";
	}
	function reset()
	{
		st = "index.php?pg=3"
		location.href=st;
	
	}
	function showrepo(dt)
	{
		getxmlhttp();	
		st = "repo.php?n="+Math.random()+"&dt="+dt
		xmlhttp.onreadystatechange=showrepo1;
		xmlhttp.open("GET",st,true);
		xmlhttp.send(null);
	} */
		function vemail(str)
	{
	   var rst = /^([\w]+)(\.[\w]+)*@([\w\-]+)(\.[\w]{2,7})(\.[a-z]{2})?$/i;
	   if (rst.test(str))
	   	 ;
	   else
	   	   alert("Invalid email address");
	} 
