<?php
	$query_perkara = "SELECT butiran FROM konfigurasi WHERE kategori='Perkara' ORDER BY butiran ASC";
	$query_parlimen = "select butiran from konfigurasi where kategori='Sesi Parlimen' order by CAST(kod AS unsigned) ASC";
	$query_penggal = "select distinct(butiran) from konfigurasi where kategori='Penggal Parlimen' order by CAST(kod AS unsigned) ASC";
	$query_mesyuarat = "select butiran from konfigurasi where kategori='Mesyuarat Parlimen' order by CAST(kod AS unsigned) ASC";
	$query_soalan = "select distinct(butiran) from konfigurasi where kategori='Bentuk Soalan' order by kategori ASC";
	$query_parti = "SELECT DISTINCT(butiran) FROM konfigurasi WHERE kategori='Parti' ORDER BY kategori ASC";	
	$query_bahagian = "select distinct(butiran) from konfigurasi where kategori='Tindakan' order by butiran ASC";
	$query_minggu = "SELECT butiran FROM konfigurasi WHERE kategori='Minggu Parlimen' ORDER BY CAST(kod AS unsigned) ASC";
	$query_negeri = "SELECT butiran FROM konfigurasi WHERE kategori='Negeri' ORDER BY butiran ASC";
	$query_minggu2 = "SELECT kod,butiran FROM konfigurasi WHERE kategori='Minggu Parlimen' ORDER BY CAST(kod AS unsigned) ASC";
