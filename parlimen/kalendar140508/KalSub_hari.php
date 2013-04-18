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
$tkh	= $_GET['tkh'];
$hari	= $_GET['hari'];
$agen   = $_GET['agen'];

 $sql	= "SELECT Kal_mesyuarat_id, Tarikh, Agensi, PegawaiBtugas, Catatan FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id' AND Tarikh='$tkh'";
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
            <td width="33%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="65%">&nbsp;</td>
          </tr>
          <tr>
            <td>Tarikh</td>
            <td>:</td>
            <td><?php echo reverse($tkh);?></td>
          </tr>
          <tr>
            <td>Hari</td>
            <td>:</td>
            <td><?php echo $hari; ?></td>
          </tr>
          <tr>
            <td colspan="3" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center"><table width="80%"  border="1" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">Sessi</th>
                <th scope="col">Agensi</th>
                <th scope="col">Nama Pegawai Bertugas </th>
              </tr>
			  
              <tr>
                <td>Pagi</td>
                <td>&nbsp;</td>
                <td><select name="pegawaiBtugas">
                  <option value="">- Sila Pilih -</option>
                  <?php
				while($list=mysql_fetch_array($rsList)){
					$item = $list['nama'];
					$selected = ($item == $nama)?"selected":"";
					echo "<option $selected>".$item."</option>";
				}
				?>
                </select></td>
              </tr>
              <tr>
                <td>Pagi</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Petang</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Petang</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
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