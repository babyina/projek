<?php
//

include("../checkSession.php");
include("../config.php");
include("../keyword.php");
include("include/func.php");

$idKalendar = $_POST['idKalendar'];
$parlimen	= $_POST['parlimen'];
$penggal	= $_POST['penggal'];
$mesyuarat	= $_POST['mesyuarat'];

if($_POST['hantarMaklum']){
	$notifyName = $_POST['notifyName'];
	echo 'Emel makluman sudah dihantar kepada ';
	echo '<br>';
	
	for ($k=0; $k < count($notifyName); $k++) {  //looping hantar email
		echo '<br>';
		$bil = 1;
		$name =  $notifyName[$k];		
		
		//dapatkan content email
		$sqlHari	= "SELECT * FROM kal_pegawaitugas 
						WHERE 
						Kal_mesyuarat_id='$idKalendar' 
						AND PegawaiBtugas='$name' 
						AND Maklum_email='0' 
						ORDER BY Tarikh";
		$rsHari		= mysql_query($sqlHari);
		
		echo $emailPgw		= lookup($conn, "pengguna", "emel", "nama='$name'");
		echo '<br>';
		$content	= "
		Anda dikehendaki bertugas pada tarikh dan sesi yang telah ditetapkan seperti di bawah : <br>
		<div style='padding-left:20px'>
		Parlimen : $parlimen <br>
		Penggal : $penggal <br>
		Mesyuarat : $mesyuarat <br>
		<table border=0>
		<tr>
		<th style='padding:3px;background:#C0C0C0'>Bil</th>
		<th style='padding:3px;background:#C0C0C0'>Tarikh</th>
		<th style='padding:3px;background:#C0C0C0'>Hari</th>
		<th style='padding:3px;background:#C0C0C0'>Sesi</th>
		<th style='padding:3px;background:#C0C0C0'>Dewan</th>
		</tr>
		";	
						
		while ($rowHari	= mysql_fetch_array($rsHari)){  // looping hari bertugas
			$tarikh = DisplayDate($rowHari['Tarikh']);
			$hari	= findHari($rowHari['Tarikh']);
			$sesi	= $rowHari['Sesi'];
			$dewan	= $rowHari['Dewan'];
			$col1	= "<tr><td>".$bil."</td>";
			$col2	= "<td>".$tarikh."</td>";
			$col3	= "<td>".$hari."</td>";
			$col4	= "<td>".$sesi."</td>";
			$col5	= "<td>".$dewan."</td></tr>";
			$content .= $col1.$col2.$col3.$col4.$col5;
			$bil++;
		}
		$content .= '</table></div>';
		echo $content .= "Untuk maklumat lanjut, sila klik $url";
		
		//hantar email
		if(!mail($emel,$subject,$content,$headers)){
			//update db pegawai ini sudah dimaklumkan.
			echo 'update flag';
		}
	}
}

?>