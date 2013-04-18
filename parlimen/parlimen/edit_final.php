<script language="javascript">
	var state_jaw = 1;
	var state_tamb = 1;
</script>
<?php
session_start();
include("../js/FCKeditor/fckeditor.php");
$current_time = date("d-m-Y G:i:s");
//if(checkACL($_SESSION['userid'],3,null,$conn) == false){ asal 23 jan 2009
if((checkACL($_SESSION['userid'],5,null,$conn) == false)&&(checkACL($_SESSION['userid'],4,null,$conn) == false)&&(checkACL($_SESSION['userid'],8,null,$conn) == false)&&(checkACL($_SESSION['userid'],3,null,$conn) == false)){
	echo "capaian tidak sah !";	
}else{	

	$parlimen_id = $_POST['parlimen_id'];
	//$agensix = $_POST['agensik']; 
			
	$qry = "SELECT korperat_jawapan,korperat_tambahan,catatan_final,agensi,no_soalan,created_by FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row21 = mysql_fetch_array($result);
	//$agensix = $_POST['agensik']; 
	?><br />
	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
    <?php include("inc_butirSoalan.php"); ?>	
	 <br> 
      <?php include("jawapan_agensi.php"); ?>	
	 <br> 
	<form name="edit_jawapan3" method="post" onSubmit="if(toValidate) return <?php if($isPengurusan){?>validateFormFinal(this)<?php } else {?>validateFormFinalksp(this)<?php }?>">
	<br />
	<fieldset style="width:auto ">
	<!--<legend><b>Jawapan Akhir Hal Ehwal Korperat</b></legend>-->
	<legend><b>Jawapan Akhir Diluluskan</b></legend> 
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			<td width=196>Jawapan</td>
			<td width=3>:</td>
			<td width="772">
				<?php createRTF($sBasePath, 'Jawapan_Final', $row21['korperat_jawapan']);?>
			</td>
			</tr>
			
			<tr>
				<td width=196>Maklumat Tambahan</td><td width=3>:</td>
				<td>
				<?php createRTF($sBasePath, 'Korperat_Tambahan', $row21['korperat_tambahan']);?>
				</td>
			</tr>
			
			<!--<tr valign="top"><td width=196>Catatan4</td><td width=3>:</td><td><textarea name="Catatan_Final" rows=5 cols=55><?php echo $row21['catatan_final'] ?></textarea></td></tr>-->
			<!--<tr><td width=196>Lampiran4</td><td width=3>:</td><td>
			<?php //display the attachments if any
			//$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$parlimen_id'";
			//$res = mysql_query($qry,$conn);
			//while($row3 = mysql_fetch_array($res)){
				//$nama_fail = $row3['nama_fail'];
				////echo $parlimen_id;
				//echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			//}
			?>
			</td></tr>-->
		  <tr>
		    <br>
		    <td colspan="3"><br /><br />
	          <!--font class="current_user">Nama Pegawai Bertugas : <!--?php echo  $_SESSION['nama']."  ".$current_time ?></font><br /><br />
			<!--jamlee edited-->  
			<?php
			$qry_sub = "SELECT emel FROM pengguna WHERE agensi_id='".$row21['agensi']."' and jawatan LIKE '%sub%' LIMIT 1";
			$result_sub = mysql_query($qry_sub,$conn) or die(mysql_error());
			$row_sub = mysql_fetch_array($result_sub);

			$qry_coor = "SELECT emel FROM pengguna WHERE id = '".$row21['created_by']."' LIMIT 1";
			$result_coor = mysql_query($qry_coor,$conn) or die(mysql_error());
			$row_coor = mysql_fetch_array($result_coor);

			//echo $qry_coor."<br>";
			
			if(!empty($row_sub['emel']))
			{
				$address_sub.= $saps_sub.$row_sub['emel'];			
				$saps_sub = ",";
			}
			
			if(!empty($row_coor['emel']))
			{
				$address_coor.= $saps_coor.$row_coor['emel'];			
				$saps_coor = ",";
			}

			
			echo "<input readonly type=\"hidden\" name=\"sub_email\" value='".$address_sub.",".$address_coor."' />";
		
			?>
						  
			  <?php
				function getSalinan($salinan,$key,$conn){
		
				//$temp = array("ANGGOTA PENTADBIRAN","KSU","TKSU(O)","TKSU(P)");
		
				$temp = array();	
				$qry = "SELECT kod,butiran FROM konfigurasi WHERE kategori = '$key' order by id";
				$result= mysql_query($qry,$conn) or die(mysql_error());
			
				while($row = mysql_fetch_array($result))
				{
				$checked = "";
				$butiran = $row[butiran];
				$kod = $row[kod];
			
				$td = "<input readonly=\"readonly\" style=\"visibility:hidden\" checked=\"checked\" type=\"checkbox\" name=\"salinan[]\" value=\"$butiran\">"; 
				echo $td;			
			
					}
				}
			?>
			
			<?php 
			//$ap	= lookup($conn, 'konfigurasi', 'butiran', "kategori='Anggota Pentadbiran'");
			$key = $keyword[20];
			getSalinan($salinan,$key,$conn);
			
			?>
<!--jamlee edited-->
			</td>
		  </tr>
			
		</table>
	</div>
	</fieldset>	<br /><br />
	<table width="200" border="0">
      <tr>
        <td>
		<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
		<input type="hidden" name="agensi" value="<?php echo $row21['agensi']; ?>"/>
		<input type="hidden" name="no_soalan" value="<?php echo $row21['no_soalan']; ?>"/>
        <input type="hidden" name="jawapan_" id="jawapan_"/ >
  <input type="hidden" name="mak_tamb_" id="mak_tamb_"/ >
		&nbsp;&nbsp;&nbsp;<input class="button" name="SimpanJawapanAkhir" type="submit" value="SIMPAN" onClick="toValidate=true"/>
		</td>
      <td><input class="button" name="SimpanHantarJawapanAkhir" type="submit" value="TEKS AKHIR" onclick="toValidate=true"/>
		<!--<td><input class="button" name="SimpanHantarJawapanAkhir" type="button" value="TEKS AKHIR" onclick="validateFormFinal(this)"/>-->
        </table>
      </form>
		</td>

      </tr>
    </table>
		
<?php } ?>

