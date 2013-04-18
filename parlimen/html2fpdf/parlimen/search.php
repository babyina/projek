<?php
	require('../view.php');
	
	$pgNum = 1;
	$pgRow = 10;
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
		$panjang = 150;
		$len = strlen($string);
		$text1 = substr($string,0,$pos);
		
		$text1 = substr($text1,-$panjang);
		$text2 = substr($string,$pos+strlen($text),$panjang + strlen($text));
		
		return "....".$text1."<font class=\"fs\">".$text."</font>".$text2.".....";
	}
	
	
	class SearchResult extends View{
		
		function out($txt,$offset){			
			echo "<div style=\"padding:10\">";
			if(mysql_num_rows($this->result)==0){
				echo "<br/><br/><center><font size=3><b>Tiada rekod '$txt' ditemui</b></font></center>";
			}else{		
				echo "<p><center><font size=2><i>Jumlah rekod untuk carian <b>'$txt'</b> : ".$this->total_found."</i></center></p>";
				$i = $offset;
				while($row = mysql_fetch_array($this->result)){
					$i++;							
					
					echo "<a href='index.php?action=details&id=".$row['id']."'>". $i.".".$row['sesi_dewan']." (".DisplayDate($row['tkh_mula_bersidang'])." - ".DisplayDate($row['tkh_akhir_bersidang']).")</a><br/>";
					if($msg = resultSearch(" ".trim(longString(strip_tags($row['Soalan']))),$txt)){
						echo "<i><b>Soalan : </b></i>".$msg."</br>";						
					}else
						echo "<i><b>Soalan : </b></i>".substr(strip_tags($row['soalan']),0,150)."...</br>";
					if($msg = resultSearch(" ".trim(longString(strip_tags($row['jawapan']))),$txt)){
						echo "<i><b>Jawapan : </b></i>".$msg;						
					}else
						echo "<i><b>Jawapan : </b></i>".substr(strip_tags($row['Jawapan']),0,150)."..</br>";
					echo "<br/><br/>";
				}
			}		
			echo "</div>";			
		}
	}
	
	$Carian = ($_POST['Carian'])? $_POST['Carian']:$_GET['Carian'];
	$txt = $Carian;
	$Carian = "+(\"".trim($Carian)."\")";
	$qry = "SELECT id,tkh_mula_bersidang, tkh_akhir_bersidang, sesi_dewan,parlimen,penggal,bentuk_soalan,soalan,jawapan FROM parlimen WHERE match(soalan,jawapan) against('$Carian' IN BOOLEAN MODE) ";	
	$result = new SearchResult();
	$result->ref = "index.php?action=Parlimen&action=OpenDoc&id=";
	$result->table = "parlimen";
	$result->limit = "LIMIT $offset,$pgRow";
	$result->query = $qry;
	$result->Query($conn,$db_voffice);
	$result->out($txt,$offset);
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=search&Carian=$txt&page=";
	echo "<div style=\"padding:10\">";
	$result->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
	echo "</div>";
	
?>