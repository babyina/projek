<?php
include("config.php");
$isHEK = checkOfficer($_SESSION['userid'],3,$conn);

if ((!$isHEK))
{

header( "Location:parlimen/" ) ; 
}


//check user level
$qry = "SELECT Modul1,Modul2,Modul3,Modul4,Modul5 FROM pengguna WHERE Id ='".$_SESSION['userid']."' or nokp='".$_SESSION['userid']."'" ;
//echo $qry;
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$modul1 = isModule($row['Modul1']);
$modul2 = isModule($row['Modul2']);
$modul3 = isModule($row['Modul3']);
$modul4 = isModule($row['Modul4']+0);
$modul5 = isModule($row['Modul5']); 

//$modul6 = $row['Modul6'];

$icon = "<img src='images/solid.jpg' /> ";

function showMenu($name,$url, $enable, $icon){
	if($enable){
		$ref = "$icon<a class='enable' href='$url'>$name</a>";
	}else{
		$ref = "$icon<font class='dim'>$name</font>";		
	}	
	return $ref;
	//echo $ref;
}
function isModule($modul){
	return ($modul>0)?true:false;
}

?>  
<title>Sistem Pengesanan Soal Jawab Parlimen</title>
  <div style="height:200px">
   <?php if($isHEK)
          $label="Senarai Modul :";
		  else
		   $label="Modul";
           ?>
  <table border=0>
	<tr><td width=150 /><td align="lef"><div style="height:50px;text-align:left">Selamat Datang <?php echo stripslashes($_SESSION['nama']) ?></div></td><td align="right" valign="top"><a href="logout.php">Logout</a></td></tr>
	<tr><td width=150 /><td colspan=2><left><?php echo  $label; ?> </left></td></tr>
<tr><td width=150 /><td class="tdm"><?php echo showMenu("SOAL JAWAB PARLIMEN","parlimen/",$modul1,$icon); ?></td><!--<td class="tdm"><?php echo showMenu("KALENDAR","kalendar/",$modul2,$icon); ?></td>--></tr>
     
	<tr><td width=150 /><td class="tdm"><?php if($isHEK) {echo showMenu("PROFIL","profil/",$modul3,$icon);} ?></td>
	<!--<td class="tdm"><?php echo showMenu("PENTADBIRAN SISTEM","admin/",$modul5,$icon); ?></td>-->
	</tr>
	<tr><td width=150 />
	
	
	<td class="tdm"></td>
	<td></td></tr>
  </table>  
  </div>