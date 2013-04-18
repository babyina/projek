<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Progressbar driven by javascript ( js ). DHTML HTML CSS Internet Explorer ( IE ) / Firefox ( FF ) / Mozilla /  / Opera / Netscape ( NS ).</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Progress Bar using javascript ( js ) and HTML ( DHTML ).">
<LINK REL=stylesheet TYPE="text/css" HREF="../../~hans-kuipers2/ie-style/algemeen.css" TITLE="style">
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
	    if (i>40){document.getElementById("d1").innerHTML=parseInt(i/3)+"%";}
      document.getElementById("d2").style.width=i+"px";
      var j=0;		
      while (j<=100)
       	j++;  
        setTimeout("progBar();", 20); 
        i++;   
   }
}
</script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/special1.js"></script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/special2.js"></script>
</head>
<body>
<center><h1>Progress bar using javascript ( js ) and HTML ( DHTML ).</h1>

<script type="text/javascript" src="../../~hans-kuipers2/ie-style/header1.js"></script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/header2.js"></script>
<h2>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/html40.js"></script>
Timer driven progressbar using javascript/divisions.</h2>
<fieldset><legend>Related links</legend>
<a class="sp" href="../../~hans-kuipers4/html/weekplanner.htm">HTML : Weekly planner</a>
<a class="sp" href="calculator.htm">JS : Calculator</a>
<a class="sp" href="slideshow.htm">JS : Slideshow</a>
<a class="sp" href="calendar.htm">IE : Calendar</a>
<a class="sp" href="../../~hans-kuipers5/prop/dynamic-content.htm">IE : Dynamic content</a>
<a class="sp" href="../../~hans-kuipers5/js/javascript_dynamic_text.htm">JS : Dynamic text</a>
</fieldset>
<br><br><input  type="button" onclick="prog();" value="Show Me"><br><br>
<div id="ex" style="position:relative;width:468px;background:#eeeeee;border:3px double #000000;">
<center><br><br>
<div id="empty" style="background-color:#cccccc;border:1px solid black;height:30px;width:300px;padding:0px;" align="left">
<div id="d2" style="position:relative;top:0px;left:0px;background-color:#333333;height:30px;width:0px;padding-top:5px;padding:0px;">
<div id="d1" style="position:relative;top:0px;left:0px;color:#f0ffff;height:30px;text-align:center;font:bold;padding:0px;padding-top:5px;">
</div></div></div></center><br><br></div>
</center><br><br>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/bottom1.js"></script>
<script type="text/javascript" src="../../~hans-kuipers2/ie-style/bottom2.js"></script>

</BODY>
