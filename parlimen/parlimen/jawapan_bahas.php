
<script language="javascript">
	var jawapan = 1;
	var tamb = 1;
	var ket = 1;
</script>

<?php
session_start();
include("../js/FCKeditor/fckeditor.php");
$current_time = date("d-m-Y G:i:s");
if(checkACL($_SESSION['userid'],2,$_SESSION['agensi_id'],$conn) == false){
	echo "capaian tidak sah !";	
}else{
	$cid = $_GET['cid'];	
	$agensi_id = $_SESSION['agensi_id'];
	$userid = $_SESSION['userid'];
	
if($_POST['EditJawapanBahas']){
	//select pegawai agensi yang terlibat
	//$qry = "SELECT id,nama,agensi_id FROM pengguna
			//WHERE agensi_id = '$agensi_id' AND id = '$userid'";
			
	//$result = mysql_query($qry,$conn) or die(mysql_error());
	//$row2 = mysql_fetch_array($result);
	
	$qry = "SELECT agensi_id,nama_pegawai,jawapan,tambahan,keterangan_tambahan,penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan 
			FROM bahas_agensi WHERE id='$jawapan_id'";
	$result = mysql_query($qry,$conn);
	$row3 = mysql_fetch_array($result);
	
	$nama = $_SESSION['nama'];

	?>
<style type="text/css">
<!--
.style1 {color: #0080C0}
-->
</style>
<br />
<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>

	<form name="edit_jawapanb" enctype="multipart/form-data" method="post">
	<fieldset>
	<legend><b>Jawapan Agensi </b></legend>
	<div class="sub">
		<table border=0 width="100%">
	
			<tr><td width=164><br />
			Bahagian/Agensi Kementerian Kesihatan </td>
			  <td width=18><br />
		      :</td><td width="760"><br />
		        <?php echo $_SESSION['agensi'] ?></td></tr>
			<tr><td width=164>Disediakan Oleh</td>
			<td width=18>:</td>
			<td> <input class="txt" type="text" name="penyedia_nama" size="35" value="<?php echo $row3['penyedia_nama'] ?>"></td></tr>
			<tr><td width=164>Jawatan</td>
			<td width=18>:</td>
			<td> <input class="txt" type="text" name="penyedia_jawatan" size="35" value="<?php echo $row3['penyedia_jawatan'] ?>"></td></tr>
			<tr><td width=164>Disahkan Oleh</td>
			<td width=18>:</td>
			<td> <input class="txt" type="text" name="pengesah_nama" size="35" value="<?php echo $row3['pengesah_nama'] ?>"></td></tr>
			<tr><td width=164>Jawatan</td>
			<td width=18>:</td>
			<td> <input class="txt" type="text" name="pengesah_jawatan" size="35" value="<?php echo $row3['pengesah_jawatan'] ?>"></td></tr>

			<tr><td width=164>Jawapan</td>
			<td width=18>:</td>
			<td><a href="" onclick="jawapan=collapse(jawapan,div_jaw,img_collapse);return false;"><img id="img_collapse" name="img_collapse" src="../images/expand.gif" border="0"/></a>			  </td></tr>
			<tr>
			  <td colspan="3">
		  	<div id="div_jaw" name="div_jaw" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Jawapan', $row3['jawapan']);?>
			 </div>			  </td>
		  </tr>
			<tr><td width=164>Maklumat Tambahan</td>
			<td width=18>:</td>
			<td><a href="" onclick="tamb=collapse(tamb,div_tamb,img_collapse2);return false;"><img id="img_collapse2" name="img_collapse2" src="../images/expand.gif" border="0"/></a></td></tr>
			<tr>
			  <td colspan="3">
		  	<div id="div_tamb" name="div_tamb" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Tambahan', $row3['tambahan']);?>
			 </div></td>
		  </tr>
		  	<?php if ($status==10){  // view keterangan tambahan pd mode pindaan HEK sahaja  ?>
			<tr><td width=164>Keterangan Tambahan</td>
			<td width=18>:</td>
			<td><a href="" onclick="ket=collapse(ket,div_ket,img_collapse3);return false;"><img id="img_collapse3" name="img_collapse3" src="../images/expand.gif" border="0"/></a></td></tr>
	
			<tr>
			  <td colspan="3">
		  	<div id="div_ket" name="div_ket" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Keterangan_Tambahan', $row3['keterangan_tambahan']);?>
			 </div>			  </td>
		  </tr>
			<?php } ?> 		  
			<tr><td width=164>Lampiran</td>
			<td width=18>:</td>
			<td><input id="my_file_element" type="file" name="file_1" /></td>
			</tr>
			<tr><td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;
		      <?php //display the attachments if any				
			$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id='$jawapan_id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
			?></td>
			</tr>
			  <tr><td width=164></td>
			  <td width=18></td>
			  <td>
			  
				<!-- This is where the output will appear -->
				<div id="files_list"></div>
				<script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td></tr>
			
			<tr><td colspan="3"></td></tr>
			 <tr><td colspan="3">
			 <p><br> <font class="current_user">Nama Pegawai Bertugas : <?php echo $nama."  ".$current_time ?></font> </p>			 <br>
			 </td></tr>		 
		</table>		
		
	</div>
	</fieldset>
	
	<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>" />
	<input type="hidden" name="jawapan_id" value="<?php echo $jawapan_id ?>" />
	<input type="hidden" name="nama_pegawai" value="<?php echo $_SESSION['nama']?>" />
	<input type="hidden" name="ketua_jabatan" value="<?php echo $row2['ketua_jabatan'] ?>" />
	<input type="hidden" name="no_telefon" value="<?php echo $row2['no_telefon'] ?>" />
	<input type="hidden" name="bahas_id" value="<?php echo $bahas_id ?>"/>
	<input type="hidden" name="status" value="<?php echo $status ?>"/>	
	
	<input class="button" name="SimpanJawapanBahas" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanDanHantarJawapanBahas" type="submit" value="SIMPAN & HANTAR"/>
	</form>
<?php 
}elseif($_POST['SimpanJawapanBahas'])
{
	$bahas_id = $_POST['bahas_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = addslashes($_POST['nama_pegawai']);
	$penyedia_nama = addslashes($_POST['penyedia_nama']);
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$pengesah_nama = addslashes($_POST['pengesah_nama']);
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan = addslashes($_POST['Tambahan']);
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];

	$qry = "UPDATE bahas_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama',
		penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',
		no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan'
		WHERE id='$jawapan_id'";	
	mysql_query($qry,$conn) or die(mysql_error());

	echo "<br /><center>Rekod telah disimpan</center><br />";
	echo "<center><a href=\"index.php?action=detailsbahas&cid=".$cid."\">kembali semula</a></center>";

}elseif($_POST['SimpanDanHantarJawapanBahas'])
{
	$bahas_id = $_POST['bahas_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = addslashes($_POST['nama_pegawai']);
	$penyedia_nama = addslashes($_POST['penyedia_nama']);
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$pengesah_nama = addslashes($_POST['pengesah_nama']);
	$pengesah_jawatan = $_POST['pengesah_jawatan'];
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan =addslashes($_POST['Tambahan']);
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
	$status = $_POST['status'];
	$date = date("Y-m-d");

	include("lampiran_bahas.php");
	
	//echo "bahas id ialah= ".$bahas_id;
	$qry = "UPDATE bahas_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama',
		penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',
		no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',tkh_terima='$date' 
		WHERE id='$jawapan_id'";	
	mysql_query($qry,$conn) or die(mysql_error());

	//check adakah jawapan telah diterima dr semua agensi
	$qry = "SELECT ref_no FROM sesi_bahas_detail WHERE bahas_id = '$bahas_id'";
	$result = mysql_query($qry,$conn);
	while($row = mysql_fetch_array($result)){
		$tid = $row['ref_no'];
		//echo "<br>cid ialah ".$tid;
		$qry2 = "SELECT jawapan FROM bahas_agensi WHERE bahas_id = '$tid'";
		
		$res = mysql_query($qry2,$conn);
		$count = $count + mysql_num_rows($res);
	
		while($rows = mysql_fetch_array($res)){
			if($rows['jawapan']<>NULL || !empty($rows['jawapan']))
				$temp[] = $rows['jawapan'];
		}
	}
	
	if($status==10 && (count($temp)==$count)) //for pindaan agensi only 
	{
	
		$qry = "UPDATE bahas_agensi SET status_pindaan = 1 WHERE id='$jawapan_id'";
		mysql_query($qry,$conn) or die(mysql_error());
		
		//count status-pindaan
		$qry4 = "SELECT ref_no FROM sesi_bahas_detail WHERE bahas_id = '$bahas_id'";
		$result4 = mysql_query($qry4,$conn);
		
		while($row4 = mysql_fetch_array($result4)){
			$ref_no = $row4['ref_no'];
			$qry3 = "SELECT status_pindaan FROM bahas_agensi WHERE bahas_id = '$ref_no'";
			$result3 = mysql_query($qry3,$conn);
			$count2 = $count2 + mysql_num_rows($result3);
		
			while($row = mysql_fetch_array($result3)){
				if($row['status_pindaan']==1)
					$temp2[] = $row['status_pindaan'];
			}
		}	
		if(count($temp2)==$count2) //semua jawapan telah dipinda 
		{
			//update doc status
			$qry3 = "UPDATE sesi_bahas SET status = 3 WHERE id='$bahas_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}		
	}
	
	else
	{
		if(count($temp)==$count) //semua jawapan sudah diterima
		{
			//update doc status
			$qry3 = "UPDATE sesi_bahas SET status = 3 WHERE id='$bahas_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}
	}

	
	
	//if(!empty($error)){
	//	echo "<table border=\"1\">";
	//	for($i=0; $i<count($error); $i++)
	//	{
	//		echo "<tr><td>".$uploaded[$i]."</td><td>".$error[$i]."</td></tr>";
	//	}
	//	echo "</table>";
	//}
	
	echo "<br><center>Rekod telah disimpan</center>";
	echo "<br><br><center><a href=\"index.php?action=detailsbahas&cid=".$cid."\">kembali semula</a></center>";
}
} //else
 ?>
