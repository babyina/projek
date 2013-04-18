<?php
session_start();
	
require("query_soalan.php");	

$pgNum = 1;
$pgRow = 20;
if(isset($_GET['page'])){
	$pgNum = $_GET['page'];
}
$offset =($pgNum -1)*$pgRow;
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$query_tajuk = "select butiran from konfigurasi where kategori='Sesi Bahas'";
$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
$salinan = $_POST['salinan']?$_POST['salinan']:explode("+",$row['salinan']);
$current_user=$_SESSION['nama'];
$current_time = date("Y-m-d G:i:s");
$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi'];
$mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
$penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
$parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
$msg1 = "<br><center><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a></center>";
$msg2 = "<br><center><a href=\"index.php?action=detailsbahas&cid=".$cid."\">kembali semula</a></center>";

function getSesiDewanBahas($value){
	if($value=="Dewan Rakyat")
		$val = "<input type=\"radio\" name=\"SesiDewan\" value=\"Dewan Negara\">Dewan Negara<input type=\"radio\" name=\"SesiDewan\" value=\"Dewan Rakyat\" checked>Dewan Rakyat";
	else
		$val = "<input type=\"radio\" name=\"SesiDewan\" value=\"Dewan Negara\" checked>Dewan Negara<input type=\"radio\" name=\"SesiDewan\" value=\"Dewan Rakyat\">Dewan Rakyat";
	return $val;
}


function Keyword($conn,$sql,$db_voffice,$def=""){		
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
	$result = mysql_query($sql,$conn) or die ("Can't complete query because ".mysql_error());
	while($rows = mysql_fetch_array($result)){
		if($def<>$rows['butiran'])
			echo "<option value=\"".$rows['butiran']."\">".$rows['butiran']."</option>";
		else
			echo "<option value=\"".$rows['butiran']."\" selected>".$rows['butiran']."</option>";
	}
}	

function PrintKawasan($conn,$db){	
	mysql_select_db($db,$conn) or die(mysql_error());
	$result = mysql_query("select kawasan_id from ahli_parlimen where kawasan_id<>'' order by kawasan_id ASC");
	while($row = mysql_fetch_array($result)){
		echo "<option>";
		echo $row['kawasan_id'];
		echo "</option>";
	}		
}

function PrintSenator($yb,$sesi,$conn,$db){	
	mysql_select_db($db,$conn) or die(mysql_error());
	$result = mysql_query("select nama FROM ahli_parlimen where sesi_dewan = '$sesi' ORDER BY nama ASC");
	while($row = mysql_fetch_array($result)){
	$nama = $row['nama'];
	if($nama==$yb)
		echo "<option value=\"$nama\" selected>";
	else
		echo "<option value=\"$nama\">";
		
		echo $nama;
		echo "</option>";
	}		
}

function displayAgensi($agensi,$conn){
	if($agensi==null) return null;
	$agensi_id = explode("+",$agensi);
	$where =  "id=" . implode(" OR id=",$agensi_id);
	$qry = "SELECT nama FROM agensi WHERE ".$where;
	$result = mysql_query($qry,$conn);
	$temp;
	while($row = mysql_fetch_array($result)){
		$temp = $temp .$sap . $row['nama'];
		$sap = ", ";
	}
	return $temp;
}

function displayAgensiShort($agensi,$conn){
	if($agensi==null) return null;
	$agensi_id = explode("+",$agensi);
	$where =  "id=" . implode(" OR id=",$agensi_id);
	$qry = "SELECT nama_pendek FROM agensi WHERE ".$where;
	$result = mysql_query($qry,$conn);
	$temp;
	while($row = mysql_fetch_array($result)){
		$temp = $temp .$sap . $row['nama_pendek'];
		$sap = ", ";
	}
	return $temp;
}	

function displaySalinan($salinan){
	if($salinan==null) return null;
	$salinan_id = explode("+",$salinan);
	foreach($salinan_id as $key){
		$temp = $temp .$sap . $key;
		$sap = ", ";
	}	
	return $temp;
}

function displayWakil($default,$conn){
	$qry = "SELECT butiran FROM konfigurasi WHERE kategori = 'Anggota Pentadbiran'";
	$result= mysql_query($qry,$conn) or die(mysql_error());
		
	while($row = mysql_fetch_array($result))
	{
		$jawatan = $row['butiran'];
		$qry = "SELECT nama FROM pengguna WHERE jawatan = '$jawatan'";
		$result2= mysql_query($qry,$conn) or die(mysql_error());
		$row2 = mysql_fetch_array($result2);
		$wakil = $row2['nama'];
		$selected = ($wakil == $default)?"selected":"";
		$option = "<option value=\"$wakil\" $selected>$wakil</option>";
		echo $option;
	}
	
}
?>