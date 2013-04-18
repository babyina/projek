<br/>
<?php
session_start();
$parlimen_id = $_POST['parlimen_id'];

if(checkACL($_SESSION['userid'],4,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "SELECT pengurusan_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<form name="edit_jawapan" method="post">
	<fieldset><legend><b>Bahagian Pengurusan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			  <td width=120>Pindaan/Kuiri</td>
			  <td width=5>:</td><td width="829">
			<input type="radio" name="Pengesahan_Status" value="0">Ya
			<input name="Pengesahan_Status" type="radio" value="1">
			Tidak</td>
			</tr>			
			<tr><td width=120>Untuk Tindakan</td><td width=5>:</td><td>	
				<input checked type="checkbox" name="checkbox" value="checkbox">KSU 
				<input type="checkbox" name="checkbox" value="checkbox">TKSU
				<input type="checkbox" name="checkbox" value="checkbox">SUB</td></td></tr>
			<tr><td width=120>Nama Pegawai</td><td width=5>:</td><td><?php echo $_SESSION['nama']?></td></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
			<tr><td width=120>Tarikh</td><td width=5>:</td><td><?php echo $date ?></td></td></tr>
		</table>
		<table border=0 width="100%">
			<tr><td width=120>Catatan</td><td width=5>:</td><td><textarea name="Pengurusan_Catatan" rows=10 cols=60><?php echo $row2['pengurusan_catatan'] ?></textarea></td></tr>
		</table>	
	</div>
	</fieldset>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="pengurusan_tarikh" value="<?php echo $date ?>"/>
	<input class="button" name="SimpanPengurusan" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanDanHantarPengurusan" type="submit" value="SIMPAN & HANTAR"/>
	</form>
<?php } ?>
