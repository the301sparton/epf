// JavaScript Document
function chkpgno()
{
	vpgno=document.getElementById("pgno").value
	if(vpgno<0) vpgno=1
	if(vpgno>1)
	{
		vpgno--;
		document.getElementById("pgno").value=vpgno;
		showdata();
	}
}

function prevpg()
{
	vpgno=document.getElementById("pgno").value
	if(vpgno>1)
	{
		vpgno--;
		document.getElementById("pgno").value=vpgno;
		showdata();
	}
}
function nextpg(maxrows,dlist)
{
	ros=document.getElementById(dlist).rows
	if(ros.length>=maxrows)
	{
		vpgno=document.getElementById("pgno").value
		vpgno++;
		document.getElementById("pgno").value=vpgno;
		showdata();
	}	
}

