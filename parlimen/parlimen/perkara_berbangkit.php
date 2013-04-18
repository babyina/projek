<script language="javascript">
	var perkara = 1;
</script>
<?php
include("query_bahas.php");
include("../js/FCKeditor/fckeditor.php");
//_________________________________________________ PERKARA BERBANGKIT ____________________________________________________________


if($_POST['TambahPerkaraBerbangkit']){ // NEW PERKARA BERBANGKIT
		$id = $_GET['id'];
		$key = $keyword[20];
		$qry = "SELECT sesi FROM sesi_bahas WHERE id='$id'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$sesi_dewan = $row['sesi'];
		if($sesi_dewan=="Dewan Negara")
			$sesi = 2;
		else
			$sesi = 1;
		$yb = "";
	?>
<br/>
<form id="berbangkit" name="daftar_form" method="post" onSubmit="if(toValidate) return validateFormPB(this)">
<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>
<fieldset><legend><b>Perkara Berbangkit</b></legend>
	
<input type="hidden" name="nama" value=""/>
<table width="100%" border="0">
<tr><td>&nbsp;&nbsp;</td><td>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="21%"><?php echo $sesi=='2'?"Nama Y.B Senator":"Ahli Yang Berhormat" ?> * </td>
    <td width="1%">:</td>
    <td colspan="2"><select name="YB"><option/><?php PrintSenator($yb,$sesi,$conn,$db_voffice)  ?></select></td>
  </tr>
    <tr>
    <td width="21%">Tarikh Dibahas * </td>
    <td width="1%">:</td>
    <td colspan="2"><input name="Tarikh_Bahas" class="txt" size="15"/>
      &nbsp;<a href='' onClick='popUpCalendar(this, berbangkit.Tarikh_Bahas, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar1" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
    </tr>
    <tr>
    <td colspan="4">
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td>Tajuk * </td>
      <td>:</td>
      <td colspan="2">
        <input name="Tajuk" type="text" size="60" class="txt" /></td>
    </tr>
    <tr>
      <td>Perkara Yang Dibangkitkan * </td>
      <td>:</td>
      <td colspan="2"><?php createRTF($sBasePath, 'Perkara', $per);?>        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
    <td width="21%">Jawab Sebelum/Pada * </td>
    <td width="1%">:</td>
    <td colspan="2">
      <input name="Tarikh_Jawab" class="txt" size="15"/>
      <a href='' onclick='popUpCalendar(this, berbangkit.Tarikh_Jawab, &quot;dd/mm/yyyy&quot;);return false'><img src="../images/calendar.gif" alt="Pilih Tarikh" name="imgCalendar2" width="34" height="21" border="0" id="imgCalendar" /></a><br /></td>
  </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Untuk Tindakan * </td>
      <td>:</td>
      <td width="45%"><?php getAgensi($agensi,$conn,"Bahagian Kementerian Kesihatan") ?></td>
      <td width="33%">        <?php getAgensi($agensi,$conn,"Agensi") ?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
    <td width="21%">Salinan Kepada </td>
    <td width="1%">:</td>
    <td><?php $key = $keyword[20];getSalinan($salinan,$key,$conn) ?></td>
    <td>&nbsp;</td>
    </tr>
</table>  
</td></tr>
</table>
<br></fieldset><br /><br />&nbsp;
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
<input type="submit" value="SIMPAN" name="SimpanPerkaraBerbangkit" class="button" onClick="toValidate=false"/>
<input type="submit" value="SIMPAN & HANTAR" name="SimpanHantarPerkaraBerbangkit" class="button" onClick="toValidate=true"/>
</form>
</div>


	<?php
	
//----------------------------------------- INSERT PERKARA BERBANGKIT ---------------------------------------------------
	
}elseif($_POST['SimpanPerkaraBerbangkit']){	//SIMPAN
	$id = $_GET['id'];
	$YB=addslashes($_POST['YB']);
	$Tajuk=addslashes($_POST['Tajuk']);
	$Perkara=addslashes($_POST['Perkara']);
	$tkh_jawab = $_POST['Tarikh_Jawab'];
	$tkh_dibahas = MysqlDate($_POST['Tarikh_Bahas']);
	$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$qry_insert = "INSERT INTO sesi_bahas_detail(bahas_id,yb,tkh_dibahas,tkh_jwb,tajuk,perkara,jawapan,salinan,agensi,created_by,created_on) 
				VALUES ('$id','$YB','$tkh_dibahas','$tkh_jawab','$Tajuk','$Perkara','$Jawapan','$salinan','$agensi','$current_user','$current_time')";
	$result = mysql_query($qry_insert) or die(mysql_error());
	
	echo $save_record_msg;
	echo $msg1;
	// header("Location:".$_SERVER['PHP_SELF']."?mode=SesiBahas&action=details&id=".$Pid);
}
//----------------------------------------- INSERT PERKARA BERBANGKIT ---------------------------------------------------
	
