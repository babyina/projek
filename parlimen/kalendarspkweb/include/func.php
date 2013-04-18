<?php
function adate($temp){
	return $temp;
}

function getSesiDewan($value){
	if($value==1)
		$val = "<option value=\"1\" selected>Dewan Rakyat</option><option value=\"2\">Dewan Negara</option>";
	else
		$val = "<option value=\"1\">Dewan Rakyat</option><option value=\"2\" selected>Dewan Negara</option>";
	return $val;
}

function getKeyword($category,$default,$conn){
	$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$item = $row['butiran'];
		$selected = ($item == $default)?"selected":"";
		echo "<option $selected value".$item.">".$item."</option>";
	}
}

function findHari($mysql_date){
	if($mysql_date == "0000-00-00") return "";
	$dt = explode("-",$mysql_date);
	$weekday = date("w",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));
	$weekname = array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu");	
	return $weekname[$weekday];
}
function findWeek($mysql_date){
	$unixDate	= strtotime($mysql_date);
	$weekNo		= date("W",$unixDate);
	return $weekNo;
}

function dateDiff($dt1, $dt2, $split='yw') {
  	/**********************************************************************************************
	array dateDiff(mySqlDateFormat dt1, mySqlDateFormat dt2, string split) {
	Utk cari different hari. 
	Date boleh dalam format 'YYYY-MM-DD' atau TimeStamp
  	***********************************************************************************************/
	
	$date1 = (strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
	$date2 = (strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;
	$dtDiff = $date1 - $date2;
	$totalDays = intval($dtDiff/(24*60*60));
	$totalSecs = $dtDiff-($totalDays*24*60*60);
	$dif['h'] = $h = intval($totalSecs/(60*60));
	$dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
	$dif['s'] = $totalSecs-($h*60*60)-($m*60);
	// set up array as necessary
	switch($split) {
		case 'yw': # split years-weeks-days
		 $dif['y'] = $y = intval($totalDays/365);
		 $dif['w'] = $w = intval(($totalDays-($y*365))/7);
		 $dif['d'] = $totalDays-($y*365)-($w*7);
		 break;
		case 'y': # split years-days
		 $dif['y'] = $y = intval($totalDays/365);
		 $dif['d'] = $totalDays-($y*365);
		 break;
		case 'w': # split weeks-days
		 $dif['w'] = $w = intval($totalDays/7);
		 $dif['d'] = $totalDays-($w*7);
		 break;
		case 'd': # don't split -- total days
		 $dif['d'] = $totalDays;
		 break;
		default:
		 die("Error in dateDiff(). Unrecognized \$split parameter. Valid values are 'yw', 'y', 'w', 'd'. Default is 'yw'.");
	}
	return $dif;
}

function checkCuti($dt){
  	/**********************************************************************************************
	boolean checkCuti ( mySqlDateFormat dt )
	Function ini akan return nilai True atau False
	Function akan check dengan table 'kal_cuti' sama ada tarikh yg diinput adalah cuti atau tidak.
  	***********************************************************************************************/
	
	$sql	= "SELECT cuti FROM kal_cuti WHERE tarikh='$dt'";
	$rs		= mysql_query($sql) or die(mysql_error());
	$num	= mysql_num_rows($rs);
	if($num!=0)
		return true;
	else
		return false;
}

function tarikhAvailable($dtAwal,$dtAkhir){
  	/**********************************************************************************************
	array tarikhAvailable (mySqlDateFormat dtAwal, mySqlDateFormat dtAkhir)
	Function ini akan return array tarikh yang boleh bersidang.
	Tarikh yang available adalah pada hari Isnin, Selasa, Rabu dan Khamis TERMASUK hari cuti.
	Notes :  mktime(hour,minute,second,month,day,year,is_dst) --> returnkan UnixTimestamp.
  	***********************************************************************************************/
	$beza		= dateDiff($dtAkhir,$dtAwal,'d');
	$tarikh		= array($dtAwal); 
	for($i=1;$i<=$beza['d'];$i++){
		$tkhMulaUnix	= strtotime($dtAwal);
		$tkhBaruUnix	= mktime(0,0,0,date("m",$tkhMulaUnix),date("d",$tkhMulaUnix)+$i,date("Y",$tkhMulaUnix));
		$hariBaru		= date("w", $tkhBaruUnix);
		if($hariBaru==1 || $hariBaru==2 || $hariBaru==3 || $hariBaru==4){
			$tkhBaruMysql	= array(date("Y-m-d", $tkhBaruUnix));
			$tarikh			= array_merge($tarikh,$tkhBaruMysql);
		}
	}
	return $tarikh;
}

function redirect($url){
	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		@ob_end_clean(); // clear output buffer
		header( "Location: $url" );
	}
	exit();
}

//*************UNTUK SETKAN PETUGAS AUTOMATIK***********************
function getPetugasx($agensi, $state){
	switch($agensi){
		case 'd'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='1')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'p'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='2' OR agensi_id='3')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'k'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='4' OR agensi_id='5' OR agensi_id='6' OR agensi_id='7')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
	}
	$rs			= mysql_query($sql) or die(mysql_error());
	
	if($state==1)
		return mysql_num_rows($rs);
	elseif($state==2)
		return loadObjectList($rs);
	
}

