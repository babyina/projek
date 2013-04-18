<?php	

$current_user=$_SESSION['nama'];
$current_time = date("Y-m-d G:i:s",time()+(8*3600));

	function adate($temp){
		return $temp;
	}
	
	function getSesiDewan($value){
		if($value==2)
			$val = "<input type=\"radio\" name=\"Sesi\" value=\"1\" onClick=\"submit()\">Dewan Rakyat
					<input type=\"radio\" name=\"Sesi\" value=\"2\" checked onClick=\"submit()\">Dewan Negara"; 					
		else
			$val = "<input type=\"radio\" name=\"Sesi\" value=\"1\" checked onClick=\"submit()\">Dewan Rakyat
					<input type=\"radio\" name=\"Sesi\" value=\"2\" onClick=\"submit()\">Dewan Negara";
					
		return $val;
	}
	
	function getSesiDewanImbasan($value){
		if($value==2)
			$val = "<input type=\"radio\" name=\"Sesi\" value=\"2\" checked>Dewan Negara<br><input type=\"radio\" name=\"Sesi\" value=\"1\">Dewan Rakyat";
		else
			$val = "<input type=\"radio\" name=\"Sesi\" value=\"2\">Dewan Negara<br><input type=\"radio\" name=\"Sesi\" value=\"1\" checked>Dewan Rakyat";
		return $val;
	}
	

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
			echo "<option selected value=\"\">"." "."</option>";	
				
		$qry = "SELECT id,nama FROM kawasan ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama']."</option>";			
		}				
	}

	function getKawasan1($def,$sesi,$conn){
		if(empty($def))
			echo "<option selected value=\"\">"." "."</option>";
		
		$qry = "SELECT kawasan.id, kawasan.nama 
				FROM 
					ahli_parlimen, 
					kawasan 
				WHERE 
					ahli_parlimen.kawasan_id = kawasan.id AND
					ahli_parlimen.sesi_dewan=$sesi 
				ORDER BY
					nama
				";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".strtoupper($row['nama'])."</option>";			
		}				
	}

