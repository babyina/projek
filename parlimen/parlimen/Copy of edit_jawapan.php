<script language="javascript">
	var state = 1;
	var jaw_agensi = 1;
</script>
<?php
session_start();
include("../js/FCKeditor/fckeditor.php");

//$penyemak = $row['penyemak'];
//$_POST['salinan']?$_POST['salinan']:explode("+",$row['penyemak']);		
//$salinantksp =$row['penyemak'];		

//echo "semak".$salinantksp;

$current_time = date("d-m-Y G:i:s",time()+(8*3600));
if(checkACL($_SESSION['userid'],2,$_SESSION['agensi_id'],$conn) == false){
	echo "capaian tidak sah !";	
}else{
	$parlimen_id = $_POST['parlimen_id'];	
	$agensi_id = $_SESSION['agensi_id'];
	$userid = $_SESSION['userid'];
	
	//$parlimen_id = $_POST['parlimen_id'];	
	$penyemaktksp=array();
	$qrysmk = "SELECT penyemak from parlimen where id ='$parlimen_id'";
			
	$resultsmk = mysql_query($qrysmk,$conn);
	$biltksp = mysql_num_rows($resultsmk);
	$rowsmk = mysql_fetch_array($resultsmk);
	if (($biltksp) > 1)
	{
	$penyemaktksp[] =$rowsmk['penyemak'];	
	  }
	  else
	  {
	$qrysmk2 = "SELECT tksp from agensi where id ='$agensi_id'";
			
	$resultsmk2 = mysql_query($qrysmk2,$conn);
	
	$rowsmk2 = mysql_fetch_array($resultsmk2);
	$penyemaktksp[] =$rowsmk2['tksp'];	  
	  }
	  //if (empty($penyemaktksp))
	 // {
	 // echo "tksp zero";
	 // }
	//echo "parid".$parlimen_id;
	//select pegawai agensi yang terlibat
	//$qry = "SELECT id,nama,agensi_id FROM pengguna
			//WHERE agensi_id = '$agensi_id' AND id = '$userid'";
			
	//$result = mysql_query($qry,$conn) or die(mysql_error());
	//$row2 = mysql_fetch_array($result);
    $qry = "SELECT id,agensi_id,nama_pegawai,jawapan,tambahan,keterangan_tambahan,penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan,penyedia_no_tel_pej,penyedia_no_hp,pengesah_no_tel_pej,pengesah_no_hp,disemak_oleh,penyemak_jawatan,penyemak_no_tel_pej,penyemak_no_hp 
			FROM parlimen_agensi WHERE parlimen_id='$parlimen_id'";
			//FROM parlimen_agensi WHERE id='$jawapan_id'";
	$result = mysql_query($qry,$conn);
	$row3 = mysql_fetch_array($result);
	$jawapan_id=$row3['id'];
	$nama = $_SESSION['nama'];
	$nama_peg = $row3['nama_pegawai'];
	//echo $nama;
	//echo  $qry;
	//echo $jawapan_id;
	//echo $nama_pegawai;
	$jawapan = $row3['jawapan'];
	$tambahan = $row3['tambahan'];

	?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style3 {color: #FF0000; font-style: italic; }
.style4 {
	color: #0000FF;
	font-style: italic;
}
-->
</style>

<BR />
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
	<br>
	<?php include("inc_butirSoalan.php"); 

		$salinan = explode("+",$row['salinan']);

		$qry_agensi_id = "SELECT agensi_id FROM pengguna WHERE nama='".$_SESSION['nama']."' and jawatan='".$_SESSION['jawatan']."' LIMIT 1";
		$result_agensi_id = mysql_query($qry_agensi_id,$conn) or die(mysql_error());
		$row_agensi_id = mysql_fetch_array($result_agensi_id);
		//echo $row_agensi_id['agensi_id']; 


		$qry_sub = "SELECT jawatan FROM pengguna WHERE agensi_id='".$row_agensi_id['agensi_id']."' and (jawatan LIKE '%sub%' or jawatan LIKE '%Ketua Pengarah%' or jawatan LIKE '%PBB%' or jawatan LIKE '%PEGUAM%' or jawatan LIKE '%KUAD%' or jawatan LIKE '%Pengarah Projek%' ) LIMIT 1";
		//$qry_sub = "SELECT jawatan FROM pengguna WHERE jawatan LIKE '%TKSP%' LIMIT 1";
		$result_sub = mysql_query($qry_sub,$conn) or die(mysql_error());
		$row_sub = mysql_fetch_array($result_sub);
		
		$sub_jawatan = $row_sub['jawatan'];		

		function getSalinan($salinan,$conn,$sub_jawatan){
		
		//echo "Salinan".$salinan;
		$temp = array("KETUA UNIT KHAS","PSU UNIT KHAS","SUB BCP","TBCP",$sub_jawatan);		//$salinan = explode("+",$salinan);

		while(list( ,$value) = each($temp)){
						
			$checked = "";
			foreach($salinan as $key){
				if($key == $value){
						$checked = "checked";
					}
				if($value == "KETUA UNIT KHAS" or $value == "PSU UNIT KHAS"){
						$checked = "checked";
					}

				}						
				
			$td = "<span style=\"width=200px\"><input $checked type=\"checkbox\" name=\"salinan[]\" value=\"$value\">".$value."</span><br>"; 
			if($value!=NULL){
			echo $td;
			}
		}
		}
		function getTKSP($def,$conn,$kategori){ //checkbox
	   $qry = "SELECT * FROM pengguna WHERE jawatan LIKE '%TKSP%' and jawatan not LIKE 'pa%'";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
			$id = $row['jawatan'];
			$checked = "";
			if(is_array($def)){
				foreach($def as $key){
				 
					if($key == $id){
						$td = "<input readonly type=\"text\" name=\"tksp[]\" value=\"$id\">";
						echo $td;
					}
				}
			}
			
			 
			//echo $td;
		}
		
	}
	
	?>
<SCRIPT LANGUAGE="JavaScript">
function verify() {
var themessage = "Sila Isikan Maklumat Berikut: ";
/*var valid, el, els = document.getElementsByName("tksp[]"); 
var j=0;	
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			j=j+1;
			valid = true;
		}
	} 	

	if(valid==false )
	{
		alert("Sila pilih Untuk Tindakan");
		return(false);
	}
    else
	 if(valid==true && j > 1)
	{
		alert("Sila pilih satu pilihan Tindakan sahaja");
		return(false);
	}
*/
if (document.edit_jawapan.penyedia_nama.value=="") {
themessage = themessage + " - Disediakan Oleh";
}
if (document.edit_jawapan.penyedia_jawatan.value=="") {
themessage = themessage + " -  Jawatan";
}
if (document.edit_jawapan.penyedia_no_tel_pej.value=="") {
themessage = themessage + " - No. Tel. Pejabat";
}

if (document.edit_jawapan.disemak_oleh.value=="") {
themessage = themessage + " - Disemak Oleh";
}
if (document.edit_jawapan.penyemak_jawatan.value=="") {
themessage = themessage + " -  Jawatan";
}
if (document.edit_jawapan.penyemak_no_tel_pej.value=="") {
themessage = themessage + " - No. Tel. Pejabat";
}
if (document.edit_jawapan.penyemak_no_hp.value=="") {
themessage = themessage + " - No. HP. Penyemak";
} 
if (document.edit_jawapan.pengesah_nama.value=="") {
themessage = themessage + " - Disahkan Oleh";
}
if (document.edit_jawapan.pengesah_jawatan.value=="") {
themessage = themessage + " -  Jawatan";
}
if (document.edit_jawapan.pengesah_no_tel_pej.value=="") {
themessage = themessage + " - No. Tel. Pejabat";
}

if (themessage != "Sila Isikan Maklumat Berikut: ") {
alert(themessage);
return false;
} else {
edit_jawapan.submit();
  	   }
	   


	   
}
</script>
<script type='text/javascript'>
function isNumeric(elem, helperMsg,variable){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.value = "";
		//elem.focus();
		return false;
	}
}