//	$query_pengguna = "SELECT butiran FROM konfigurasi WHERE kategori='Jenis Pengguna' ORDER BY butiran";
	$query_jabatan = "SELECT butiran FROM konfigurasi WHERE kategori='Jabatan' ORDER BY butiran ASC";
	
	$teks_akhir = array("KSP","SUB(O)","KPSU(O)");
	
	function Reverse($date){ 
		if(!empty($date))
		{
			$result = (strpos($date,"-"));
	
			if($date == "0000-00-00")
				return $date="";
			if($result === false)
			{
				return $date;	
			}
			else
			{		
 	   			$temp = array();
 	   		 	$temp =  explode("-",$date); 
	   	 		$temp2 = array($temp[2], $temp[1], $temp[0]);
		 		$date = implode("/", $temp2);
	     		return $date;		
			}	
		}
	}

	function checkPengurusan($conn,$db,$userId){
		$qry = "SELECT Id FROM pengguna WHERE Id='$userId' AND Jenis=7";
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		return (mysql_num_rows($result)>0)?1:0;			
	}
	function formatDate($mysql_date){
		if($mysql_date == "0000-00-00") return "";
		$dt = explode("-",$mysql_date);
		$english_date = date("j F Y",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));	
		$month = array("January","February","March","April","May","June","July","August","September","October","November","December");
		$bulan = array("JANUARI","FEBRUARI","MAC","APRIL","MEI","JUN","JULAI","OGOS","SEPTEMBER","OKTOBER","NOVEMBER","DISEMBER");
		return str_replace($month,$bulan,$english_date);
	}
	function DisplayDate($dt){
		//return date to format dd/mm/yyyy
		$res = mysql_query("SELECT DATE_FORMAT('$dt','%d/%m/%Y') AS Tarikh");
		$row = mysql_fetch_array($res);
		return $row['Tarikh'];
	}
	function DisplayDateTime($dt){
		//return date to format dd/mm/yyyy hh:mm:ss
		$res = mysql_query("SELECT DATE_FORMAT('$dt','%d/%m/%Y %h:%i:%s %p') AS Tarikh");
		$row = mysql_fetch_array($res);
		return $row['Tarikh'];
	}
	function MysqlDate($dt){
		if($dt=='') return '';
		$td = explode("/",$dt);
		return date("Y-m-d", mktime(0,0,0,$td[1],$td[0],$td[2]));
	}
	function MysqlDate2($dt){
		if($dt=='') return '';
		$td = explode("/",$dt); 
		$localtime = localtime();
		return date("Y-m-d h:i:s", mktime($localtime[2],$localtime[1],$localtime[0],$td[1],$td[0],$td[2]));
	}
	function PrintOption($conn,$db='$db_voffice', $query, $def=""){		
		mysql_select_db ($db, $conn) or die (mysql_error());		
		$result = mysql_query($query, $conn)or die(mysql_error());
		while ($rows = mysql_fetch_array($result)) { 
			if($def<>$rows['butiran'])
				echo "<option>".$rows['butiran']."</option>";
			else
				echo "<option selected>".$rows['butiran']."</option>";			
		}
	}
	
	function PrintOption2($conn,$db='$db_voffice', $query, $def=""){		
		mysql_select_db ($db, $conn) or die (mysql_error());		
		$result = mysql_query($query, $conn)or die(mysql_error());
		while ($rows = mysql_fetch_array($result)) { 
			if($def<>$rows['butiran'])
				echo '<option value="'.$rows['kod'].'">'.$rows['butiran']."</option>";
			else
				echo '<option value="'.$rows['kod'].'" selected>'.$rows['butiran']."</option>";	
		}
	}
	function PrintOption3($conn,$db='$db_voffice', $query, $def=""){		
		mysql_select_db ($db, $conn) or die (mysql_error());		
		$result = mysql_query($query, $conn)or die(mysql_error());
		while ($rows = mysql_fetch_array($result)) { 
			if($def<>$rows['kod'])
				echo '<option value="'.$rows['kod'].'">'.$rows['butiran']."</option>";
			else
				echo '<option value="'.$rows['kod'].'" selected>'.$rows['butiran']."</option>";	
		}
	}		
	function isAdmin($fullname,$admin){
		foreach($admin as $nama){
			if($nama==$fullname) return true;
		}
		return false;		
	}
	
	function sendMail($conn,$db,$fullname,$subject,$url){		
		mysql_select_db($db,$conn) or die(mysql_error());		
		$result = mysql_query("SELECT Emel FROM pengguna where Nama='$fullname'") or die(mysql_error());
			
		if(mysql_num_rows($result)==0){
			return false;
		}else{			
			$row = mysql_fetch_array($result);
			$sendTo = $row['Emel'];			
			$message = "Sila klik URL di bawah untuk keterangan lanjut\n\n$url";
			$headers = "From: \n";
			if(mail($sendTo, $subject, $message,$headers)){				
				return true;
			}else
				return false;
		}		
	}
	
	function getJawatan($conn,$jawatan){
		$qry = "SELECT emel FROM pengguna where jawatan='$jawatan'";
		$result = mysql_query($qry,$conn) or die(mysql_error());

		$i=0;
		while($row = mysql_fetch_array($result))
		{
			if(!empty($row['emel']))
			{
				$address.= $sap.$row['emel'];
				$sap = ","; //echo $row['emel'];
			}
		}
		return $address;
	}
	function getAP($conn,$jawatan){
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$jawatan'";
		$result= mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result))
		{
			$jwtn = $row['butiran'];
			$qry2 = "SELECT emel FROM pengguna where jawatan='$jwtn'";
			$result2 = mysql_query($qry2,$conn) or die(mysql_error());
	
			if(mysql_num_rows($result2)>0)
			{
				$row2 = mysql_fetch_array($result2);
				$emel = $row2['emel'];
				if(!empty($emel))
				{
					$address.= $sap.$row['emel'];
					$sap = ","; //echo $row['emel'];
				}
			}			
		}
		return $address;
	}
	
	function sendSalinan($conn,$salinan,$subject,$message){		
	
		foreach ($salinan as $jawatan){
			if($emel = getJawatan($conn,$jawatan)){ 
			$address.= $sap.$emel;
			$sap = ",";
			}
		}
	
		$headers = "From: \n";	
		//if(mail($address,$subject,$message,$headers)){			
			return $address;
		//}else
		//	return false;		
	}
	
		function sendSalinanKepada($conn,$salinan,$subject,$message){		
	
		foreach ($salinan as $jawatan){
		
			if($jawatan=="Anggota Pentadbiran")
			{
				if($emel = getAP($conn,$jawatan)){ 
					$address.= $sap.$emel;
					$sap = ","; 
				}
			}else{			
				if($emel = getJawatan($conn,$jawatan)){ 
					$address.= $sap.$emel;
					$sap = ",";
				}
			}
		}
	
		$headers = "From: \n";	
		//if(mail($address,$subject,$message,$headers)){			
			return $address;
		//}else
		//	return false;		
	}

	
	function getEmail($conn,$id){
		$result = mysql_query("SELECT emel FROM pengguna WHERE agensi_id='$id'",$conn) or die(mysql_error());
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			if(!empty($row['emel']))
			{
				$address.= $sap.$row['emel'];		
				$sap = ",";
			}
		}
		return $address;
	}
	
	function sendToPegawai($conn,$agensi,$subject,$message){						
		foreach ($agensi as $node)
		{
			if($emel = getEmail($conn,$node)){ //node=agensi_id
				$address.= $sap.$emel;		
				$sap = ",";
			}
		}

		//echo $address;		
		$headers = "From: \n";	
	//	if(mail($address,$subject,$message,$headers)){			
			return $address;
		//}else
		//	return false;
	}

	
	function cariEmel($conn,$db,$fullname){
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query("SELECT Emel FROM pengguna WHERE Nama='$fullname'", $conn);
		$row = mysql_fetch_array($result);
		return $row['Emel'];
	}
	
	function sendAtasan($conn,$kategori,$subject,$message){
		$qry = "SELECT emel FROM pengguna WHERE roles LIKE '%$kategori%'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		//echo $qry;
		while($row=mysql_fetch_array($result)){
		if(!empty($row['emel']))
			{
				$address.= $sap.$row['emel'];			
				$sap = ",";
			}
		}
				
		if(empty($address)){
			return false;
		}else{			
			$headers = "From: \n";
		if(mail($address, $subject, $message,$headers)){			
			return $address;
		}else
			return false;
		}
	}
	
	function sendTeksAkhir($conn,$teks_akhir,$subject,$message){
		
		foreach($teks_akhir as $jawatan)
		{
			$qry = "SELECT emel FROM pengguna WHERE jawatan='$jawatan'";
			$result = mysql_query($qry,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$address.= $saps.$row['emel'];			
			$saps = ",";
		}		/*
		$bil = count($teks_akhir);
		echo $bil;
		for($i=0; $bil; $i++)
		{
			$jawatan = "SUB";echo "lailey";//$teks_akhir[$i];
			echo $jawatan;
			$qry = "SELECT emel FROM pengguna WHERE jawatan='$jawatan'";
			$result = mysql_query($qry,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$address.= $sap.$row['emel'];			
			$sap = ",";
		}*/
		//echo $address;
		if(empty($address)){
			return false;
		}else{			
			$headers = "From:\n";
			if(mail($address, $subject, $message,$headers)){			
				return $address;
			}else
				return false;
		}
	}
	
	function sendDPA($conn,$db,$subject,$url){
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query("SELECT Emel FROM pengguna WHERE Jenis=6",$conn) or die(mysql_error());		
		while($row=mysql_fetch_array($result)){
			$address.= $sap.$row['Emel'];			
			$sap = ",";
		}
		$message = "Sila klik URL di bawah untuk keterangan lanjut\n\n$url";
		if($address<>""){
			$headers = "From: \n";
			if(mail($address,$subject,$message,$headers)) return true;					
		}
		return false;
	}	
	

	function checkDPA($conn,$db,$userId){
		$qry = "SELECT Id FROM pengguna WHERE Id='$userId' AND Jenis=6";
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		return (mysql_num_rows($result)>0)?1:0;			
	}
	function checkAdmin($conn,$db,$userId){
		$qry = "SELECT Id FROM pengguna WHERE Id='$userId' AND Kategori='admin'";
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		return (mysql_num_rows($result)>0)?1:0;	
	}
	function splitNama($string){
		$name = array();
		$len = strlen($string);
		$pos1 = strpos($string,',');
		$pos2 = strpos($string,' (');
		
		$pos = ($pos1 < $pos2)?$pos1:$pos2;
		$sap2 = ($pos1 < $pos2)?"(":",";			
		
		$name[0] = trim(substr($string,0,$pos));
		
		$pos++;
		
		if($name[0]==""){
			$pos = strpos($string,$sap2);
			$name[0] = trim(substr($string,0,$pos));
		}
		if($name[0]=="") $name[0] = $string;
		if($pos<>"") $name[1] = trim(substr($string,$pos,$len));
		return $name;
	}
	function ExtractDept($data){
		$dept = explode(";",$data);
		foreach($dept as $node){
			$jab1 = explode("+",$node);
			$jabatan[] = $jab1[0];
		}
		return implode(",",$jabatan);
	}
	
	function checkView($conn,$field,$key,$userid){
		$qry = "SELECT $field FROM pengguna WHERE Id='$userid'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		//$items = $row[$field]<>""?explode(";",$row[$field]):(return false);
		if($row[$field]<>"")
			$items = explode(";",$row[$field]);
		else
			return false;
		if(in_array($key,$items)){
			return true;
		}
		else {
			return false;
		}
	}
	function SelectAgensi($conn,$agen){
		$agensi = explode(";",$agen);
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori='Jabatan' ORDER BY butiran";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row =mysql_fetch_array($result)){
			$value = $row['butiran'];	
			$checked = in_array($value,$agensi)?"checked":"";
			$msg .= "<div class=\"j\"><div class=\"j1\"><input onClick=\"agensiUtama(this)\" id=\"agensi\" type=\"checkbox\" $checked name=\"Agensi[]\" value=\"$value\"></div><div class=\"j2\">$value</div></div>";
		}
		return $msg;
	}
	
	function getExpired($conn,$id){
		$qry = "SELECT ADDDATE(Tarikh,INTERVAL 30 DAY) AS NewDate from memorandum 
		where PId='$id' order by NewDate DESC limit 1";
		$res = mysql_query($qry,$conn);
		if(mysql_num_rows($res)>0){
			$row = mysql_fetch_array($res);
			$dt = explode("-",$row['NewDate']);
			$_date = mktime(0,0,0,$dt[1],$dt[2],$dt[0]);
			
			if($_date<time())
				return "<img src=\"../images/senyum.gif\"/>";
			else
				return "";
		}
		else
			return "";
	}
	
	function isExpired($mysql_date,$status){		
		if($status == "" || $status==null) return "";
		$dt = explode("-",$mysql_date);
		$_date = mktime(0,0,0,$dt[1],$dt[2],$dt[0]);
		if($_date<time() && $status <> '12'){				
			return "<img src=\"../images/senyum.gif\"/>";
		}
		else
			return "";
	}
	
	function getTindakanTerakhir($id,$conn){
		$qry = "SELECT Tindakan FROM memorandum WHERE Id='$id' LIMIT 1";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row['Tindakan'];
	}
	function menuClick($menuClick,$menu){
		if($menuClick == $menu)
			return "color:#CD3700";	
	}
	
	function selectKawasan($conn,$db,$def="",$sesi_dewan="Dewan Rakyat"){
	mysql_select_db($db,$conn) or die(mysql_error());
	$qry = "SELECT kawasan_id FROM ahli_parlimen 
	WHERE kawasan_id <>'' AND sesi_dewan='$sesi_dewan' ORDER BY kawasan_id ASC";
	$result = mysql_query($qry) or die(mysql_error());
	
	while($rows = mysql_fetch_array($result)){
		$id = $rows['kawasan_id'];
		$qry2 = "SELECT nama FROM kawasan WHERE id ='$id'";
		$res = mysql_query($qry2) or die(mysql_error());
		$row2 = mysql_fetch_array($res);
		if($def<>$row2['nama'])
			echo "<option value =\"$id\">".$row2['nama']."</option>";
		else
			echo "<option selected>".$row2['nama']."</option>";
	}
}
	
	function createRTF($sBasePath, $fieldName, $defaultValue){
		// Rich Text Field
		// Automatically calculates the editor base path based on the _samples directory.
		// This is usefull only for these samples. A real application should use something like this:
		// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
				
	//	$oFCKeditor = new FCKeditor('FCKeditor1') ;
		$oFCKeditor = new FCKeditor($fieldName) ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Config['ToolbarStartExpanded'] = false ;
		$oFCKeditor->Height = '200';
		
		if ( isset($_GET['Skin']) )
			$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/' . htmlspecialchars($_GET['Skin']) . '/' ;
		
		$oFCKeditor->Value = $defaultValue ;
		$oFCKeditor->ToolbarSet	= 'Default' ;
		$oFCKeditor->Create();	
	}	
	
	function getInfo($table, $id)
	{
		$qry = "SELECT perkara FROM $table WHERE id ='$id'";
		$result = mysql_query($qry) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row['perkara'];		
	}
	
	function getSemakanParlimen($conn, $cat)		
	{
		$q = "SELECT kod, butiran FROM konfigurasi WHERE kategori='$cat'";	
		$r = mysql_query($q,$conn);
		while($rows = mysql_fetch_array($r))
		{
			$kod = $rows['kod'];
			$butiran = $rows['butiran'];
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"salinan[]\" value=\"$butiran\" disabled>".$kod."</span<br>"; 
			echo $td;
		}
	}	
?>