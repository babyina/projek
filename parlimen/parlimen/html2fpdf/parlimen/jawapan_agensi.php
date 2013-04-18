<?php
session_start();

//---------------------------------------------------------------//
//--      List of agensi's answers    ---------------------------//
//----- ---------------------------------------------------------//

$qry = "SELECT agensi.nama,nama_pegawai,no_telefon,jawapan,tambahan,keterangan_tambahan,parlimen_agensi.id AS id,parlimen_agensi.agensi_id,
		penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan
		FROM parlimen_agensi,agensi
		WHERE parlimen_agensi.parlimen_id = '$id' AND parlimen_agensi.agensi_id = agensi.id";
$result = mysql_query($qry,$conn);

while($row2 = mysql_fetch_array($result)){
	$isPegawai = checkACL($_SESSION['userid'],2,$row2['agensi_id'],$conn);	
	$jawapan_id = $row2['id'];
	
?>
<fieldset class="<?php echo highlight($status==2||$status==10) ?>"><legend><b><?php echo $row2['nama'] ?></b></legend>
<div class="sub">
	<table border=0 width="100%">
	<? #echo $jawapan_id."<br>" ?>
		<tr><td width=120>Nama Pegawai</td><td width=5>:</td><td width=250><?php echo $row2['nama_pegawai'] ?></td><td width=120></td><td width=5></td><td></td></td></tr>
		<tr><td width=120>Disediakan Oleh</td><td width=5>:</td><td width=250><?php echo $row2['penyedia_nama'] ?></td><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $row2['penyedia_jawatan'] ?></td></td></tr>
		<tr><td width=120>Disahkan Oleh</td><td width=5>:</td><td width=250><?php echo $row2['penyedia_nama'] ?></td><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $row2['pengesah_jawatan'] ?></td></td></tr>
	</table>
	<table border=0 width="100%">
		<tr><td width=120>Jawapan</td><td width=5>:</td><td><?php echo $row2['jawapan'] ?></td></tr>
		<tr><td width=120>Maklumat Tambahan</td><td width=5>:</td><td><?php echo $row2['tambahan'] ?></td></tr>
		
		<?
		if($status>2)
		{
		
		if(!empty($row2['keterangan_tambahan'])){
		?>
		<tr><td width=120>Keterangan Tambahan</td><td width=5>:</td><td><?php echo $row2['keterangan_tambahan'] ?></td></tr>
		<? }
		//}
		if($status==10) // utk view catatan dr HEK - pindaan
		{
		$query = "select catatan from parlimen_agensi where id='$jawapan_id'";
		$re = mysql_query($query,$conn);
		$row4 = mysql_fetch_array($re);
		?>
		
		<tr><td width=120>Catatan</td><td width=5>:</td><td><?php echo $row4['catatan'] ?></td></tr>
		<? } 
		}?>
		
		<tr><td width=120>Lampiran</td><td width=5>:</td><td>
			<?php //display the attachments if any				
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id='$jawapan_id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
			?>
		</td></tr>
	</table>	
	<?php
		$editable= ($_SESSION['nama']==$row2['nama_pegawai']);
		
		if($status==2 && $isPegawai){
			echo "<a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Edit Jawapan ] </a>";
		}elseif(($status==10 && $isPegawai) && $editable){
			echo "<a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Edit Jawapan ] </a>";
		}

	?>
</div>
</fieldset>
<?php } //while ?>