function tugasan($id,$state){
	$sql2		= "SELECT Kal_pegawaiTugas_id FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id' AND PegawaiBtugas='' ORDER BY Kal_pegawaiTugas_id";
	$rs			= mysql_query($sql2) or die(mysql_error());
	if($state==1)
		return mysql_num_rows($rs);
	elseif($state==2)
		return loadObjectList($rs);
	
}

function updatePetugas(){
	$kiraPetugas = getPetugas('k',1);
	echo $kiraPetugas;
	$kiraTugasan = tugasan('21',1);
	$gelung	= round($kiraTugasan / $kiraPetugas);
	$baki	= $kiraTugasan % $kiraPetugas;
	if($baki > 0) 
		$gelung + 1;
	for($i=1;$i<=$gelung;$i++){
		$tugasan = tugasan('21',2);			
		foreach($tugasan as $tugasan){
			$petugas = getPetugas('k',2);
			foreach($petugas as $petugas){
				$nama=$petugas->nama;
				$sql3="UPDATE kal_pegawaitugas SET PegawaiBtugas='$nama' WHERE Kal_pegawaiTugas_id='$tugasan->Kal_pegawaiTugas_id' AND PegawaiBtugas='' ";
				echo $sql3."<br>";
				$query=mysql_query($sql3) or die(mysql_error());
				if ($query){
					$sql = "UPDATE pengguna SET TugasMesyuarat='Y' WHERE nama='$nama'";
					mysql_query($sql) or die(mysql_error());
				}
			}
		}
	}
}

function loadObjectList( $rs, $key='' ) {
	$array = array();
	while ($row = mysql_fetch_object( $rs )) {
		if ($key) {
			$array[$row->$key] = $row;
		} else {
			$array[] = $row;
		}
	}
	mysql_free_result( $rs );
	return $array;
}
//*************UNTUK SETKAN PETUGAS AUTOMATIK***********************

//NEW RIZAL AUTOMATE
function getSqlPetugasBelum($agensi){
	switch($agensi){
		case 'DBKL'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE '%6%' 
								AND (agensi_id='1')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'PERBADANAN PUTRAJAYA'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE (roles LIKE '%6%')
								AND (agensi_id='2')
								AND (tugasMesyuarat='N')
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'PERBADANAN LABUAN'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE (roles LIKE '%6%')
								AND (agensi_id='3')
								AND (tugasMesyuarat='N')
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'KWP'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE '%6%' 
								AND (agensi_id='4' OR agensi_id='5' OR agensi_id='6' OR agensi_id='7')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
	}
	return $sql;
}

function getPetugas($agensi){
	$petugas= array();
	$sql	= getSqlPetugasBelum($agensi);
	$rs		= mysql_query($sql) or die(mysql_error());
	while($row	= mysql_fetch_array($rs)){
		$petugas[] = $row['nama'];
	}
	return $petugas;
}



