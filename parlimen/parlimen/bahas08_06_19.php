<?php
include("query_bahas.php");
$msg1 = "<br><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a>";

//_________________________________________________ SIMPAN SESI BAHAS __________________________________________________________
		
if($_POST['SimpanBahas']){	//SIMPAN
	$TMula = MysqlDate($_POST['TarikhMula']);	
	$TAkhir = MysqlDate($_POST['TarikhAkhir']);
	$TGulung = MysqlDate($_POST['TkhGulung']);
	$Tajuk = addslashes($_POST['Tajuk']);$Mesyuarat=$_POST['Mesyuarat'];$Penggal=$_POST['Penggal'];
	$Menteri = addslashes($_POST['Menteri']);
	$Parlimen = $_POST['Parlimen'];
	$SesiDewan = $_POST['SesiDewan'];
	$status = 1;
	//echo $current_time;
	//$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	//$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];

	$qry_insert = "insert into 
					sesi_bahas(tajuk,mesyuarat,penggal,tkh_mula,tkh_akhir,tkh_gulung,menteri,sesi,created_by,created_on,parlimen,status) 
					values ('$Tajuk','$Mesyuarat','$Penggal','$TMula','$TAkhir','$TGulung','$Menteri','$SesiDewan','$current_user','$current_time','$Parlimen','$status')";
	
	mysql_select_db($db_voffice,$conn) or die (mysql_error());
	$result = mysql_query($qry_insert) or die (mysql_error());
	echo $save_record_msg;
	$id = mysql_insert_id();
	echo "<br><a href=\"index.php?action=detailsbahas&id=".$id."\">kembali semula</a>";
}
//---------------------------------------------------- REKOD BARU ---------------------------------------------------------

elseif($_GET['action']=='RekodBaru'){
	if($sys_acl<>1 || !($isHEK)){
		echo $acl_denied;
	}
	else{ ?>
		<br />
		<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div>
		<br/>
		<form name="bahas_form" method="post" onSubmit="return validateBahas(this)">
		<fieldset>
			<legend><b>Butir-butir Persidangan</b></legend>
			<div class="box" style="margin-left:5px">
				<table width="100%" border="0">
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Tajuk</td>
					<td width="1%">:</td>
					<td width="69%">
						<select name="Tajuk"><?php Keyword($conn,$query_tajuk,$db_voffice,$Tajuk); ?></select>
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Sesi Dewan</td>
					<td width="1%">:</td>
					<td width="69%"><?php echo getSesiDewanBahas($sesi_dewan) ?></td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Mesyuarat</td>
					<td width="1%">:</td>
					<td width="69%">
						<select name="Mesyuarat"><?php Keyword($conn,$query_mesyuarat,$db_voffice,$Mesyuarat);?></select>
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Penggal</td>
					<td width="1%">:</td>
					<td width="69%">
						<select name="Penggal"><?php Keyword($conn,$query_penggal,$db_voffice,$Penggal); ?></select>
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Parlimen</td>
					<td width="1%">:</td>
					<td width="69%">
						<select name="Parlimen"><?php Keyword($conn,$query_parlimen,$db_voffice,$Parlimen); ?></select>
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Tarikh Mula (*) </td>
					<td width="1%">:</td>
					<td width="69%">
						<input name="TarikhMula" class="txt" id="TarikhMula" value="<?php echo Reverse($tkh_mula_bersidang) ?>" size="15">
						<img src="../images/calendar.gif" onClick='popUpCalendar(this, bahas_form.TarikhMula, "dd/mm/yyyy");return false' name="imgCalendar1" width="34" height="21" border="0" alt="Pilih Tarikh">
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Tarikh Akhir (*)</td>
					<td width="1%">:</td>
					<td width="69%">
						<input name="TarikhAkhir" class="txt" id="TarikhAkhir" value="<?php echo Reverse($tkh_mula_bersidang) ?>" size="15">
						<img src="../images/calendar.gif" onClick='popUpCalendar(this, bahas_form.TarikhAkhir, "dd/mm/yyyy");return false' name="imgCalendar2" width="34" height="21" border="0" alt="Pilih Tarikh">
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Tarikh Penggulungan/Ucapan Penangguhan (*) </td>
					<td width="1%">:</td>
					<td width="69%">
						<input class="txt" name="TkhGulung" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">
						<img onClick='popUpCalendar(this, bahas_form.TkhGulung, "dd/mm/yyyy");return false' src="../images/calendar.gif" name="imgCalendar3" width="34" height="21" border="0" alt="Pilih Tarikh">
					</td>
				</tr>
				<tr>
					<td width="3%">&nbsp;</td>
					<td width="27%">Nama Menteri/Timbalan Menteri/SUPAR</td>
					<td width="1%">:</td>
					<td width="69%">
						<select name="Menteri"><?php displayWakil($default,$conn)?></select>
					</td>
				</tr>
				</table>
			</div>
		</fieldset>
		<input " type="submit" value="SIMPAN" class="button" name="SimpanBahas">
		</form>
	<?php
	}
} //endif rekod baru

