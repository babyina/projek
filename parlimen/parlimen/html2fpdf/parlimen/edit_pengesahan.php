<br/>
<?php
session_start();
$parlimen_id = $_POST['parlimen_id'];

if(checkACL($_SESSION['userid'],5,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
			
	$qry = "SELECT pengesahan_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<form name="edit_jawapan" method="post">
	<fieldset><legend><b>Bahagian Pengesahan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			  <td width=120>Pindaan/Kuiri</td>
			  <td width=5>:</td><td><input type="radio" name="Pengesahan_Status" value="0">
			  Ya
			    <input type="radio" name="Pengesahan_Status" value="1">
			    Tidak</td></td></tr>
			<tr><td width=120>Nama Pegawai</td><td width=5>:</td><td><?php echo $_SESSION['nama']?></td></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
			<tr><td width=120>Tarikh</td><td width=5>:</td><td><?php echo date("d/m/Y") ?></td></td></tr>
		</table>
		<table border=0 width="100%">
			<tr><td width=120>Catatan</td><td width=5>:</td><td><textarea name="Pengesahan_Catatan" rows=10 cols=60><?php echo $row2['pengesahan_catatan'] ?></textarea></td></tr>
		</table>	
	</div>
	</fieldset>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>		
	<input class="button" name="SimpanPengesahan" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanDanHantarPengesahan" type="submit" value="SIMPAN & HANTAR"/>
	</form>
<?php } ?>