</script>
<form name="edit_jawapan" enctype="multipart/form-data" method="post" onsubmit="if(toValidate) return verify();">
	<fieldset>
	<legend><b> Jawapan Bahagian/Agensi</b></legend>
	<div class="sub">
		<table border=0 width="100%">
		<?php //echo $jawapan_id."<br>" ?>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name="Perkara" type="hidden" id="Perkara" value="<?php echo $_POST['Perkara'];?>" />
			  <input name="no_soalan" type="hidden" id="no_soalan" value="<?php echo $_POST['NoSoalan'];?>" />	</td>
		  </tr>
			<tr>
			  <td width=198><br />
		      Bahagian/Agensi</td>
			  <td width=3><br />
		      :</td><td width="770"><br />
		        <font class="fs"><?php echo $_SESSION['agensi'] ?></font></td></tr>
			<tr><td width=198><br />
			  Disediakan Oleh</td><td width=3><br />
			  :</td><td><br /><input class="txt" type="text" name="penyedia_nama" size="35" value="<?php echo $row3['penyedia_nama'] ?>">
			  <font class="fs"><span class="style1">*</span>
			  <?php //echo "&nbsp;&nbsp;(jika ada)"; ?></font></td>
			</tr>
			<tr><td width=198>Jawatan</td><td width=3>:</td>
			<td> <input class="txt" type="text" name="penyedia_jawatan" size="35" value="<?php echo $row3['penyedia_jawatan'] ?>">
			  <font class="fs"><span class="style1">*</span></font></td>
			</tr>
			<tr>
			  <td>No. Tel. Pejabat </td>
			  <td>:</td>
			  <td><input name="penyedia_no_tel_pej" type="text" class="txt" id="penyedia_no_tel_pej" value="<?php echo $row3['penyedia_no_tel_pej'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('penyedia_no_tel_pej'), 'Masukkan Nombor Sahaja','penyedia_no_tel_pej')" />
		      <font class="fs"><span class="style1">*</span></font></td>
		  </tr>
			<tr>
			  <td>No. H/P </td>
			  <td>:</td>
			  <td><input name="penyedia_no_hp" type="text" class="txt" id="penyedia_no_hp" value="<?php echo $row3['penyedia_no_hp'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('penyedia_no_hp'), 'Masukkan Nombor Sahaja','penyedia_no_hp')" /></td>
		  </tr>
			<tr>
              <td>Disemak Oleh </td>
			  <td>:</td>
			  <td><input name="disemak_oleh" type="text" class="txt" id="disemak_oleh" value="<?php echo $row3['disemak_oleh'] ?>" size="35" />
		      <font class="fs"><span class="style1">*</span></font></td>
		  </tr>
			<tr>
              <td>Jawatan</td>
			  <td>:</td>
			  <td><input name="penyemak_jawatan" type="text" class="txt" id="penyemak_jawatan" value="<?php echo $row3['penyemak_jawatan'] ?>" size="35" />
		      <font class="fs"><span class="style1">*</span></font></td>
		  </tr>
			<tr>
              <td>No. Tel. Pejabat </td>
			  <td>:</td>
			  <td><input name="penyemak_no_tel_pej" type="text" class="txt" id="penyemak_no_tel_pej" value="<?php echo $row3['penyemak_no_tel_pej'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('penyemak_no_tel_pej', 'penyemak_no_tel_pej'), 'Masukkan Nombor Sahaja')"  />
		      <font class="fs"><span class="style1">*</span></font></td>
		  </tr>
			<tr>
              <td>No. H/P </td>
			  <td>:</td>
			  <td><input name="penyemak_no_hp" type="text" class="txt" id="penyemak_no_hp" value="<?php echo $row3['penyemak_no_hp'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('penyemak_no_hp'), 'Msukkan Nombor Sahaja', 'penyemak_no_hp')"/></td>
		  </tr>
			<tr><td width=198>Disahkan Oleh</td><td width=3>:</td>
			<td> <input class="txt" type="text" name="pengesah_nama" size="35" value="<?php echo $row3['pengesah_nama'] ?>">
			  <font class="fs"><span class="style1">*</span></font><font class="fs"><?php //echo "&nbsp;&nbsp;(jika ada)"; ?></td>
			</tr>
			<tr><td width=198>Jawatan</td><td width=3>:</td>
			<td> <input class="txt" type="text" name="pengesah_jawatan" size="35" value="<?php echo $row3['pengesah_jawatan'] ?>">
			  <font class="fs"><span class="style1">*</span></font></td>
			</tr>
			<tr>
              <td>No. Tel. Pejabat  </td>
			  <td>:</td>
			  <td><input name="pengesah_no_tel_pej" type="text" class="txt" id="pengesah_no_tel_pej" value="<?php echo $row3['pengesah_no_tel_pej'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('pengesah_no_tel_pej'), 'Masukkan Nombor Sahaja','pengesah_no_tel_pej')"/>
		      <font class="fs"><span class="style1">*</span></font></td>
		  </tr>
			<tr>
              <td>No. H/P </td>
			  <td>:</td>
			  <td><input name="pengesah_no_hp" type="text" class="txt" id="pengesah_no_hp" value="<?php echo $row3['pengesah_no_hp'] ?>" size="35" maxlength="10" onblur="isNumeric(document.getElementById('pengesah_no_hp'), 'Masukkan Nombor Sahaja','pengesah_no_hp')"/></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><span class="style3">*</span><span class="style4"> Maklumat Wajib Diisi</span></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td></td>
		  </tr>
			<tr>
			<td width=198>Jawapan</td>
			<td width=3>:</td>
			<td>		 </td>
			</tr>
			<tr>
			<td width=198></td>
			<td width=3></td>
			  <td>
				 <?php createRTF($sBasePath, 'Jawapan', $jawapan);?>			 </td>
		  </tr>
			<tr><td width=198>Maklumat Tambahan</td><td width=3>:</td>
			<td>			</td>
			</tr>
			
			<tr>
			<td width=198></td>
			<td width=3></td>
			  <td>
			  				 <?php createRTF($sBasePath, 'Tambahan', $tambahan);?>			 		  </td>
			<?php if ($status==10){  // view keterangan tambahan pd mode pindaan HEK sahaja  ?>			  
		  </tr>
			<tr><td width=198>Keterangan Tambahan</td><td width=3>:</td>
			<td><textarea name="Keterangan_Tambahan" rows=5 cols=65><?php echo $row3['keterangan_tambahan'] ?></textarea></td></tr>
			<?php } ?> 
			
			<tr><td width=198>&nbsp;</td><td width=3>&nbsp;</td>
			<td>&nbsp;</td></tr>
			<tr><td>Lampiran</td>
			  <td>:</td>
			  <td><input id="my_file_element" type="file" name="file_1" >&nbsp;<br />
			 <?php //display the attachments if any				
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id='$jawapan_id'"; 
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				
				echo "<input type=\"checkbox\" name=\"nama_fail[]\" value=\"$nama_fail\"/>";
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a>&nbsp;&nbsp;";
				echo "<input type=\"submit\" value = \"Hapus\" name=\"hapuslampiran\" class=\"button\"/><br>";
			
			//$lampiran_id = $row['lampiran_id'];
			//$path = "../parlimen/lampiran/$nama_fail";
			
			
			//echo "<tr><td><a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br></td>";
			//echo "<td><input type=\"submit\" value = \"Hapus\" name=\"Edit_RekodLama\" class=\"button\"/></td>";
			//echo "<input type=\"hidden\" name=\"lampiran_id\" value=\"$lampiran_id\"/>";
			
			
			
			}
			?></td></tr>
			  <tr>
			    <td></td>
			    <td></td>
			    <td>&nbsp;</td>
	      </tr>
		  <?php    //$flag="true";
		  
		    if ($status <> 12)
			 { 	  
		          if ($status <> 15){
				
				   if ($status <> 18){
		         
					
					//echo "flg".$flag; 
		   ?>
			  <tr>
			    <td width="198">Semakan</td>
			    <td>:</td>
			    <td>
			<?php  //echo  "jaw sta".$status;
			$key = $keyword[20];
			//getSalinan($salinan,$key,$conn,$sub_jawatan);
 			  getTKSP($penyemaktksp,$conn,$sub_jawatan);
			?>			</td>
	      </tr>
		  <?php } 
		  }
		  }?>
			  <tr><td width=198></td><td width=3></td>
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
			<!-- <tr><td colspan="3">
			 <p><br /> 
		     <font class="current_user">Nama Pegawai Bertugas : <?php echo $nama."  ".$current_time ?></font><br />
			 </p>			 </td></tr>		--> 
		</table>		
		
	</div>
	</fieldset>
	
	<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>" />
	<input type="hidden" name="jawapan_id" value="<?php echo $jawapan_id ?>" />
	<input type="hidden" name="nama_pegawai" value="<?php echo $_SESSION['nama']?>" />
	<input type="hidden" name="status" value="<?php echo $status ?>" />
	<input type="hidden" name="no_telefon" value="<?php echo $row2['telefon'] ?>" />
	<br />
	<br />
	&nbsp;&nbsp;
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
	<input type="hidden" name="NoSoalan" value="<?php echo $_SESSION['no_soalan'] ?>"/>
	<input type="hidden" name="Perkara" value="<?php echo $_SESSION['perkara'] ?>"/>
		<input class="button" name="SimpanJawapan" type="submit" value="SIMPAN" onClick="toValidate=false;simpan=true"/>
		<?php if ( ($status <> 12) && ($status <> 15) && ($status <> 18))
		{ ?>
        <input class="button" name="SimpanDanHantarJawapan" type="submit" value="SIMPAN & HANTAR" onclick="toValidate=true;simpan=false "/> 
  <!--code by zaidi on 4/10/2010/ base on sop BCP -->
<?php }else{ ?>
	<!--<input class="button" name="SimpanDanHantarJawapan" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=false;simpan=false "/> code by zaidi on 4/10/2010/ base on sop BCP-->
	<?php } ?>
</form></div> 
<?php } ?>
<!-- jamlee edited -->
