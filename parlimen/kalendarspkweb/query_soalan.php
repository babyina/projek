<?php	

	/*
	function mysqlDate($date){ 
	if(!empty($date))
	{
 	    $temp = array();
 	    $temp =  explode("-",$date); 
	    $temp2 = array($temp[2], $temp[1], $temp[0]);
		$date = implode("/", $temp2);
	    return $date;
	}
	
	} */ 

	function getKeyword($category,$default,$conn){
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['butiran'];
			$selected = ($item == $default)?"selected":"";
			echo "<option $selected>".$item."</option>";
		}
	}
	
	function getKawasan($def,$conn){		
		if(empty($def))
			echo "<option selected value=\" \">"." "."</option>";	
				
		$qry = "SELECT id,nama FROM kawasan ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama']."</option>";			
		}				
	}
	
	function getAgensi($def,$conn){ //checkbox
		$qry = "SELECT id,nama FROM agensi ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$checked = "";
			if(is_array($def)){
				foreach($def as $key){
					if($key == $id){
						$checked = "checked";
					}
				}
			}
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"Agensi[]\" value=\"$id\">".$row['nama']."</span>"; 
			echo $td;
		}
	}
	
		function getAgensiPindaan($def,$conn,$id){
		$qry = "SELECT parlimen.agensi FROM parlimen WHERE id = $id";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
		#echo $row['agensi'];
			$agensi_id = explode("+", $row['agensi']);
			
			foreach($agensi_id as $key)
			{
			$qry2 = "SELECT agensi.nama FROM agensi WHERE id = $key";
			$result2= mysql_query($qry2,$conn) or die(mysql_error());
			$row2 = mysql_fetch_array($result2);
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"Agensi[]\" value=\"$key\" disabled>".$row2['nama']."</span>"; 
			echo $td;
			}			
		}
	}
	
		function getSalinan($salinan,$conn){
		
		//echo "Salinan".$salinan;
		$temp = array("TKSP(O)","TKSP(P)","KSP","TKSP(D)", "ANGGOTA PENTADBIRAN");
		//$salinan = explode("+",$salinan);

		while(list( ,$value) = each($temp)){
						
			$checked = "";
			foreach($salinan as $key){
				if($key == $value){
						$checked = "checked";
					}
				}						
				
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"salinan[]\" value=\"$value\">".$value."</span>"; 
			echo $td;
		}
		}
		
	function getBentukSoalan($default){
		if($default == "Lisan")
			echo "<option selected>Lisan</option><option>Bukan Lisan</option>";
		else
			echo "<option>Lisan</option><option selected>Bukan Lisan</option>";
	}
	
	function getYB($kawasan_id,$conn){
		$info;
		if($kawasan_id){
			#$qry = "SELECT id,nama FROM ahli_parlimen WHERE kawasan_id = '$kawasan_id' AND status=1";
			$qry = "SELECT ahli_parlimen.id,ahli_parlimen.nama,ahli_parlimen.parti_id,parti.nama_pendek 
			FROM ahli_parlimen,parti 
			WHERE kawasan_id = '$kawasan_id' AND status=1 AND parti.id = ahli_parlimen.parti_id";
			$result = mysql_query($qry,$conn);
			$row = mysql_fetch_array($result);
			$info[0] = $row['id'];
			$info[1] = $row['nama'];
			$info[2] = $row['parti_id'];
			$info[3] = $row['nama_pendek'];
			return $info;
		}else{
			return "";
		}
	}
	if($_GET['action']!='newdoc'){
		$id = $_GET['id'];	
		$qry = "SELECT parlimen.status,parlimen.sesi_dewan,parlimen,penggal,mesyuarat,
				tkh_mula_bersidang,tkh_akhir_bersidang, 
				ahli_parlimen.nama AS nama_yb, ahli_dewan_id,
				kawasan.nama as kawasan,parlimen.kawasan_id,bentuk_soalan,no_soalan,soalan, 
				parti.nama_pendek as parti,parti.id as parti_id,parlimen.tkh_bentang_jawapan, parlimen.perkara, 
				parlimen.agensi,pengurusan_nama,pengurusan_tarikh,pengurusan_catatan, pengesahan_nama,
				pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,
				korperat_tarikh,korperat_jawapan,korperat_tambahan,salinan,lampiran FROM parlimen
				LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
				LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
				LEFT JOIN parti ON parti.id = parlimen.parti_id
				WHERE parlimen.id ='$id'" ;
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$status = $row['status'];	
	}
?>