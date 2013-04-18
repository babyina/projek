<?php
include("config.php");
//check user level
$qry = "SELECT Modul1,Modul2,Modul3,Modul4,Modul5,Modul6 FROM pengguna WHERE Id ='".$_SESSION['userid']."'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$modul1 = isModule($row['Modul1']);
$modul2 = isModule($row['Modul2']);
$modul3 = isModule($row['Modul3']);
$modul4 = isModule($row['Modul4']+0);
$modul5 = isModule($row['Modul5']);
$modul6 = isModule($row['Modul6']);

//$modul6 = $row['Modul6'];

$icon = "<img src='images/solid.jpg' /> ";

function showMenu($name,$url, $enable, $icon){
	if($enable){
		$ref = "$icon<a class='enable' href='$url'>$name</a>";
	}else{
		$ref = "$icon<font class='dim'>$name</font>";		
	}	
	return $ref;
}
function isModule($modul){
	return ($modul>0)?true:false;
}

?>  
  <div style="height:200px">
   
  <table border=0>
	<tr><td width=150 /><td align="lef"><div style="height:50px;text-align:left">Selamat Datang <?php echo $_SESSION['nama'] ?></div></td><td align="right" valign="top"><a href="logout.php">Logout</a></td></tr>
	<tr><td width=150 /><td colspan=2><left>Senarai Modul : </left></td></tr>
	<tr><td width=150 /><td class="tdm"><?php echo showMenu("PENDAFTARAN PENGGUNA","daftar/",$modul5,$icon); ?></td>
	<td class="tdm"><?php echo showMenu("KATAKUNCI","katakunci/",$modul6,$icon); ?></td>
	</tr>
	<tr><td width=150 /><td class="tdm">&nbsp;</td>
	<!--<td class="tdm"><?php echo showMenu("PENTADBIRAN SISTEM","admin/",$modul5,$icon); ?></td>-->
	</tr>
	<tr><td width=150 /><td class="tdm">&nbsp;</td>
	<td></td></tr>
  </table>  
  </div>