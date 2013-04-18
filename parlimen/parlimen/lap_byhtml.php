<?php
session_cache_limiter('public');
session_start();
if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}
	
function adate($temp){ 
	return $temp;
}
		
function DeptNPeg($string){
	$lines = explode(";",$string);
	foreach($lines as $line){		
		$str = explode("+",$line);
		$tindakan[] = $str[0]." - ".$str[1];
		unset($str);
	}
	return implode(",",$tindakan);
}

function getYB($conn,$yb){
	$qry = "SELECT nama FROM ahli_parlimen WHERE id='$yb'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$yb = $row['nama'];
	return $yb;
}

function getAgensi($conn,$agensi){
	//$qry = "SELECT nama_pendek FROM agensi WHERE id='$agensi'";
	$qry = "SELECT nama FROM agensi WHERE id='$agensi'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$agensi = $row['nama'];
	return $agensi;
}

include("mc_table.php");
include("../config.php");
include("../keyword.php");


$current_time = date("d/m/Y");
$dewan = $_POST['Sesi'];
$lpbyrequest= $_POST['lpbyrequest'];
echo "<div style=\"text-transform:uppercase\">";
echo "PERKARA : ".$lpbyrequest;
echo "<div>";
//$tarikh_mula = $_POST['TkhMulaBersidang'];
$tarikh_mula = mysqlDate($_POST['TkhMulaBersidang']);






$qry = "SELECT parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat FROM parlimen
		WHERE parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'";

$result = mysql_query($qry,$conn) or die(mysql_error());
$rows = mysql_fetch_array($result);
$mesyuarat = $rows['mesyuarat'];
$penggal = $rows['penggal'];
$parlimen = $rows['parlimen'];
$sesi_dewan2 = (($dewan == 1)?"Dewan Rakyat":"Dewan Negara");

mysql_select_db($db_voffice,$conn) or die(mysql_error());

//kes lisan
$qry1 = "SELECT parlimen.perkara,parlimen.ahli_dewan_id,parlimen.sesi_dewan,parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat,
		parlimen.no_soalan,parlimen.agensi,parlimen.tkh_bentang_jawapan,parlimen.status,
		agensi.nama_pendek AS nama_pendek,agensi.id AS agensi,korperat_jawatan FROM parlimen
		INNER JOIN agensi ON parlimen.agensi = agensi.id
		WHERE parlimen.bentuk_soalan = 'Lisan' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		ORDER BY parlimen.tkh_bentang_jawapan ASC";
$result1 = mysql_query($qry1,$conn) or die(mysql_error());  
$total1 = mysql_num_rows($result1);
//$row1 = mysql_fetch_array($result1);

//kes bukan lisan
$qry2 = "SELECT parlimen.perkara,parlimen.ahli_dewan_id,parlimen.sesi_dewan,parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat,
		parlimen.no_soalan,parlimen.agensi,parlimen.tkh_bentang_jawapan,parlimen.status,
		agensi.nama_pendek AS nama_pendek,agensi.id AS agensi,korperat_jawatan FROM parlimen
		Inner Join agensi ON parlimen.agensi = agensi.id
		WHERE parlimen.bentuk_soalan <> 'Lisan' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		Order By parlimen.tkh_bentang_jawapan ASC";
$result2 = mysql_query($qry2,$conn) or die(mysql_error());
$total2 = mysql_num_rows($result2);
//$row2 = mysql_fetch_array($result2);

// query bahagian di MOF
?>
<script language="javascript" type="text/javascript">
//function utk hidekan button/bahagian yang xnak print
function printPage() { 
if(document.all) { 
document.all.divButtons.style.visibility = 'hidden'; 
window.print(); 
document.all.divButtons.style.visibility = 'visible'; 
} else { 
document.getElementById('divButtons').style.visibility = 'hidden'; 
window.print(); 
document.getElementById('divButtons').style.visibility = 'visible'; 
} 
} 
</script> 
<style type="text/css">
<!--


body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}

body {
margin-top: 1.00;

}

/*
body {
	margin-left: 1.25in;
	margin-top: 1in;
	margin-right: 1.25in;
	margin-bottom: 1in;
}
*/
.style1 {font-size: 10pt;
         line-height: 1.5em;
		 font-family: Arial;
}

.style2 {font-size: 10pt; font-weight: bold; }


-->


</style>

