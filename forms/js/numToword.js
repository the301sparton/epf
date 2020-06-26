// JavaScript Document
w = new Array("Zero","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen","Twenty","Thirty","Forty","Fifty","Sexty","Seventy","Eighty","Ninety");
function word(pamt)
{
	if(pamt==0) return " ";
	amt=parseInt(pamt);
//	alert(amt);
	if(amt<21)
		st=w[amt];
	else 
	{
		d1=parseInt(amt/10);d2=amt%10;
		if(d2==0)
		{	st=w[d1+18];}
		else
			st=w[d1+18]+" "+w[d2];
	}
	return st;
}

function inwords(num)
{
//	alert(num);
	rs=parseInt(num)
	st="Rs. "
	if(rs>10000000)
	{
	  st=st+word(rs/10000000)+" Crore "
	  rs=rs%10000000
	}
	if(rs>100000)
	{
	  st=st+word(rs/100000)+" Lakh "
	  rs=rs%100000
	}
	if(rs>1000)
	{
	  st=st+word(rs/1000)+" Thousand "
	  rs=rs%1000
	}
	if(rs>100)
	{
	  st=st+word(rs/100)+" Hundred "
	  rs=rs%100
	}
	st=st+word(rs) + " only";
	return st;
}