function setPetugas($agensi,$id){
  	/**********************************************************************************************
	array setPetugas (string agensi, string id)
	Function ini akan update nama petugas ke dalam kalendar
	setPetugas -> getPetugas -> setPetugasTo
  	***********************************************************************************************/
	$petugas	= getPetugas($agensi);
	$i		= 0;
	$countP = count($petugas);
	$sql	= "SELECT * FROM kal_pegawaitugas 
				WHERE 
					Agensi LIKE '".$agensi."%' 
					AND Kal_mesyuarat_id='$id' 
				ORDER BY 
					Kal_pegawaiTugas_id ASC";
	$rs		= mysql_query($sql) or die(mysql_error());
	while($row	= mysql_fetch_array($rs)){
		$petugasId	= $petugas[$i];
		$sqlUpdate	= "UPDATE kal_pegawaitugas SET PegawaiBtugas='".$petugasId."' 
						WHERE Kal_pegawaiTugas_id='".$row['Kal_pegawaiTugas_id']."'";
		mysql_query($sqlUpdate) or die(mysql_error());
		setPetugasTo($agensi, 'Y', false, $petugasId);
		//DEBUG
			echo $sqlUpdate;
			echo $row['Kal_pegawaiTugas_id'].'>'.$row['Tarikh'].'>'.$row['Agensi'].'>'.$row['Sesi'].'-->'.$petugas[$i].'<br>';
			echo '<br>';
		//DEBUG
		$i++;
		if($i==($countP)){
			setPetugasTo($agensi,'N', true); //RESET PETUGAS ALL TO NO 
			$petugas = getPetugas($agensi); //GET NEW LIST YG BELUM BERTUGAS 
			$countP	= count($petugas); //kira balik array petugas
			$i	= 0; // setkan balik counter = 0
		}
	}
}

function setPetugasTo($agensi,$yesNo,$isAll,$id=''){
	switch($agensi){
		case 'DBKL'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='$yesNo'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='1')";
					break;
		case 'PERBADANAN PUTRAJAYA'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='$yesNo'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='2')";
					break;
		case 'PERBADANAN LABUAN'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='$yesNo'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='3')";
					break;
		case 'KWP'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='$yesNo'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='4' OR agensi_id='5' OR agensi_id='6' OR agensi_id='7')";
					break;
	}
	if(!$isAll){
		$sql .= " AND nama='$id'";
	}
	//echo '<br>-->'.$sql.'<br><br>';
	mysql_query($sql) or die(mysql_error());
}
//end NEW RIZAL AUTOMATE

function checkPegawaiTugas($agensi){
	//Roles => 6 = Agensi Pegawai Bertugas
	//agensi_id => 1=dbkl,2=ppj,3=pl,4=pegawai kwp bertugas
	//tugasMesyuarat => Y=dah bertugas, N=belum bertugas
	switch($agensi){
		case 'd'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='1')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'p'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='2')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
		case 'k'	: 
					$sql = "SELECT nama FROM pengguna 
								WHERE roles LIKE'%6%' 
								AND (agensi_id='4' OR agensi_id='5' OR agensi_id='6' OR agensi_id='7')
								AND tugasMesyuarat='N'
								AND statusMohon = 'DAFTAR'
								ORDER BY nama";
					break;
	}
	$rs		= mysql_query($sql) or die(mysql_error());
	$count	= mysql_num_rows($rs);
	$check	= ($count>0)? true : false;
	return $check;
}

function setFlagPegawaiTugas($agensi){
	//Roles => 6 = Agensi Pegawai Bertugas
	switch($agensi){
		case 'd'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='N'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='1')";
					break;
		case 'p'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='N'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='2')";
					break;
		case 'k'	: 
					$sql = "UPDATE pengguna SET
								TugasMesyuarat='N'
								WHERE roles LIKE'%6%' 
								AND (agensi_id='4' OR agensi_id='5' OR agensi_id='6' OR agensi_id='7')";
					break;
	}
	mysql_query($sql) or die(mysql_error());
}

function hari($dtMysql){
  	/**********************************************************************************************
	string hari(mySqlDateFormat dtMysql)
	Function ini akan return nilai hari (Mon,Tues,.. Sun)
	Notes :  mktime(hour,minute,second,month,day,year,is_dst) --> returnkan UnixTimestamp
  	***********************************************************************************************/
	
	$tkhUnix	= strtotime($dtMysql);
	$hari		= date("D", $tkhUnix);
	return $hari;
}
?>