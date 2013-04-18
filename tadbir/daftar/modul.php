<?php

$tajuk = array("","Soal Jawab Parlimen","Kalendar","Profil","Jemaah Menteri","Pendaftaran","Katakunci");

function countLevel($input,$modul){	
	switch ($input){
		case "1":$modul[1] += 1;break;
		case "2":$modul[2] += 1;break;
		case "3":$modul[3] += 1;break;
		case "4":$modul[4] += 1;break;
		case "0":$modul[5] +=1; break;
		default : $modul[5] += 1;
	}
}

function writeColumn($input){
	for($i=1;$i<=5;$i++){
		$td .= ($input==$i ||(($input==0 || $input == "") && $i==5))?"<td align=\"center\">X</td>":"<td/>";				
	}
	return $td;
}

$modul = array();
for($i=1;$i<=5;$i++){ 
	$modul[$i] = 0;
}

$modul_name = "Modul".$_GET['view'];
$qry = "SELECT id_tbl,Nama,$modul_name FROM pengguna ORDER BY Nama";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());

echo "<form>";
$title = $tajuk[$_GET['view']];
echo "<br/><b>Tahap Capaian Modul $title</b>"; 
echo "<table border=\"1\" width=\"80%\" style=\"border-style:double;border-color:#000000;border-width:1px\">";
echo "<tr><th>Nama</th><th>Tahap 1</th><th>Tahap 2</th><th>Tahap 3</th><th>Tahap 4</th><th>Tahap 5</th></tr>";
$m=1;
while($row = mysql_fetch_array($result)){
	$rcolor = ($m%2)?'#E7EFFF':'#B2DFEE';
	$ref = "<a href=\"index.php?action=details&id_tbl=".$row['id_tbl']."\">".$row['Nama']."</a>";
	echo "<tr bgColor='$rcolor'><td>$m. $ref</td>".writeColumn($row[$modul_name]+0)."</tr>";	
	countLevel($row[$modul_name],&$modul);	
	$m++;
}
echo "<tr style=\"font-weight:bold\"><td><b>Jumlah</b></td><td align=center>".implode('</td><td align=center>',$modul)."</td></tr>";
echo "</table>";
echo "</form>";
mysql_close();

include("level.php");
?>