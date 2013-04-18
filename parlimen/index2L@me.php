    <?php
  // include("checkSession.php");
	include("config.php");
	
		$valid = $_GET['valid'];

		if ($valid){
		
			echo "<script> alert(\"ID Pengguna dan Katalaluan tidak sepadan\"); </script>";
			$valid = "true";
		
		
		}

	?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Sistem Pentadbiran Soal Jawab Parlimen</title>
<link rel="stylesheet" href="style.css" id="style">
<script language="javascript"> 
var altKey  = false; 
var keyCode = 0; 
/*

function closeSession(evt){ 
  
    evt = (evt) ? evt : event; 
  
    //pageY  = event.pageY; 
	clickY  = evt.clientY; 
    altKey  = evt.altKey; 
    keyCode = evt.keyCode; 
   
    if(!evt.clientY){ 
	//alert(pageY)
        // Window Closing in FireFox 
        // capturing ALT + F4 
        keyVals = document.getElementById('ffKeyTrap'); 
        if(keyVals.value == 'true115'){ 
            return 'close 1x'; 
        } 
  
        if(keyVals.value == ''){ 
            // capturing a window close by "X" ? 
            // we have no keycodes 
            return 'close 2x'; 
        } 
  
    } else { 
        // Window Closing in IE 
        // capturing ALT + F4 
        if (altKey == true && keyCode == 115){ 
            alert('close 1'); 
        // capturing a window close by "X" 
        } else if(clickY < 0){ 
            alert('close 2'); 
        // simply leaving the page via a link 
        } else { 
            //alert('close 3'); 
            return void(0); 
        } 
    } 
} 
  
function whatKey(evt){ 
    evt = (evt) ? evt : event; 
    keyVals = document.getElementById('ffKeyTrap'); 
    altKey  = evt.altKey; 
    keyCode = evt.keyCode; 
	
    if(altKey && keyCode == 115){ 
	     alert(keyCode);
        keyVals.value = String(altKey) + String(keyCode); 
    } 
} 
window.onkeydown      = whatKey; 
window.onbeforeunload = closeSession;
*/
/*
function HandleOnClose(evt) {
var y = (event) ? evt.pageY : evt.clientY;
if (y < 0) {
alert('Thank You for chatting with iHosty');
//document.location.href='chatlogout.php?user=<?php echo $_SESSION['user'];?>';
}
}


window.onbeforeunload =HandleOnClose;

*/
var posy = 0;

function HandleOnClose(evt) {
//evt = (evt) ? evt : event; 
// if(evt.pageY)
 //{
 alert(evt.type)
 posy = evt.pageY;
 alert(posy) 
 //}
}
window.onbeforeunload=HandleOnClose(event);


/*function closeSession(evt){ 
 alert("testt je") 
}

function do_whatever() 
{ 

      delete_cookie ( "viet1800" );



} 

function onUnloadPage(e)
{
//var e = window.event;
var posx = 0;
var posy = 0;
if (e.pageX || e.pageY) {
posx = e.pageX;
posy = e.pageY;
alert("b");
//} else if (e.clientX || e.clientY) {
//posx = e.clientX + document.body.scrollLeft;
//posy = e.clientY + document.body.scrollTop;
//alert("c");
}
// posx and posy contain the mouse position relative to the document
// Do something with this information
var x;
var y;
// x = (window.event) ? window.event.pageX : event.clientX;
// y = (window.event) ? window.event.pageY : event.clientY;
 x = (window.event) ? window.event.pageX : event.clientX;
 y = (window.event) ? window.event.pageY : event.clientY;

alert(x);
   //alert("X: " + x + " Y: " +y );


}

*/


/*function delete_cookie ( cookie_name )
{
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
 alert(document.cookie)
}
 function onUnloadPage(e) {
                        var posx = 0;
                        var posy = 0;
                        var flag = 7; 
						//alert(evt)     
                        if (!e) var e = window.event;
                              
                        if (e.pageX || e.pageY) {
                              posx = e.pageX;
                              posy = e.pageY;
							  flag =1;
                        } else if (e.clientX || e.clientY) {
                              posx = e.clientX + document.body.scrollLeft;
                              posy = e.clientY + document.body.scrollTop;
							    flag =2; 
                        }
                        
                        alert("X: " + posx + " Y: " + posy+flag);
                  }
*/

