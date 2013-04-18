<?php
session_start();

//---------------------------------------------------------------//
//--      List of agensi's answers    ---------------------------//
//----- ---------------------------------------------------------//
if($status==21)
$qry = "UPDATE sesi_bahas SET status='22' WHERE id='$id' LIMIT 1";

$result = mysql_query($qry,$conn);

$qry = "SELECT agensi.nama,nama_pegawai,no_telefon,jawapan,tambahan,keterangan_tambahan,bahas_agensi.id AS id,
		bahas_agensi.agensi_id,bahas_agensi.status_pindaan, penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan,tkh_terima, 
		bahas_agensi.penyedia_nama, bahas_agensi.penyedia_jawatan, bahas_agensi.pengesah_nama, bahas_agensi.pengesah_jawatan, bahas_agensi.status_pindaan  
		FROM bahas_agensi,agensi
		WHERE bahas_agensi.bahas_id = '$cid' AND bahas_agensi.agensi_id = agensi.id";

$result = mysql_query($qry,$conn);

while($row2 = mysql_fetch_array($result)){
	$tkh_terima = "";
	$status_pindaan = "";
	$isPegawai = checkACL($_SESSION['userid'],2,$row2['agensi_id'],$conn);	
	$jawapan_id = $row2['id'];
	$jawapan_agensi = $row2['jawapan'];
	$status_pindaan = $row2['status_pindaan'];
	if(!empty($row2['tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Maklumat Tambahan</b></br><br>".$row2['tambahan'];
	if(!empty($row2['keterangan_tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Keterangan Tambahan</b></br><br>".$row2['keterangan_tambahan'];	
	if($row2['tkh_terima']<>"0000-00-00")
		$tkh_terima .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan=\"3\"><font color=\"#336699\">&nbsp;&nbsp;&nbsp;&nbsp;Jawapan telah dihantar pada ".Reverse($row2['tkh_terima'])."</font><br /></td></tr>";	
	else
		$tkh_terima = "";
		
	$penyedia = !empty($row2['penyedia_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">&nbsp;&nbsp;&nbsp;&nbsp;Disediakan oleh  :  ".$row2['penyedia_nama']."  (".($row2['penyedia_jawatan']).")</font><br /></td></tr>":"";
	$pengesah = !empty($row2['pengesah_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">&nbsp;&nbsp;&nbsp;&nbsp;Disahkan oleh  &nbsp;&nbsp;:  ".$row2['pengesah_nama']."  (".($row2['pengesah_jawatan']).")</font><br /></td></tr>":"";
	$status_pindaan = $row2['status_pindaan'];
	//echo $jawapan_agensi;
	$count++;
	$div = "agensi".$count;
	$jwpn = "Jawapan".$count;
	$img_collapse = "img_collapse".$count;
	$state_per = "state".$count;
	?>
	<script language="javascript">
		var <?php echo $state_per ?> = 1;

	</script>
	<?php	
	# pastikan hanya agensi yg terlibat nampak agensinya sahaja 
	//for Pegawai agensi
	$view = 0;
	if($isPegawai && !empty($tkh_terima))
		if($status==10 && $status_pindaan==0)
			$view = 0;
		else
			$view = 1;	
	if($isHEK || $isPengurusan || $isPengesahan)
		$view = 1;
	
	if($view == 1)
	{
	?>
<br /><br>
<fieldset class="<?php echo highlight($status==21||$status==22||$status==10) ?>"><legend><b><?php echo $row2['nama'] ?></b></legend>
<div class="sub">
	<table border=0 width="100%">
	   <?php echo $tkh_terima.$penyedia.$pengesah; ?>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama Pegawai</td>
		  <td>:</td>
		  <td><?php echo $row2['nama_pegawai'] ?></td>
	  </tr>
		<?php 
		if(!empty($jawapan_agensi))
		{
		?>	  
	  
		<tr><td width=299>&nbsp;&nbsp;&nbsp;&nbsp;Jawapan</td>
		<td width=17>:</td>
		<td width="643"><a href="" onclick="<?php echo $state_per ?>=collapse(<?php echo $state_per ?>,<?php echo $div ?>,<?php echo $img_collapse ?>);return false;"><img id="<?php echo $img_collapse ?>" name="<?php echo $img_collapse ?>" src="../images/expand.gif" border="0"/></a></td>
		</tr>
		<?php 
		}
		?>	
		<tr>
		  <td colspan="3">
			<div id="<?php echo $div ?>" name="<?php echo $div ?>" style="padding:10px;width:100%;display:none">
   				<?php createRTF($sBasePath, $jwpn, $jawapan_agensi);?>			  
			</div>		  </td>
	  </tr>
		<tr><td width=299>&nbsp;&nbsp;&nbsp;&nbsp;Lampiran</td>
		<td width=17>:</td>
		<td>
		<?php //display the attachments if any				
			$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id='$jawapan_id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
			?>		</td></tr>

		<?php 

		if($status==10) // utk view catatan dr HEK - pindaan
		{
			$query = "select catatan from bahas_agensi where id='$jawapan_id'";
			$re = mysql_query($query,$conn);
			$row4 = mysql_fetch_array($re);
			$catatan_agensi = $row4['catatan'];
			if(!empty($catatan_agensi))
			{
			?>
		
			<tr><td width=299>&nbsp;&nbsp;&nbsp;&nbsp;Catatan</td>
			<td width=17>:</td>
			<td><?php echo $catatan_agensi ?></td></tr>
			<?php } 
		}?>
	</table>
	<br />
	<?php
		$editable= ($_SESSION['nama']==$row2['nama_pegawai']);
		
		//if((($status==21 && $isPegawai) || ($status==22 && $isPegawai)) && empty($jawapan_agensi)){
		//	echo "<a href=\"\" onClick=\"edit_jawapan_bahas($id,$jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			//echo $jawapan_id.$status;
		//}elseif(($status==10 && $isPegawai) && $editable && ($status_pindaan==0)){
		//	echo "<a href=\"\" onClick=\"edit_jawapan_bahas($id,$jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
		//}

	?>
</div>
</fieldset>
<?php } 

	if(($isPegawai && empty($tkh_terima)) || ($isPegawai && $status==10 && $status_pindaan==0))
	{
 		include("form_agensi_bahas.php");
	}
 } 
//while ?>