elseif($_POST['SimpanHantarPerkaraBerbangkit']){	//SIMPAN
	$cid = $_GET['cid'];
	$id = $_POST['id'];
	$YB=addslashes($_POST['YB']);
	$Tajuk=addslashes($_POST['Tajuk']);
	$Perkara=addslashes($_POST['Perkara']);
	$tkh_jawab = $_POST['Tarikh_Jawab'];
	$tkh_dibahas = MysqlDate($_POST['Tarikh_Bahas']);
	$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$isNewSub = ($_GET['action']=='newsub')?true:false;
	$status = "21";
	if($isNewSub){	
		$qry = "INSERT INTO sesi_bahas_detail(bahas_id,yb,tkh_dibahas,tkh_jwb,tajuk,perkara,jawapan,salinan,agensi,created_by,created_on) 
			VALUES ('$id','$YB','$tkh_dibahas','$tkh_jawab','$Tajuk','$Perkara','$Jawapan','$salinan','$agensi','$current_user','$current_time')";
		mysql_query($qry,$conn) or die(mysql_error());
		$cid = mysql_insert_id();
	}else{
		$qry = "UPDATE sesi_bahas_detail SET bahas_id='$id',yb='$YB',tkh_dibahas='$tkh_dibahas',tkh_jwb='$tkh_jawab',tajuk='$Tajuk',perkara='$Perkara',jawapan='$Jawapan',salinan='$salinan',
		agensi='$agensi',created_by='$current_user',created_on='$current_time' WHERE ref_no = '$cid'";
		mysql_query($qry,$conn) or die(mysql_error());
	}	
	
	//tukar status
	$qry = "UPDATE sesi_bahas SET status='$status' WHERE  id = '$id'";
	mysql_query($qry,$conn) or die(mysql_error());
	
	//------- create new record for every agensi in table parlimen_agensi ------------------
	$agensi= explode("+",$agensi);
	
	foreach($agensi as $agensi_id){		
		$query = "SELECT nama_pegawai FROM bahas_agensi WHERE bahas_id='$cid' AND agensi_id='$agensi_id'";
		$result = mysql_query($query,$conn) or die(mysql_error());	
		
		if(mysql_num_rows($result)==0){
			$qry = "INSERT INTO bahas_agensi (agensi_id,bahas_id,main_id) VALUES ('$agensi_id','$cid','$id')";			
			mysql_query($qry,$conn) or die(mysql_error());
		}
	}
	
	echo "<table width=\"100%\" border=\"0\">";
	//sending emails to agencies
	$perkara = getInfo("sesi_bahas", $id,"tajuk");
	$subject = $nama_sistem." : ".$perkara."\n";
	$url = $link_bahas.$id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	//echo $agensi[0];
	if($msg = sendToPegawai($conn,$agensi,$subject,$message)){
			echo "<tr><td  width=\"5%\"><center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br></td></tr>";
	}

	//sending emails to SK
	if(!empty($salinan)){
		$salinan= explode("+",$salinan);
		if($msg = sendSalinanKepada($conn,$salinan,$subject,$message)){
				echo "<tr><td  width=\"5%\"><center><font class=subheader1><br/> Salinan emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br></td></tr>";
		}
	}

	echo "</table>";
	$msg2 = "<br /><br /><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a>";

	echo $save_record_msg;
	echo $msg2;
}
//----------------------------------------------- EDIT PERKARA BERBANGKIT---------------------------------------------------------

