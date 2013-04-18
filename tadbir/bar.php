<script type="text/javascript">
var i

function prog()
{	
  document.getElementById("d1").innerHTML="";	document.getElementById("d2").style.width=0;  i=0;
  progBar();  

}

function progBar()
{
	
   if (i<=(300))
   {
   	 var empty = document.getElementById("info");
     empty.style.visibility = 'hidden';

	    if (i>40){document.getElementById("d1").innerHTML=parseInt(i/3)+"%";}
      document.getElementById("d2").style.width=i+"px";
      var j=0;		
      while (j<=100)
       	j++;  
        setTimeout("progBar();", 20); 
        i++;   
   }
   else{
     var empty = document.getElementById("main");
     empty.style.visibility = 'hidden';
	 var empty = document.getElementById("info");
     empty.style.visibility = 'visible';
   }
  
}
 
</script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/special1.js"></script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/special2.js"></script>
<style>
body{
	margin-top:0;
	margin-left:0;
	margin:0;
	right:0;
	bgColor:#E0EEEE
	font-family:Verdana, Arial, Helvetica, sans-serif;}
#text {
  position: absolute;
  top: 100px;
  left: 38%;
  margin: 0px 0px 0px -150px;
  font-size: 12px;
  font-weight:bold;
  font-family:Verdana, Arial, Helvetica, sans-serif;
  text-align: center;
  width: 500px;
}
</style>
</head>
<body onLoad="prog()">
<?php 
$process_mail = true;
?>
<center><br><br>
<div id="main">
<div id='text'>Sila tunggu sebentar. Permohonan anda sedang diproses..  <br /></div><br />
<div id="empty" style="position:relative;top:80px;left:0px;background-color:#cccccc;border:1px solid black;height:30px;width:300px;padding:0px;" align="left">
<div id="d2" style="position:relative;top:0px;left:0px;background-color:#333333;height:30px;width:0px;padding-top:5px;padding:0px;">
<div id="d1" style="position:relative;top:0px;left:0px;color:#f0ffff;height:30px;text-align:center;font:bold;padding:0px;padding-top:5px;font-size:12px;">
</div></div></div></center></div>
</center>

</BODY>
