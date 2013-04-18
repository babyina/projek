<?php
$temp = $_GET['template_demo'];

if ($temp == ""){
	
	if ($id_connect){ 	
	$db = $id_connect;}


	require('../view.php');
	$Pegawai_Agensi = $_SESSION['agensi_id'];
	$pgNum = 1;
	$pgRow = 2;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}
	$offset =($pgNum -1)*$pgRow;

	function longString($string){
		$str = explode(chr(13),$string);
		foreach( $str as $st){
			$ss .= trim($st);
		}
		return $ss;
	}
	//keratan soalan dan jawapan 
	function resultSearch($string,$text){
		$string = strtolower($string);
		$text = strtolower($text);
	
		$pos = strpos($string,$text);	
		
		if($pos==null || $pos=='') return false;
		$panjang = 300;
		$len = strlen($string);
		$text1 = substr($string,0,$pos);
		
		$text1 = substr($text1,-$panjang);
		$text2 = substr($string,$pos+strlen($text),$panjang + strlen($text));
		
		return "....".$text1."<font class=\"fs\">".$text."</font>".$text2.".....";
	}
	
	
	class SearchResult extends View{
	
		function recount(){
			$tid = 0;
			$i = 0;
			while($row = mysql_fetch_array($this->result)){
				$id = $row['id'];					

				if($id<>$tid)
				{	
					$tid = $id;
					$i++;
				}
			} return $i;
		}
		
				
		function out($txt,$offset){
			if(mysql_num_rows($this->result)>0){
	
				$i = $offset;
				$tid = 0;
				
				while($row = mysql_fetch_array($this->result)){
						
					$id = $row['id'];					

					if($id<>$tid)
					{
						$tid = $id;
						$i++;
						$link = "<a href='index.php?action=details&id=".$row['id']."'>". $i.".".$row['sesi_dewan']." (".DisplayDate($row['tkh_mula_bersidang'])." - ".DisplayDate($row['tkh_akhir_bersidang']).")</a><br/>";
					 
						echo $link;		
						if($row['status'] == 0){
							if($msg = resultSearch(" ".trim(longString(strip_tags($row['perkara']))),$txt)){
								echo "<i><b>Perkara : </b></i>".$msg."</br>";						
							}else
								echo "<i><b>Perkara : </b></i>".substr(strip_tags($row['perkara']),0,300)."...</br>";
							if($msg = resultSearch(" ".trim(longString(strip_tags($row['jawapan']))),$txt)){
								echo "<i><b>Jawapan : </b></i>".$msg;						
							}else
								echo "<i><b>Jawapan : </b></i>".substr(strip_tags($row['jawapan']),0,300)."..</br>";
							echo "<br/><br/>";}
							else{			
							if($msg = resultSearch(" ".trim(longString(strip_tags($row['soalan']))),$txt)){
								echo "<i><b>Soalan : </b></i>".$msg."</br>";						
							}else
								echo "<i><b>Soalan : </b></i>".substr(strip_tags($row['soalan']),0,300)."...</br>";
							if($msg = resultSearch(" ".trim(longString(strip_tags($row['jawapan']))),$txt)){
								echo "<i><b>Jawapan : </b></i>".$msg;						
							}else
								echo "<i><b>Jawapan : </b></i>".substr(strip_tags($row['jawapan']),0,300)."..</br>";
							echo "<br/><br/>";
							}
					}
				}
				//echo $this->total = $i;
			}		
		}
		
		function outButir($txt,$offset,$total,$total2,$conn){
			$this->total = $total2; 
			if(mysql_num_rows($this->result)>0){
				echo "<center><font size=2><i>Keputusan Carian bagi butir perkara <br /><br /></i></font></center>";
				$i = $offset;
				while($row = mysql_fetch_array($this->result)){
					$i++;	
					$id = $row['kabinet_id'];
					$qry = "SELECT tarikh, perkara
							FROM kabinet 
							WHERE kabinet.id='$id' ";	
					$r = mysql_query($qry, $conn);
					$rows = mysql_fetch_array($r);
					$tarikh = $rows['tarikh'];					
					$perkara = $rows['perkara'];
					
					if(isset($row['lampiran_id']))
					{
						$lampiran_id=$row['lampiran_id'];
						$link = "<a href='index.php?action=details&lampiran=".$lampiran_id."&id=".$row['id']."'>". $i.".".$row['sesi_dewan']." (".DisplayDate($row['tkh_mula_bersidang'])." - ".DisplayDate($row['tkh_akhir_bersidang']).")</a><br/>";
					}
					else
						$link = "<a href='index.php?action=details&id=".$row['kabinet_id']."'>". $i.".".$row['sesi_dewan']." (".DisplayDate($tarikh).")</a><br/>";
					 
					//echo "<a href='index.php?action=details&id=".$row['id']."'>". $i.".".$row['sesi_dewan']." (".DisplayDate($row['tkh_mula_bersidang'])." - ".DisplayDate($row['tkh_akhir_bersidang']).")</a><br/>";
					echo $link;					
					if($msg = resultSearch(" ".trim(longString(strip_tags($perkara))),$txt)){
						echo "<i><b>Perkara : </b></i>".$msg."</br>";							
					}else
						echo "<i><b>Perkara : </b></i>".substr(strip_tags($perkara),0,300)."..</br>";
					if($msg = resultSearch(" ".trim(longString(strip_tags($row['butir_perkara']))),$txt)){
						echo "<i><b>Butir Perkara : </b></i>".$msg."</br>";						
					}else
						echo "<i><b>Butir Perkara : </b></i>".substr(strip_tags($row['butir_perkara']),0,300)."..</br>";
						
					echo "<br/><br/>";
				}
			}		
			echo "</div>";			
		}
		
	}
	
	$Carian = ($_POST['Carian'])? $_POST['Carian']:$_GET['Carian'];
	if(empty($Carian)){
		echo "<br><br><center><font class=\"fss\"> Sila masukkan katakunci</font></center>";
		echo "</td></tr></table>";
		include("../footer.php");		
		exit(0);
	}
	
	//echo $Carian;
	$txt = $Carian;
	//$Carian = "+(\"".trim($Carian)."\")";
	//$qry = "SELECT id,tkh_mula_bersidang, tkh_akhir_bersidang, sesi_dewan,parlimen,penggal,bentuk_soalan,soalan,jawapan FROM parlimen WHERE match(soalan,jawapan) against('$Carian' IN BOOLEAN MODE) ";	
	//$qry = "SELECT parlimen.id,parlimen_lampiran.parlimen_id, tkh_mula_bersidang, tkh_akhir_bersidang, sesi_dewan,parlimen,penggal,bentuk_soalan AS jawapan,