/*
function onUnloadPage()
{
document.onclick = function(evt) {
    evt = evt || event; // FF will get the event through the evt whileas IE will use the event property.
    document.title = evt.clientX + ' // ' + evt.clientY;
  alert (document.title)
  }

//alert(evt.event.clientX)
//alert("xxx")
//alert(window.event.clientY)
	//if ((window.event.clientX > 1000) && (window.event.clientY < 0)) //X button is clicked
	//{
	//call your logout page
	//window.open('logout.asp','_blank', "features");
 // alert("boleh keluar")
	//or silent logout
	//logout = new Image();
	//logout.src="logout.asp";
	//}
}
*/
</script>

</head>

<body  style="margin-top:50px" onLoad="document.login.userid.focus()"  >
 <!--<div onclick="doSomething(event);">Hello there</div>-->
 <!--<input type="text" id="ffKeyTrap"><br /> -->

<table  align="center" width="900" border="1" cellpadding="0" cellspacing="0" >
    <tr> 
    <td width="100%" height="102" valign="top">
	<center><img src="images/banner/banner2.png"/>
	</center>	</td>
  </tr>
  <tr> 
    <td align="center" height="227" width="100%" style="background:url(images/banner/bg.png); background-repeat:no-repeat; background-position:top; height:227"> 
    <div style="width:716">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" >
        <tr>
          <td width="80%" >
		  	<form name="login" action="authenticate.php" method="POST">
          <?php			
			$mode = isset($_GET['mode'])?$_GET['mode']:"";$syst = isset($_GET['syst'])?$_GET['syst']:"";
			$id = isset($_GET['id'])?$_GET['id']:"";isset($_GET['action'])?$_GET['action']:"";
			echo("<input type=\"hidden\" name=\"mode\" value=".$mode.">");
			echo("<input type=\"hidden\" name=\"id\" value=".$id.">");
			echo("<input type=\"hidden\" name=\"syst\" value=".$syst.">");
			echo("<input type=\"hidden\" name=\"action\" value=".$action.">");
	  ?>
		  <table width="100%" border="0">
  <tr>
    <td>&nbsp;    </td>
    <td  colspan="2" height="60">&nbsp;</td>
      <td width="27%">&nbsp;</td>
  </tr>
  <tr>
    <td width="37%" >&nbsp;</td>
    <td width="14%"><strong>ID
                Pengguna</strong></td>
    <td width="22%"><input class="txt" name="userid" type="text" id="userid" maxlength="30" size="30"></td>
     <td>&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><strong>Katalaluan</strong></strong></td>
    <td><input class="txt" name="password" type="password" id="password" size="30"></td>
     <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="center"><br>
	  </div>
	<div align="right" style="width:195px">
        <input class="button" name="login" type="submit" id="login" value="Masuk">
	</div>
	<div align="center"><br>
	  </div>
	<div style="font-size:9px">
		<div align="right"><a href="#" style="font-size:9px" onClick="window.open('change_password.php','test','width=700,height=200,true')">Tukar Katalaluan</a> </div>
	</div>	</td>
     <td>&nbsp;</td>
  </tr>
</table>
          </form>          </td>
        </tr>
      </table>
      </div>    </td>
  </tr>
  <tr>
	<td height="1" class="footer"><br/><center><strong>Untuk Pertanyaan </strong></center>	<br/>
    <?php

//--------- auto-generated from table pengguna ----------------------------------------------
     
	 //$query = "SELECT nama,jawatan,emel,telefon FROM pengguna WHERE roles LIKE '%3%' and modul1=1 LIMIT 1"; asal
	$query = "SELECT nama,jawatan,emel,telefon, handphone FROM pengguna WHERE roles LIKE '%3%' and modul1=1 and jawatan LIKE '%PSU%'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	
	while($row=mysql_fetch_array($result))
	{
		$nama = $row['nama'];
		$jawatan = $row['jawatan'];
		$emel = $row['emel'];
		$telefon = $row['telefon'];
		$hp = $row['handphone'];
?>	
	
	<center>
	  <?php echo $nama ?>    ::   <?php echo $jawatan ?>   ::   <?php echo $telefon." / ".$hp ?>    
	</center>
	
<?php
 	}
	?>
	<center>
	<?php echo  "Emel :: ssjp@moh.gov.my"; ?>
	</center>
	<br/>	</td>  
  </tr>
</table>
<br /><br />

</body>
</html>