//---------------------------------------------------- EDIT SESI BAHAS ---------------------------------------------------------

elseif($_POST['EditBahas']){ //EDIT
	$id = $_GET['id'];
	$result = mysql_query("select * from sesi_bahas where id = '$id'",$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);	
	include('bahas_edit.php');
}//edit

//---------------------------------------------------- UPDATE SESI BAHAS ---------------------------------------------------------


elseif($_POST['UpdateBahas']){ //UPDATE
	$id = $_GET['id'];
	$Parlimen = $_POST['Parlimen'];$Tajuk=$_POST['Tajuk'];$Mesyuarat=$_POST['Mesyuarat'];
	$Penggal = $_POST['Penggal'];$Menteri = $_POST['Menteri'];
	$SesiDewan = $_POST['SesiDewan'];
	$TMula = MysqlDate($_POST['TarikhMula']);		
	$TAkhir = MysqlDate($_POST['TarikhAkhir']);
	$TGulung = MysqlDate($_POST['TkhGulung']);
	$qry_update = "UPDATE sesi_bahas SET parlimen='$Parlimen',tajuk='$Tajuk',mesyuarat='$Mesyuarat',penggal='$Penggal',tkh_mula='$TMula',tkh_akhir='$TAkhir',tkh_gulung='$TGulung',menteri='$Menteri',sesi='$SesiDewan',modified_by='$current_user',modified_on='$current_time' WHERE Id='$id'";
	$result = mysql_query($qry_update) or die (mysql_error());
	echo $update_record_msg;
	echo $msg1;
}//update


elseif($_POST['deletePP']){	//DELETE PERKARA BERBANGKIT
	$cid= $_POST['del'];
	$bahas_id= $_POST['bahas_id'];
	$qry = "DELETE FROM sesi_bahas_detail WHERE ref_no='$cid'";
	mysql_query($qry) or die(mysql_error());

	$qry = "DELETE FROM bahas_agensi WHERE bahas_id='$cid'";
	mysql_query($qry) or die(mysql_error());

	$qry = "DELETE FROM bahas_lampiran WHERE bahas_id='$cid'";
	mysql_query($qry) or die(mysql_error());


	echo $delete_record_msg;
	echo "<br><center><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a></center>";
}
elseif($_POST['deleteDoc']){		//DELETE SESI BAHAS
	//if($_POST['mode']=='SesiBahasMain'){
		$id= $_GET['id'];
		$qry = "DELETE FROM sesi_bahas WHERE id='$id'";
		mysql_query($qry) or die(mysql_error());
		//delete child
		$qry = "DELETE FROM sesi_bahas_detail WHERE bahas_id='$id'";
		mysql_query($qry) or die(mysql_error());
		
		$qry = "DELETE FROM bahas_agensi WHERE main_id='$id'";
		mysql_query($qry) or die(mysql_error());
		
		$qry = "SELECT ref_no FROM sesi_bahas_detail WHERE bahas_id='$id'";
		$result = mysql_query($qry) or die(mysql_error());
		
		if(mysql_num_rows($result)>0)
		{
			while($row = mysql_fetch_array($result)){
				$cid = $row['ref_no'];
				$qry = "DELETE FROM bahas_lampiran WHERE bahas_id='$cid'";
				mysql_query($qry) or die(mysql_error());
			}
		}
		
		echo $delete_record_msg;
		
}//delete record
elseif($_GET['action']=='EditDoc'){
	$id = $_GET['id'];
	$result = mysql_query("select * from sesi_bahas where Id = '$id'",$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);	
	$TMula = DisplayDate($row['TarikhMula']);
	$TAkhir = DisplayDate($row['TarikhAkhir']);
	include('bahas_edit.php');
}//create rekod baru

//---------------------------------------------------- VIEW BY TARIKH ---------------------------------------------------