<form>
  <div id="divButtons" name="divButtons" align="center"> 
    <input name="PrintButton" type="button" onClick="printPage();" value="Cetak"> 
  </div>
 </form>
 
<?php
		$cat = array("Bahagian Kementerian Kesihatan","Agensi");
		$agencies = array();
		$agencies_name = array();
		$i = 0;
		foreach($cat AS $key)
		{		
			$re_agensi = mysql_query("SELECT agensi.id,nama FROM agensi WHERE kategori='$key'  ORDER BY id") or die (mysql_error());
			while($row_agensi = mysql_fetch_array($re_agensi))
			{
			 	$agencies[] = $row_agensi['id'];
				$agencies_name[] = $row_agensi['nama'];
				$agen_id = $row_agensi['id'];
				$where .= $or."parlimen_agensi.agensi_id LIKE '$agen_id' OR parlimen_agensi.agensi_id LIKE '%+$agen_id' OR parlimen_agensi.agensi_id LIKE '$agen_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agen_id+%'";
				$or = " OR ";
			}
		}	
		
		echo "<table width=100% border=1>";
		foreach($agencies as $agensi_id) // loop avery agensi- retrive kabinet_agensi
		{
		
		//$qry = "SELECT parlimen.id,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS tarikh,parlimen.perkara, parlimen_agensi.agensi_id,parlimen.no_soalan AS no_soalan
				//FROM parlimen, parlimen_agensi
				//WHERE (parlimen_agensi.agensi_id LIKE '$agensi_id' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id' OR parlimen_agensi.agensi_id LIKE '$agensi_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id+%') AND parlimen_agensi.parlimen_id = parlimen.id AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' AND (parlimen.status!='44')  OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				//ORDER BY parlimen.tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
		//echo "<tr><td colspan=\"6\"><strong>".$agencies_name[$i]."</strong></td></tr>";
       // echo "<tr><td>$agensi_id</td></tr>";
	  // echo " </tr><tr><th width=\"10%\">Tarikh</th><th  width=\"50%\" >Soalan</th><th width=\"15%\">Nama YB</th><th  width=\"10%\">Parti</th><th  width=\"15%\">Kawasan</th>";

         $qry = "SELECT parlimen.soalan,parlimen.tkh_bentang_jawapan,parlimen.ahli_dewan_id,
		parlimen.no_soalan,parlimen.kawasan_id,parlimen.parti_id,
		ahli_parlimen.nama as namamp,parti.nama_pendek as namaparti,kawasan.nama as namakawasan FROM parlimen
		INNER JOIN ahli_parlimen ON parlimen.ahli_dewan_id  = ahli_parlimen.id
		INNER JOIN parti ON parlimen.parti_id   = parti.id
		INNER JOIN kawasan ON parlimen.kawasan_id  = kawasan.id
		WHERE parlimen.agensi = '$agensi_id' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		and parlimen.soalan like '%$lpbyrequest%'
		ORDER BY parlimen.tkh_bentang_jawapan ASC";
      // echo  $qry 
	    $result = mysql_query($qry) or die (mysql_error());
		if((mysql_num_rows( $result ))<>0) {
		
        echo "<tr><td colspan=\"6\"><strong>".getAgensi($conn,$agensi_id)."</strong></td></tr>";
       // echo "<tr><td>$agensi_id</td></tr>";
	   echo " </tr><tr><th width=\"10%\">Tarikh</th><th  width=\"50%\" >Soalan</th><th width=\"15%\">Nama YB</th><th  width=\"10%\">Parti</th><th  width=\"15%\">Kawasan</th>";

         while($rows = mysql_fetch_array($result))
					{
						$tkh_terima =  DisplayDate($rows['tkh_bentang_jawapan']);
						$soalan  = $rows['soalan'];
						$namamp=$rows['namamp'];
						$namaparti=$rows['namaparti'];
						$namakawasan =$rows['namakawasan'];
						
				  $compareYear=substr($tkh_terima,0,5);
				  if($compareYear=="00/00")
					{
					$tkh_terima='bertulis';
					}
					else
					{
					$tkh_terima=$tkh_terima;
					}
						
						$column="<tr class=\"style1\"><td> $tkh_terima</td><td>$soalan</td><td>$namamp</td><td>$namaparti</td><td>$namakawasan</td></tr>";
						echo $column;
		}				

		$i++;
		unset($column);
		}
	   }	
		echo "</table>";
?>