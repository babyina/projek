<?php
include("../config.php");
include("../keyword.php");
include("include/func.php");
include("../js/FCKeditor/fckeditor.php") ;

//echo $_SERVER['QUERY_STRING'];
//Get value
$id		= $_GET['id'];
$jenis = "ib";
if(!empty($id)){
	$sql	= "SELECT * FROM kal_lapdwn_ib WHERE kal_lapdwn_ib_id='$id'";
	$sql	= "Select
				kal_lapdwn_ib.kal_lapdwn_ib_id,
				kal_lapdwn_ib.Kal_lapdwn_id,
				kal_lapdwn_ib.NamaYB,
				ahli_parlimen.id AS idAhliParlimen,
				kal_lapdwn_ib.Kawasan,
				kawasan.id AS idKawasan,
				kal_lapdwn_ib.Isu
				From
				kal_lapdwn_ib
				LEFT JOIN ahli_parlimen ON kal_lapdwn_ib.NamaYB = ahli_parlimen.nama
				LEFT JOIN kawasan ON kal_lapdwn_ib.Kawasan = kawasan.nama
			  WHERE kal_lapdwn_ib.kal_lapdwn_ib_id='$id'";
	$rs		= mysql_query($sql) or die(mysql_error());
	$row	= mysql_fetch_array($rs);
}

$parent_id 			= $_GET['pid'];
$getIdAhliParlimen 	= (isset($row['idAhliParlimen']) && !isset($_GET['idAhliParlimen']))? $row['idAhliParlimen'] : $_GET['idAhliParlimen'];
$getIdKawasan 		= (isset($row['idKawasan']) && !isset($_GET['idKawasan']))? $row['idKawasan'] : $_GET['idKawasan'];
$namaAhli			= (isset($row['NamaYB']) && !isset($_GET['nama']))? $row['NamaYB'] : $_GET['nama'];

if($_POST['save']){
	$namaYB 	= addslashes(stripslashes($namaAhli));
	$kawasan	= $_POST['kawasan'];
	$isu		= $_POST['isu'];
	if(!empty($id))
		$sql		= "UPDATE kal_lapdwn_ib SET 
						NamaYB='".$namaYB."',
						Kawasan='".$kawasan."',
						Isu='".$isu."'
					   WHERE kal_lapdwn_ib_id='".$id."'";
	else
		$sql		= "INSERT kal_lapdwn_ib SET 
						Kal_lapdwn_id='".$parent_id."',
						NamaYB='".$namaYB."',
						Kawasan='".$kawasan."',
						Isu='".$isu."'";
	mysql_query($sql)or die(mysql_error());
	echo $sql; 
	
	if(empty($id))
		$id = mysql_insert_id();
	include("lampiran_kalendar.php");

	
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
	echo "	window.opener.location.reload();";
	echo "	window.close();";
	echo "</script>";
	exit();	
}
?>
<script language="javascript">
	function redirect(){
		var idAhliParlimen = document.getElementById('idAhliParlimen');
		var s = idAhliParlimen.value.split(';');
		var url = 'LapSub_ib.php';
		var id = frm_ib.id.value;  //parent id
		var pid = frm_ib.parent_id.value;  //parent id
		var kawasan = frm_ib.kawasan.value;  //kawasan
		
		if (idAhliParlimen.length > 0){
			window.location = url+'?idAhliParlimen='+s[0]+'&idKawasan='+s[1]+'&nama='+s[2]+'&id='+id+'&pid='+pid+'&kawasan='+kawasan;
			return true;
		}
	}
</script>

<head>
<title>Isu Berbangkit</title>
<div style="font-family:Arial;font-size:9pt;font-weight:bold;text-align:center;margin-top:10px;height:40px">
<link rel="stylesheet" href="../style.css" title="general" type="text/css">
	<script src="multifile_compressed.js"></script>
</head>
<body style="margin-top:10px">

<form method="post" enctype="multipart/form-data" name="frm_ib">
	<fieldset>
	<legend>Isu Berbangkit</legend>
	<table width="100%">
		<tr>
			<td width="14%">Nama Ahli Parlimen</td>
			<td width="1%">:</td>
		  <td width="85%">
		  <select name="idAhliParlimen"  id="idAhliParlimen" onChange="redirect()">
		  	<option value="">- Sila Pilih -</option>
			<?php
				$sql = mysql_query("select id, nama, kawasan_id from ahli_parlimen ORDER BY nama");
				while($rowParlimen = mysql_fetch_array($sql)){
					$idAhliParlimen = $rowParlimen[0];
					$namaAhliParlimen = $rowParlimen['nama'];
					$idKawasan = $rowParlimen[2];
					$is_selected = ($getIdAhliParlimen == $idAhliParlimen)? "selected":"";
					print "<option value=\"".$idAhliParlimen.";".$idKawasan.";".$namaAhliParlimen."\"".$is_selected .">" . $namaAhliParlimen . "</option>";
				}
			?>
			</select> 
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" name="parent_id" value="<?php echo $parent_id;?>"></td>
		</tr>
		<?php
			$sql = mysql_query("select nama from kawasan where id = '$getIdKawasan'");
			$rowKawasan = mysql_fetch_array($sql);
			$kawasan = $rowKawasan[0];
		?>
		<tr>
			<td>Kawasan</td>
			<td>:</td>
			<td><?php echo $kawasan; ?> <input type="hidden" name="kawasan" value="<?php echo $kawasan;?>"></td>
		</tr>
		<tr>
			<td>Isu Berbangkit </td>
			<td>:</td>
			<td>
			<?php createRTF($sBasePath, 'isu', $row['Isu']);?>
			&nbsp;</td>
		</tr>
		<tr>
		  <td>Lampiran</td>
		  <td>&nbsp;</td>
		  <td><input id="my_file_element" type="file" name="file_1"><br /><br />
            <?php //display the attachments if any	
			$qry = "SELECT * FROM kal_lampiran WHERE kal_id='$id' AND jenis='$jenis'";
			$res = mysql_query($qry,$conn);
			while($row = mysql_fetch_array($res)){
				$nama_fail = $row['nama_fail'];
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
			}
			?>		</td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>
                <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 10 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script>		  </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
	</table>
	<center><input type="submit" value="Simpan" name="save" class="button"></center>
</fieldset>
</form>
</body>
