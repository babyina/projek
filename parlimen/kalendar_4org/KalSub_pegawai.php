<?php
session_start();
if ($_SESSION['valid'] == false){
	echo "invalid session";	
	exit(0);
}else{
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >90000000){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
}

include("../config.php");
include("../keyword.php");
include("include/func.php");

//Get value
$id		= $_GET['id'];
$agen	= $_GET['agen'];

$sql	= "SELECT Kal_mesyuarat_id, Tarikh, Agensi, PegawaiBtugas, Catatan FROM kal_pegawaitugas WHERE Kal_pegawaiTugas_id='$id'";
$rs		= mysql_query($sql) or die(mysql_error());
$row	= mysql_fetch_array($rs);
$main_id= $row['Kal_mesyuarat_id'];
$nama	= $row['PegawaiBtugas'];

//Get list nama yang belum bertugas mengikut dbkl, perbadanan, kwp
switch($agen){
	//Roles => 6 = Agensi Pegawai Bertugas
	case 'dbkl'	: 
				$sqlList = "SELECT id,nama FROM pengguna 
							WHERE roles LIKE'%6%' 
							AND (agensi_id='1')
							AND statusMohon = 'DAFTAR'
							ORDER BY nama";
				break;
	case 'ppj'	: 
				// OR agensi_id='3'
				$sqlList = "SELECT id,nama FROM pengguna 
							WHERE roles LIKE'%6%' 
							AND (agensi_id='2')
							AND statusMohon = 'DAFTAR'
							ORDER BY nama";
				break;
	case 'pl'	: 
				// OR agensi_id='3'
				$sqlList = "SELECT id,nama FROM pengguna 
							WHERE roles LIKE'%6%' 
							AND (agensi_id='3')
							AND statusMohon = 'DAFTAR'
							ORDER BY nama";
				break;
	case 'kwp'	: 
				$sqlList = "SELECT id,nama FROM pengguna 
							WHERE roles LIKE'%6%' 
							AND (agensi_id<>'1' AND agensi_id<>'2' AND agensi_id<>'3')
							AND statusMohon = 'DAFTAR'
							ORDER BY nama";
				break;
}

//buat checking kalau semua staf agensi itu 'y', run kan script utk 'N' kan
if (!checkPegawaiTugas($agen)){
	setFlagPegawaiTugas($agen);
}

$rsList		= mysql_query($sqlList) or die(mysql_error());


if($_POST['simpan']){
	$pegawaiBtugas = $_POST['pegawaiBtugas'];
	$catatan = $_POST['catatan'];
	$sqlPgwi= "UPDATE kal_pegawaitugas SET 
					PegawaiBtugas='".$pegawaiBtugas."',
					Catatan='".$catatan."'
				WHERE Kal_pegawaiTugas_id='$id'";
	$sqlTugas	= "UPDATE pengguna SET tugasMesyuarat='Y' WHERE nama='$pegawaiBtugas'";
	mysql_query($sqlPgwi)or die(mysql_error()); //setkan nama pegawai
	mysql_query($sqlTugas)or die(mysql_error()); //jadikan pegawai itu pernah bertugas
	
	
	//Automatic sending email when made changes
	/*
		$qry_emel = "SELECT emel FROM pengguna WHERE nama='$pegawaiBtugas'";
		$result_emel = mysql_query($qry_emel)or die(mysql_error()); //email pegawai bertugas baru
		$row_emel = mysql_fetch_array($result_emel);
		$address = $row_emel['emel'];
		
		$perkara = "Jadual Pegawai Bertugas";
		
		//sending emails to agencies/kwp
		$subject = $sistem_kal." : ".$perkara;
		$url = $link_kal.$main_id; 	
		$message = "Anda dikehendaki bertugas pada hari dan waktu yang telah ditetapkan. \nUntuk maklumat selanjutnya sila klik \n\n$url";	
	
		$from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";
				
		if(mail($address, $subject, $message,$headers)){			
			echo "<center><font class=fs><br/> Emel telah dihantar kepada<br/><br/>";
			echo $address."</font></center><br>";
		}else echo "Emel gagal dihantar";
	*/
	//End automatic sending email
	
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
	//echo "	window.opener.location.reload();";
	echo "	window.opener.document.frm_kal.submit();";
	echo "	window.close();";
	echo "</script>";
	exit();	
}
?>

<title>Pegawai Bertugas</title>
<div style="font-family:Arial;font-size:9pt;font-weight:bold;text-align:center;margin-top:10px;height:40px">
<link rel="stylesheet" href="../style.css" title="general" type="text/css">
<body style="margin:5px">
<form action="" method="post">
	<fieldset>
		<legend>Pegawai Bertugas</legend>
		
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="33%">Agensi</td>
            <td width="2%">:</td>
            <td width="65%"><?php echo $row['Agensi'];?></td>
          </tr>
          <tr>
            <td>Tarikh</td>
            <td>:</td>
            <td><?php echo reverse($row['Tarikh']);?></td>
          </tr>
          <tr>
            <td>Pegawai bertugas<?php echo "s";?></td>
            <td>:</td>
            <td><select name="pegawaiBtugas">
              <option value="">- Sila Pilih -</option>
              <?php
				while($list=mysql_fetch_array($rsList)){
					$item = $list['nama'];
					$selected = ($item == $nama)?"selected":"";
					echo "<option $selected>".$item."</option>";
				}
				?>
            </select> </td>
          </tr>
          <tr>
            <td>Pertanyaan lisan / Isu yang dibangkitkan </td>
            <td>&nbsp;</td>
            <td><textarea id="catatan" rows="10" cols="55" name="catatan"><?php echo $row['Catatan'];?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    	<center><input type="submit" value="Simpan" name="simpan" class="button"></center>
	</fieldset>
</form>
</body>