elseif($_GET['action']=='listbahas' && $_GET['view']=='bytarikh'){
	include("../view.php");
	$view = new View();
	$view->ref = "index.php?action=detailsbahas&id=";
	$view->table = "sesi_bahas";
	$view->limit = "LIMIT $offset,$pgRow";
	$qry_all = "SELECT COUNT(*) AS total FROM sesi_bahas";
	$qry = "select id,DATE_FORMAT(tkh_mula,'%d/%m/%Y') AS Tarikh,tajuk,menteri from sesi_bahas order by Tarikh ";
	
	$view->query_all = $qry_all;
	$view->query = $qry;
	$view->col = array("tajuk","menteri");		
	$view->header = array("Tarikh","Sesi","Menteri/Timbalan Menteri");
	$view->key = array("id","Tarikh");
	$view->Query($conn,$db_voffice); ?>
	<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Sesi Perbahasan</b><img src="../images/dot.gif"/>
	<br>
	<br><?php
	$view->out();
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?&action=listbahas&view=bytarikh&page=";
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);	
}//listing

//---------------------------------------------------- VIEW BY TARIKH JAWAPAN AKHIR ---------------------------------------------------


elseif($_GET['action']=='listbahas' && $_GET['view']=='byJwpnAkhirBahas'){
	include("../view.php");
	$view = new View();
	$view->ref = "index.php?action=detailsbahas&id=";
	$view->table = "sesi_bahas";
	$view->limit = "LIMIT $offset,$pgRow";
	$qry_all = "SELECT COUNT(*) AS total FROM sesi_bahas WHERE status = '9'";
	$qry = "select 
				id,
				DATE_FORMAT(tkh_mula,'%d/%m/%Y') AS Tarikh,
				tajuk,
				menteri 
			from 
				sesi_bahas
			WHERE
				status = '9'
			order by 
				Tarikh ";
	
	$view->query_all = $qry_all;
	$view->query = $qry;
	$view->col = array("tajuk","menteri");		
	$view->header = array("Tarikh","Sesi","Menteri/Timbalan Menteri");
	$view->key = array("id","Tarikh");
	$view->Query($conn,$db_voffice); ?>
	<div style="font-family:Arial;font-size:9pt;margin-top:10px;height:40px">
	<b>Senarai Jawapan Akhir Sesi Perbahasan</b>
	<br>
	<br><?php
	$view->out();
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?&action=listbahas&view=byJwpnAkhirBahas&page=";
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);	
}//listing

//---------------------------------------------------- VIEW BY SESI ---------------------------------------------------


elseif($_GET['action']=='listbahas' && $_GET['view']=='bysesi'){
	include("../view.php");
	$view = new View();
	$view->ref = "index.php?action=detailsbahas&id=";
	$view->table = "sesi_bahas";
	$view->limit = "LIMIT $offset,$pgRow";
	$qry_all = "SELECT COUNT(*) AS total FROM sesi_bahas";
	$qry = "SELECT id,DATE_FORMAT(tkh_mula,'%d/%m/%Y') AS TarikhMula,tajuk,menteri FROM sesi_bahas ORDER BY tajuk ";
	
	$view->query_all = $qry_all;
	$view->query = $qry;
	$view->col = array("TarikhMula","menteri");		
	$view->header = array("Sesi","Tarikh","Menteri/Timbalan Menteri");
	$view->key = array("id","tajuk");
	$view->Query($conn,$db_voffice); ?>
	<div style="font-family:Arial;font-size:9pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Sesi Perbahasan</b><img src="../images/dot.gif"/>
	<br>
	<br><?php
	$view->out();
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?&action=listbahas&view=bysesi&page=";
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);	
}//listing

//---------------------------------------------------- VIEW BY STATUS ---------------------------------------------------


elseif($_GET['action']=='listbahas' && $_GET['view']=='bystatus2'){
	include("../view.php");
	$view = new View();
	$view->ref = "index.php?action=detailsbahas&id=";
	$view->table = "sesi_bahas";
	$view->limit = "LIMIT $offset,$pgRow";
	$qry_all = "SELECT COUNT(*) AS total FROM sesi_bahas";
	$qry = "SELECT id,tkh_mula AS TarikhMula,tajuk,menteri,status FROM sesi_bahas ORDER BY TarikhMula DESC ";
	
	$view->query_all = $qry_all;
	$view->query = $qry;
	$view->col = array("TarikhMula","tajuk","menteri");		
	$view->header = array("Tarikh","Sesi","Menteri/Timbalan Menteri");
	$view->key = array("id","status");
	$view->Query($conn,$db_voffice); ?>
	<div style="font-family:Arial;font-size:9pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/><b>Senarai Sesi Perbahasan</b><img src="../images/dot.gif"/>
	<br>
	<br><?php
	$view->OutCat();
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?&action=listbahas&view=bystatus2&page=";
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);	
}//listing
?>
</body>