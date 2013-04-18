
<?php
session_start();
require("query_soalan.php");
$id=$_GET["id"];
$current_time = date("d-m-Y G:i:s");
$date = date("Y-m-d");

if($_POST['EditKorperatBahas'] || $action== 'jawapan'){

if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	
	
	//$cid = $_POST['cid'];
	
	$qry = "SELECT status,tajuk,korperat_jawapan,korperat_tambahan,korperat_catatan FROM sesi_bahas WHERE id='$id'";
	$result = mysql_query($qry,$conn);
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$tajuk = $row['tajuk'];
	//echo $row2['agensi'];
	
	?>
	
	<br /><div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>

  <form method="post" enctype="multipart/form-data" name="edit_jawapann" id="edit_jawapann" onSubmit="if(toValidate) return validateFormKorperatBahas(this)">
  <fieldset>
  <legend><b>Jawapan Hal Ehwal Korperat</b></legend>
  <div class="sub"> 

    <table border="0" width="100%">
	      <?php
#------------------------------------------------- status = 3,21,22,10 -----------------------------------------------------------		
		
		if($status==3){
		?>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td width="179">Pindaan/Pertanyaan</td>
          <td width="35">:</td>
          <td width="231"><input type="radio" name="Pengesahan_Status1" value="0" onclick="RadioSelect(1)" />
            Ya</td>
          <td width="493"><input type="radio" name="Pengesahan_Status2" value="1" onclick="RadioSelect(2)" />
Tidak</td>
        </tr>
        <tr>
          <td width="179">Untuk Tindakan</td>
          <td width="35">:</td>
          <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="483">
		      <tr>
			  <td width="231" bgcolor="#B2DFEE"><?php getAgensiPindaan2($conn, $id); ?></td>
                <td width="252" bgcolor="#B2DFEE">                 
			  <?php
		 
//=====================================================================================================
//      get the list for semakan pengurusan from table konfigurasi. Keyword - Pengurusan Parlimen	
//=====================================================================================================
				$cat = "Pengurusan Parlimen";
				getSemakanParlimen($conn,$cat);		
			
			?>					 
			<br /><br /> <input name="jawapan"  class="button" type="button" value="MASUKKAN JAWAPAN" disabled="disabled" onClick="window.open('../parlimen/form_jawapan.php?action=jawapan&id=<?php echo $id ?>','mywin');return(false);"/><br /><br />				</td>
		      </tr>

          </table></td>
        </tr>
		<tr>
          <td colspan="5">
		  
		  
          <?php	

	}//if status==3
?>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
	    <tr>
          <td width="179">Catatan</td>
          <td width="35">:</td>
          <td colspan="2"><textarea name="Korperat_Catatan" rows="3" cols="58"><?php echo $row['korperat_catatan'] ?></textarea></td><br />
        </tr>	
	<?php
			
	if($status==5||$status==7){
	?>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>	
        <tr>
          <td width="179">Jawapan</td>
          <td width="35">:</td>
          <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="430">
		      <tr>
                <td width="223">                 
				  <input name="jawapan"  class="button" type="button" value="MASUKKAN JAWAPAN" onClick="window.open('../parlimen/form_jawapan.php?action=jawapan&id=<?php echo $id ?>','mywin');return(false);"/><br /><br /></td>
			</tr>

          </table></td>
        </tr>
<?php
	}	
}  ?>         
 </td>
        </tr>
		<tr>
		   <td colspan="4"><br><br><br>
	          <font class="current_user">Nama Pegawai Bertugas : <?php echo  $_SESSION['nama']."  ".$current_time ?></font></td>
		  </tr>
      </table>
    <br />
    <br />
  </div>
  </fieldset>
  <div style="visibility:hidden">
	<input type="submit" value="Edit Korperat" name="EditKorperat"/>
</div>
  <input type="hidden" name="pengesahan_status" value=""/>
  <input type="hidden" name="cid" value="<?php echo $cid ?>"/>
  <input type="hidden" name="bahas_id" value="<?php echo $id ?>"/>
  <input type="hidden" name="status" value="<?php echo $status ?>"/>
  <input type="hidden" name="tajuk" value="<?php echo $tajuk ?>"/>
  <input type="hidden" name="korperat_tarikh" value="<?php echo $date ?>"/>
 &nbsp;&nbsp; <input class="button" name="SimpanKorperatBahas" type="submit" value="SIMPAN" onClick="toValidate=false"/>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php if($status==3||$status==5||$status==7||$status==8){
	?>
  <input class="button" name="SimpanDanHantarKorperatBahas" type="submit" value="SIMPAN &amp; HANTAR" onClick="toValidate=true"/>
</form>

  <?php }
  } 
  
if($_POST['SimpanKorperatBahas'])
{
	$cid = $_POST['cid'];
	$status = $_POST['status'];
	$korperat_tarikh = $_POST['korperat_tarikh'];
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$status_bahas = $_POST['status_bahas'];

	$date = MysqlDate(date("d/m/Y"));
	
	//$qry = "UPDATE sesi_bahas_detail SET jawapan='$korperat_jawapan', maklumat_tambahan = '$korperat_tambahan', lampiran = '$lampiran' WHERE ref_no = '$cid' AND bahas_id='$id'";
	
	$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama', korperat_jawatan = '$korperat_jawatan',korperat_tarikh = '$korperat_tarikh', korperat_catatan = '$korperat_catatan', status = '$status',status_bahas = '$status_bahas' WHERE id = '$id'";
	mysql_query($qry,$conn) or die(mysql_error());
	
	$msg = "Rekod telah disimpan.";
	echo "<br /><center>".$msg."</center><br />";
	echo "<center><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a></center>";
}

if($_POST['SimpanDanHantarKorperatBahas'])
{
	include("simpan_hantar_korperat_bahas.php");
}
?>