if($isPegawai){
$qry = "SELECT 
		DISTINCT parlimen_agensi.parlimen_id, 
		parlimen_agensi.nama_pegawai, 
		parlimen_agensi.jawapan, 
		parlimen_agensi.tambahan, 
		parlimen_agensi.keterangan_tambahan, 
		parlimen_agensi.penyedia_nama, 
		parlimen_agensi.penyedia_jawatan, 
		parlimen_agensi.pengesah_nama, 
		parlimen_agensi.pengesah_jawatan,
		parlimen.agensi,
		parlimen.id, 
		parlimen.perkara, 
		parlimen.tkh_mula_bersidang, 
		parlimen.tkh_akhir_bersidang, 
		parlimen.korperat_nama, 
		parlimen.soalan AS soalan, 
		parlimen.korperat_jawatan,
		parlimen.korperat_tarikh,
		parlimen.korperat_jawapan AS jawapan,
		parlimen.korperat_tambahan,
		parlimen.korperat_catatan 
		FROM parlimen_agensi 
		LEFT JOIN parlimen ON parlimen.id=parlimen_agensi.parlimen_id 
		WHERE 
		(parlimen.perkara LIKE '%$Carian%' OR 
		parlimen.korperat_nama LIKE '%$Carian%' OR 
		parlimen.soalan LIKE '%$Carian%' OR 
		parlimen.korperat_jawatan LIKE '%$Carian%' OR 
		parlimen.korperat_jawapan LIKE '%$Carian%' OR 
		parlimen.korperat_tambahan LIKE '%$Carian%' OR 
		parlimen.korperat_catatan LIKE '%$Carian%' OR 		
		parlimen_agensi.nama_pegawai LIKE '%$Carian%' OR  
		parlimen_agensi.jawapan LIKE '%$Carian%' OR  
		parlimen_agensi.tambahan LIKE '%$Carian%' OR  
		parlimen_agensi.keterangan_tambahan LIKE '%$Carian%' OR  
		parlimen_agensi.penyedia_nama LIKE '%$Carian%' OR  
		parlimen_agensi.penyedia_jawatan LIKE '%$Carian%' OR  
		parlimen_agensi.pengesah_nama LIKE '%$Carian%' OR 
		parlimen_agensi.pengesah_jawatan LIKE '%$Carian%') AND
		(parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') ";
		}else {
		$qry = "SELECT 
		DISTINCT parlimen_agensi.parlimen_id, 
		parlimen_agensi.nama_pegawai, 
		parlimen_agensi.jawapan, 
		parlimen_agensi.tambahan, 
		parlimen_agensi.keterangan_tambahan, 
		parlimen_agensi.penyedia_nama, 
		parlimen_agensi.penyedia_jawatan, 
		parlimen_agensi.pengesah_nama, 
		parlimen_agensi.pengesah_jawatan,
		parlimen.id, 
		parlimen.perkara, 
		parlimen.tkh_mula_bersidang, 
		parlimen.tkh_akhir_bersidang, 
		parlimen.korperat_nama, 
		parlimen.soalan AS soalan, 
		parlimen.korperat_jawatan,
		parlimen.korperat_tarikh,
		parlimen.korperat_jawapan AS jawapan,
		parlimen.korperat_tambahan,
		parlimen.korperat_catatan,
		parlimen.status
		FROM parlimen
		LEFT JOIN parlimen_agensi ON parlimen.id=parlimen_agensi.parlimen_id 
		WHERE 
		parlimen.perkara LIKE '%$Carian%' OR 
		parlimen.korperat_nama LIKE '%$Carian%' OR 
		parlimen.soalan LIKE '%$Carian%' OR 
		parlimen.korperat_jawatan LIKE '%$Carian%' OR 
		parlimen.korperat_jawapan LIKE '%$Carian%' OR 
		parlimen.korperat_tambahan LIKE '%$Carian%' OR 
		parlimen.korperat_catatan LIKE '%$Carian%' OR 		
		parlimen_agensi.nama_pegawai LIKE '%$Carian%' OR  
		parlimen_agensi.jawapan LIKE '%$Carian%' OR  
		parlimen_agensi.tambahan LIKE '%$Carian%' OR  
		parlimen_agensi.keterangan_tambahan LIKE '%$Carian%' OR  
		parlimen_agensi.penyedia_nama LIKE '%$Carian%' OR  
		parlimen_agensi.penyedia_jawatan LIKE '%$Carian%' OR  
		parlimen_agensi.pengesah_nama LIKE '%$Carian%' OR 
		parlimen_agensi.pengesah_jawatan LIKE '%$Carian%' ";}

	//$result = new SearchResult();
//	$result->limit = "LIMIT $offset,$pgRow";
	//$result->query = $qry;
	//$total = $result->query($conn,$db_voffice);
	//$result->out($txt,$offset);	
	
	#$result = new SearchResult();
	#$result->limit = "LIMIT $offset,$pgRow";
	#$result->query = $qry2;
	#$total2 = $result->query($conn,$db_voffice);
	//$result->outButir($txt,$offset,$total);	
	//$total_all = $total+$total2;
	//$result->total = $total_all; 

	echo "<div style=\"padding:10\">";
	$result = new SearchResult();
	$result->query = $qry;
	$total = $result->query($conn,$db_voffice);
	
	//count all - no redundancy
		
	$result->total = $result->recount();
	if($result->total==0){
		echo "<br/><br/><center><font class=\"fs\"><b>Tiada rekod '$txt' ditemui</b></font></center><br/>";
	}else{		
		echo "<p><center><font size=2><i>Jumlah rekod untuk carian <b>'$txt'</b> : ".$result->total."</i></font></center></p>";
	}	

	$result = new SearchResult();
	//$result->limit = "LIMIT $offset,$pgRow";
	$result->query = $qry;
	$result->query($conn,$db_voffice);

	$result->out($txt,$offset);
	
	echo "</div>";
//	$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=search&Carian=$txt&page=";
//	echo "<div style=\"padding:10\">";
//	$result->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
//	echo "</div>";
	
	
	#$result = new SearchResult();
	#$result->limit = "LIMIT $offset,$pgRow";
	#$result->query = $qry2;
#	$total2 = $result->query($conn,$db_voffice);
	//$offset  = $offset + $bil;
	#$result->outButir($txt,$offset,$total,$total_all,$conn);	
	
	//$result->out($txt,$offset);	
	//echo $total_all;

	$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=search&Carian=$txt&page=";
	echo "<div style=\"padding:10\">";
	//$result->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
	echo "</div>";
	
	
		
?>

<?php
if (!$isPegawai){
echo "<p><center><font size=2></font></center></p>";

include ('phpdig/search.php');
echo "</div>";
}
}
else{

if (!$isPegawai){
echo "<p><center><font size=2></font></center></p>";

include ('phpdig/search.php');
echo "</div>";
}
}
?>