function PrintYBSenator($yb_id,$sesi,$conn,$db){	
	mysql_select_db($db,$conn) or die(mysql_error());
	$result = mysql_query("select id,nama FROM ahli_parlimen where sesi_dewan = '$sesi' ORDER BY nama ASC");
	if(empty($yb_id))
		echo "<option value=\"\" selected></option>";

	while($row = mysql_fetch_array($result)){
	$nama = $row['nama'];
	$id = $row['id'];
	if($id==$yb_id)
		echo "<option value=\"$id\" selected>";
	else
		echo "<option value=\"$id\">";
		
		echo $nama;
		echo "</option>";
	}		
}	
	
	function getAgensi($def,$conn,$kategori){ //checkbox
	    $qry = "SELECT id,nama FROM agensi WHERE kategori='$kategori' and nama <> 'UNIT KHAS' and nama <>'PEJABAT MENTERI, TIMBALAN MENTERI DAN PEGAWAI ATASAN' 
		     and id not in ('44','56','43','46','58') ORDER BY nama";
		
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
			$td = "<input $checked type=\"checkbox\" name=\"Agensi[]\" value=\"$id\">".$row['nama'].'<br>'; 
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
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"Agensi[]\" value=\"$key\" disabled>
			<label id=\"Agen_Pind\">".$row2['nama']."</label></span>"; 
			
			echo $td;
			}			
		}
	}
	
	function getAgensiPindaan2($conn,$id){
		$qry = "SELECT agensi_id FROM bahas_agensi WHERE main_id = '$id' ORDER BY agensi_id";
		$result = mysql_query($qry,$conn) or die(mysql_error());
	//	echo $qry; 
		$agen="";
		while($row = mysql_fetch_array($result)){
		
			$agensi_id = explode("+", $row['agensi_id']);
			
			foreach($agensi_id as $key)
			{
				if($agen<>$key)
				{
					$qry2 = "SELECT agensi.nama FROM agensi WHERE id = $key";
					$result2= mysql_query($qry2,$conn) or die(mysql_error());
					$row2 = mysql_fetch_array($result2);
					$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"Agensi[]\" value=\"$key\" disabled>".$row2['nama']."</span>"; 
					echo $td;
				}
				$agen=$key;
			}			
		}
	}
	
	function getSalinan($salinan,$key,$conn){
		
		//$temp = array("ANGGOTA PENTADBIRAN","KSU","TKSU(O)","TKSU(P)");
		
		$temp = array();
		$qry = "SELECT kod,butiran FROM konfigurasi WHERE kategori = '$key' order by id";
		$result= mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result))
		{
			$checked = "";
			$butiran = $row[butiran];
			$kod = $row[kod];
			foreach($salinan as $key){
				if($key == $butiran){
						$checked = "checked";
					}
				}						
				
			$td = "<input $checked type=\"checkbox\" name=\"salinan[]\" value=\"$butiran\">".$kod."<br>"; 
			echo $td;			
			
		}
	}
		
	function getBentukSoalan($default){
		if($default == "Lisan")
			$val = "<input type=\"radio\" name=\"BentukSoalan\" value=\"Lisan\"  onClick=\"ben_soalan(this.value)\" checked>Lisan<br><input type=\"radio\" name=\"BentukSoalan\" value=\"Bertulis\" onClick=\"ben_soalan(this.value)\">Bertulis";
		else
		    if($default == "Bertulis")
			$val = "<input type=\"radio\" name=\"BentukSoalan\" value=\"Lisan\" onClick=\"ben_soalan(this.value)\"  >Lisan<br><input type=\"radio\" name=\"BentukSoalan\" value=\"Bertulis\" onClick=\"ben_soalan(this.value)\" checked >Bertulis";
	     
		 else
		     $val = "<input type=\"radio\" name=\"BentukSoalan\" value=\"Lisan\" onClick=\"ben_soalan(this.value)\" checked>Lisan<br><input type=\"radio\" name=\"BentukSoalan\" value=\"Bertulis\" onClick=\"ben_soalan(this.value)\">Bertulis";
		 
		return $val; 
	}
	
	function getYB($kawasan_id,$conn){
		$info;
		if($kawasan_id){
			$qry = "SELECT ahli_parlimen.id,ahli_parlimen.nama,ahli_parlimen.pangkat,ahli_parlimen.parti_id,parti.nama_pendek 
			FROM ahli_parlimen,parti 
			WHERE ahli_parlimen.kawasan_id = '$kawasan_id' AND ahli_parlimen.status=1 AND parti.id = ahli_parlimen.parti_id";
			$result = mysql_query($qry,$conn);
			$row = mysql_fetch_array($result);
			$info[0] = $row['id'];
			$info[1] = empty($row['nama'])?"Tiada":$row['pangkat']." ".$row['nama'];
			$info[2] = $row['parti_id'];
			$info[3] = empty($row['nama_pendek'])?"Tiada":$row['nama_pendek'];
			return $info;
		}else{
			return "";
		}
	}
	
	function getKawasanYB($id,$conn){
		$info = array();
		if($id){
			#$qry = "SELECT id,nama FROM ahli_parlimen WHERE kawasan_id = '$kawasan_id' AND status=1";
			//$qry = "SELECT ahli_parlimen.id AS id,ahli_parlimen.nama,ahli_parlimen.pangkat,
			//ahli_parlimen.parti_id AS parti_id,parti.nama_pendek AS nama_pendek,negeri.id AS negeri_id, negeri.nama AS negeri
			//FROM ahli_parlimen,parti,negeri 
			//WHERE ahli_parlimen.id = '$id' AND ahli_parlimen.status=1";
			$qry	= "SELECT ahli_parlimen.id AS id,ahli_parlimen.nama,ahli_parlimen.negeri,ahli_parlimen.pangkat, ahli_parlimen.parti_id AS parti_id,parti.nama_pendek AS nama_pendek,negeri.id AS negeri_id, negeri.nama AS negeri 
						FROM ahli_parlimen
						LEFT JOIN negeri ON ahli_parlimen.negeri=negeri.id
						LEFT JOIN parti ON ahli_parlimen.parti_id=parti.id						
						WHERE ahli_parlimen.id = $id AND ahli_parlimen.status=1";
			$result = mysql_query($qry,$conn);
			$row = mysql_fetch_array($result);
			$info[0] = stripslashes($row['nama']);
			$info[1] = empty($row['negeri'])?"Tiada":$row['negeri'];
			$info[2] = $row['parti_id'];
			$info[3] = empty($row['nama_pendek'])?"Tiada":$row['nama_pendek'];
			$info[4] = $row['negeri_id'];
			$info[5] = stripslashes($row['pangkat']);
			
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
				kawasan.nama as kawasan,parlimen.kawasan_id,negeri.nama as negeri_nama,negeri.id as negeri_id,bentuk_soalan,no_soalan,soalan, 
				parti.nama_pendek as parti,parti.id as parti_id,parlimen.tkh_jawab, parlimen.tkh_bentang_jawapan, parlimen.perkara, 
				parlimen.agensi,pengurusan_nama,pengurusan_tarikh,pengurusan_catatan, pengesahan_nama,
				pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,
				korperat_tarikh,korperat_jawapan,korperat_tambahan,salinan FROM parlimen
				LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
				LEFT JOIN negeri ON negeri.id = parlimen.negeri 
				LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
				LEFT JOIN parti ON parti.id = parlimen.parti_id
				WHERE parlimen.id ='$id'" ;
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$status = $row['status'];	
		
	}
	

?>