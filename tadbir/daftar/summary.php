<?php
function countLevel($input,$modul){	
	switch ($input){
		case "1":$modul[1] += 1;break;
		case "2":$modul[2] += 1;break;
		case "3":$modul[3] += 1;break;
		case "4":$modul[4] += 1;break;		
		case "6":$modul[6] += 1;break;
		default :$modul[5] += 1;break;
	}
}

$modul1 = array();
$modul2 = array();
$modul3 = array();
$modul4 = array();
$modul5 = array();

for($i=1;$i<=5;$i++){
	$modul1[$i] = 0;$modul2[$i] = 0;$modul3[$i] = 0;
	$modul4[$i] = 0;$modul5[$i] = 0;
}

$qry = "SELECT Nama,Modul1,Modul2,Modul3,Modul4,Modul5 FROM pengguna ORDER BY Nama";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	countLevel($row['Modul1'],&$modul1);
	countLevel($row['Modul2'],&$modul2);
	countLevel($row['Modul3'],&$modul3);
	countLevel($row['Modul4'],&$modul4);
	countLevel($row['Modul5'],&$modul5);	
	//countLevel($row['Modul6'],&$modul6);
}
mysql_close();
?>
<body>
<form>
<br/>
<b>Ringkasan Capaian Modul-modul</b>
<table border="1" cellpadding=1 cellspacing=2 width="90%" style="border-style:solid;border-color:#000000;border-width:1px">
	<tr style="color:#ffffff;background-color:#00688B;font-weight:bold;align:center"><td >Modul</td><td >Tahap 1</td><td >Tahap 2</td><td >Tahap 3</td><td >Tahap 4</td><td >Tahap 5</td></tr>
	<tr style="color:#f5f5f5"><td bgcolor="#6CA6CD"><a href="index.php?mode=Modul&modul=1">Maklum Balas Soalan Parlimen</a></td><td align="center" bgcolor="#6CA6CD"><?php echo implode("</td><td align=\"center\" bgcolor=\"#6CA6CD\">",$modul1) ?></td></tr>
	<tr style="color:#f5f5f5"><td bgcolor="#6CA6CD"><a href="index.php?mode=Modul&modul=2">Maklum Balas Jemaah Menteri</a></td><td align="center" bgcolor="#6CA6CD"><?php echo implode("</td><td align=\"center\" bgcolor=\"#6CA6CD\">",$modul2) ?></td></tr>
	<tr style="color:#f5f5f5"><td bgcolor="#6CA6CD"><a href="index.php?mode=Modul&modul=3">Kalendar Parlimen</a></td><td align="center" bgcolor="#6CA6CD"><?php echo implode("</td><td align=\"center\" bgcolor=\"#6CA6CD\">",$modul3) ?></td></tr>
	<tr style="color:#f5f5f5"><td bgcolor="#6CA6CD"><a href="index.php?mode=Modul&modul=4">Profil</a></td><td align="center" bgcolor="#6CA6CD"><?php echo implode("</td><td align=\"center\" bgcolor=\"#6CA6CD\">",$modul4) ?></td></tr>
	<tr style="color:#f5f5f5"><td bgcolor="#6CA6CD"><a href="index.php?mode=Modul&modul=5">Pentadbiran Sistem</a></td><td align="center" bgcolor="#6CA6CD"><?php echo implode("</td><td align=\"center\" bgcolor=\"#6CA6CD\">",$modul5) ?></td></tr>
</table>
</form>
</body>
</br>
<?php
include("level.php");
?>