elseif($_POST['EditPerkaraBerbangkit']){	
	$cid = $_GET['cid'];	
	$key = $keyword[20];	
	$qry = "SELECT sesi_bahas_detail.ref_no,sesi_bahas_detail.bahas_id,sesi_bahas_detail.yb AS yb,sesi_bahas_detail.tkh_dibahas,
		sesi_bahas_detail.tkh_jwb,sesi_bahas_detail.tajuk,sesi_bahas_detail.perkara,sesi_bahas_detail.jawapan,sesi_bahas_detail.salinan AS salinan,
		sesi_bahas_detail.agensi AS agensi,sesi_bahas_detail.created_by,sesi_bahas_detail.created_on,sesi_bahas.id,sesi_bahas.sesi 
		FROM  sesi_bahas,sesi_bahas_detail where sesi_bahas_detail.ref_no='$cid' AND sesi_bahas.id = sesi_bahas_detail.bahas_id ";
	$result = mysql_query($qry,$conn) or die(mysql_error());	
	$row = mysql_fetch_array($result);
	$sesi_dewan = $row['sesi'];
	$yb = $row['yb'];	
	$id = $row['bahas_id'];
	$agensi = explode("+",$row['agensi']);
	$salinan = explode("+",$row['salinan']);

	if($sesi_dewan=="Dewan Negara")
		$sesi = 2;
	else
		$sesi = 1;
	//echo $sesi;
	
?>

	<br>
		<div style="font-family:Arial;font-size:9pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></div>

	<form name="berbangkit" method="post" style="margin-left:5px" onSubmit="if(toValidate) return validateFormPB(this)">
	<fieldset><legend><b>Perkara Berbangkit</b></legend>
	<div class="box">
		<br/>
		<table width="100%" border="0">
<tr><td>&nbsp;&nbsp;</td><td>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%"><?php echo $sesi=='2'?"Nama Y.B Senator":"Ahli Yang Berhormat" ?></td>
    <td width="0%">:</td>
    <td colspan="3"><select name="YB"><option/><?php PrintSenator($yb,$sesi,$conn,$db_voffice)  ?></select></td>
  </tr>
    <tr>
    <td width="20%">Tarikh Dibahas</td>
    <td width="0%">:</td>
    <td colspan="3"><input name="Tarikh_Bahas" class="txt" size="15" value="<?php echo Reverse($row['tkh_dibahas']) ?>"/>
      &nbsp;<a href='' onClick='popUpCalendar(this, berbangkit.Tarikh_Bahas, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar1" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
    </tr>
    
    <tr>
      <td>Tajuk</td>
      <td>&nbsp;</td>
      <td colspan="3"><input name="Tajuk" type="text" size="60" class="txt" value="<?php echo $row['tajuk'] ?>"/></td>
    </tr>
    <tr>
      <td>Perkara Yang Dibangkitkan</td>
      <td>&nbsp;</td>
      <td colspan="3">    
          <a href="" onclick="perkara=collapse(perkara,div,img_collapse);return false;"><img id="img_collapse" name="img_collapse" src="../images/expand.gif" border="0"/></a></td>
    </tr>
    <tr>
      <td colspan="5">
		  	<div id="div" name="div" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Perkara', $row['perkara']);?>
			 </div>	  </td>
      </tr>
    <tr>
    <td width="20%">Jawab Sebelum/Pada</td>
    <td width="0%">:</td>
    <td colspan="3">     
	 <input name="Tarikh_Jawab" class="txt" size="15"value="<?php echo $row['tkh_jwb'] ?>"/>
	 <a href='' onclick='popUpCalendar(this, berbangkit.Tarikh_Jawab, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" alt="Pilih Tarikh" name="imgCalendar2" width="34" height="21" border="0" id="imgCalendar" /></a></td>
  </tr>
    <tr>
      <td>Untuk Tindakan </td>
      <td>:</td>
      <td><?php getAgensi($agensi,$conn,"Agensi") ?></td>
      <td><?php getAgensi($agensi,$conn,"Bahagian Kementerian Kesihatan") ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td width="20%">Salinan Kepada </td>
    <td width="0%">:</td>
    <td width="18%"><?php $key = $keyword[20];getSalinan($salinan,$key,$conn) ?></td>
    <td width="49%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    </tr>
</table>  
</td></tr>
</table>
	</div>
</fieldset>
		<br /><br />
		<input type="hidden" name="id" value="<?php echo $id ?>"/>
		&nbsp;&nbsp;&nbsp;<input type="submit" name="UpdatePerkaraBerbangkit" value="SIMPAN" class="button" onClick="toValidate=false"/>
		<input type="submit" value="SIMPAN & HANTAR" name="SimpanHantarPerkaraBerbangkit" class="button" onClick="toValidate=true"/>
		<br/><br/>
	
	</form>	

<?php 
	
}
//-------------------------------------------------- UPDATE PERKARA BERBANGKIT ---------------------------------------------------

//edit maklumat lanjut

elseif($_POST['UpdatePerkaraBerbangkit']){	//EDIT
	$cid = $_GET['cid'];
	$id = $_POST['id'];
	$YB=addslashes($_POST['YB']);
	$Tajuk=addslashes($_POST['Tajuk']);
	$Perkara=addslashes($_POST['Perkara']);
	$tkh_jawab = $_POST['Tarikh_Jawab'];
	$tkh_bahas = MysqlDate($_POST['Tarikh_Bahas']);
	$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$qry_update = "UPDATE sesi_bahas_detail SET yb='$YB',tkh_dibahas='$tkh_bahas',tkh_jwb='$tkh_jawab',tajuk='$Tajuk',perkara='$Perkara',jawapan='$Jawapan',salinan='$salinan',agensi='$agensi',modified_by='$current_user',modified_on='$current_time' WHERE ref_no='$cid'";

	$result = mysql_query($qry_update) or die (mysql_error());
	echo $update_record_msg;
	echo "<br/><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a>";
}
