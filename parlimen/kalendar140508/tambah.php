<?php
include("../checkSession.php");
include("../config.php");
include("../keyword.php");
include("include/func.php");


$sys_acl = checkModul($conn,$db_voffice,"Modul2",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}

$isCalUser		= (checkOfficer($_SESSION['userid'],'3',$conn) or checkOfficer($_SESSION['userid'],'6',$conn));
$isCalHek		= checkOfficer($_SESSION['userid'],'3',$conn);
$isCalBertugas	= checkOfficer($_SESSION['userid'],'6',$conn);

$id = $_GET['id'];
$plm = $_GET['plm'];
$msyt = $_GET['msyt'];
$pgl = $_GET['pgl'];


 
//Hanya HEK sahaja yang boleh masukkan data
if($sys_acl==4 || !($isCalHek)){
//if($sys_acl==4 || !($isCalUser)){
	echo $acl_denied;
}else{ 
	//Start content
	if($_GET['action']=='newdocKal'){
		$id = $_GET['id'];	
		
		$qry = "SELECT 
					m.Kal_mesyuarat_id,
					m.Parlimen,
					m.Penggal,
					m.Mesyuarat,
					TarikhMulaDR,
					TarikhAkhirDR,
					TarikhMulaDN,
					TarikhAkhirDN
				FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);					
	}

	$mesyuarat 	= ($_POST['mesyuarat'])?$_POST['mesyuarat']:$row['Mesyuarat'];
	$penggal 	= ($_POST['penggal'])?$_POST['penggal']:$row['Penggal'];
	$parlimen 	= ($_POST['parlimen'])?$_POST['parlimen']:$row['Parlimen'];	
	$tarikhMulaDR = $row['TarikhMulaDR'];
	$tarikhAkhirDR1= $row['TarikhAkhirDR'];
	$tarikhMulaDN = $row['TarikhMulaDN'];
	$tarikhAkhirDN1 = $row['TarikhAkhirDN'];
	
	
	
	?>
	<style type="text/css">
		.style1 {color: #FF0000}
	</style>
	<script language='javascript' src="../popcalendar.js"></script>
	<script language="JavaScript"><!--
		function y2k(number) { return (number < 1000) ? number + 1900 : number; }
		
		function add_days(adate,days) {
			return new Date(adate.getTime() + (days * 86400000));
		}
	
		function format_date(adate) {
			return adate.getDate() + '/' + (adate.getMonth()+1) + '/' + y2k(adate.getYear());
		}
	
		function show_dates(str,addDay) {
			var bdate	= str2date(str);
			var then = add_days(bdate,addDay);    	// move date forward 
			var nDate   = format_date(then); 			// format date
			return nDate;
		}
		
		function str2date(str){
			ddate = str.split("/");
			adate = new Date(ddate[2],ddate[1]-1,ddate[0]);
			return adate;
		}
		
		
	//--></script>
	<form id="frm_kal" name="frm_kal" method="post">
	<br>
	<table border=0 width="100%">
		<tr align="right">
			<td>
			<input type="submit" value="SIMPAN" name="KalSimpan" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<?php if($_GET['action']!='newdocKal'){?>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onClick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="HAPUS" name="delete" class="button" title="Hapus Takwim Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" <?php if($sys_acl!=1) echo 'disabled' ?>/>
			<?php }?>		
			</td>
		</tr>
	</table>
	<fieldset>
	<legend>PENAMBAHAN HARI BERTUGAS</legend>
	<div style="font-family:Arial;font-size:9pt;font-weight:bold;text-align:center;margin-top:10px;height:40px">
<link rel="stylesheet" href="../style.css" title="general" type="text/css">
<body style="margin:5px">
	<table width=100%>
	  <tr><td>Mesyuarat</td><td>:</td><td><?php echo $msyt ?></td></tr>
	  <tr><td width="167">Penggal</td><td width="3">:</td><td width="1044"><?php echo $pgl?></td></tr>
	  <tr><td>Parlimen</td><td>:</td><td><?php echo  $plm?></td></tr>	  
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td colspan="3" style="padding-left:0"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3"><strong>DEWAN RAKYAT </strong></td>
            <td colspan="3"><strong>DEWAN NEGARA </strong></td>
          </tr>
          <tr>
            <td width="15%">Tarikh Mula <span class="style1">*</span> </td>
            <td width="1%">:</td>
            <td width="22%"><input name="tarikhMulaDR" class="txt" value="<?php echo DisplayDate($tarikhMulaDR)?>" size="15" />
            <img src="../images/calendar1.gif" align="absmiddle" name="imgCalendar1" border="0" alt="" onClick="if(self.gfPop)gfPop.fPopCalendar(document.frm_kal.tarikhMulaDR);return false;" href="javascript:void(0)"></td>
            <td width="12%">Tarikh Mula <span class="style1">*</span></td>
            <td width="1%">:</td>
            <td width="49%"><input name="tarikhMulaDN" class="txt" value="<?php echo DisplayDate($tarikhMulaDN)?>" size="15"/>
            <img src="../images/calendar1.gif" align="absmiddle" name="imgCalendar3" border="0" alt="" onClick="if(self.gfPop)gfPop.fPopCalendar(document.frm_kal.tarikhMulaDN);return false;" href="javascript:void(0)"></td>
          </tr>
          <tr>
            <td>Tarikh Akhir <span class="style1">*</span></td>
            <td>:</td>
            <td><input name="tarikhAkhirDR"  class="txt" value="<?php echo DisplayDate($tarikhAkhirDR1)?>" size="15" onFocus="tarikhMulaDN.value=show_dates(this.value,4)"/>
                <img src="../images/calendar1.gif" align="absmiddle" name="imgCalendar2" border="0" alt="" onClick="if(self.gfPop)gfPop.fPopCalendar(document.frm_kal.tarikhAkhirDR);return false;" href="javascript:void(0)"></td>
            <td>Tarikh Akhir <span class="style1">*</span> </td>
            <td>:</td>
            <td><input name="tarikhAkhirDN" class="txt" value="<?php echo DisplayDate($tarikhAkhirDN1)?>" size="15"/>
                <img src="../images/calendar1.gif" align="absmiddle" name="imgCalendar4" border="0" alt="" onClick="if(self.gfPop)gfPop.fPopCalendar(document.frm_kal.tarikhAkhirDN);return false;" href="javascript:void(0)"></td>
          </tr>
        </table></td>
      </tr>
	  <tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td></tr><br>
	</table>
	<br>
	<?php //include("inc_kalPegawaiBtugas.php"); ?>
	</fieldset>
	<table border=0 width="100%">
		<tr align="right">
			<td>
			<input type="submit" value="SIMPAN" name="KalSimpan" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<input type="hidden" name="MM_Update" value="editKalendar" />
			<input type="hidden" name="id" value="<? echo $id?>" />
			<?php if($_GET['action']!='newdocKal'){?>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onClick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" name="delete" value="HAPUS" title="Hapus Takwim Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
			<?php }?>		
			</td>
		</tr>
	</table>
	</form>
	
<?php 
}?>

<?php
$id	= $_GET['id'];

$tarikhMulaDR =  dateToMysql2($_POST['tarikhMulaDR']);
$tarikhAkhirDR = dateToMysql2($_POST['tarikhAkhirDR']);
$tarikhMulaDN = dateToMysql2($_POST['tarikhMulaDN']);
$tarikhAkhirDN = dateToMysql2($_POST['tarikhAkhirDN']);


if ($_POST['MM_Update']=="editKalendar"){

		$id = $_POST['id'];	
		
		$qry = "SELECT 
					m.Kal_mesyuarat_id,
					m.Parlimen,
					m.Penggal,
					m.Mesyuarat,
					TarikhMulaDR,
					TarikhAkhirDR,
					TarikhMulaDN,
					TarikhAkhirDN
				FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);

$qry1 = "UPDATE kal_mesyuarat SET TarikhMulaDR = '$tarikhMulaDR', TarikhAkhirDR ='$tarikhAkhirDR', TarikhMulaDN ='$tarikhMulaDN', TarikhAkhirDN='$tarikhAkhirDN' WHERE Kal_mesyuarat_id='$id'";
mysql_query($qry1,$conn) or die(mysql_error());

	if ($tarikhAkhirDR1 != $tarikhAkhirDR){
	$mode	= "rakyat";
	setCalendar($id, $tarikhAkhirDR, $tarikhAkhirDR, $mode); //setkan agensi dan pegawai yg bertugas utk dewan rakyat
	}
	
	if ($tarikhAkhirDN1!= $tarikhAkhirDN){
	$mode	= "negara";
	setCalendar($id, $tarikhAkhirDN, $tarikhAkhirDN, $mode); //setkan agensi dan pegawai yg bertugas utk dewan negara
	}
	
echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
	//echo "	window.opener.location.reload();";
	echo "	window.opener.document.frm_kal.submit();";
	echo "	window.close();";
	echo "</script>";
	exit();	

}

function setCalendar($id, $tarikhAkhirDR, $tarikhAkhirDR, $mode){
//untuk compute jadual bertugas semasa create record
	$weekCounter	= 0;
	
	//weekCounter untuk dewan negara
	if ($mode=='negara'){
		$qryMinggu	= "SELECT MAX(Minggu) AS maxWeek FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id'";
		$rsMinggu	= mysql_query($qryMinggu);
		$rowMinggu	= mysql_fetch_array($rsMinggu);
		$weekCounter	= $rowMinggu['maxWeek'];		
	}
//echo $weekCounter;

	$tkh	= tarikhAvailable($tarikhAkhirDR, $tarikhAkhirDR);  //dapat array tarikh business day. except jumaat, sabtu, ahad dan cuti
	foreach($tkh as $tkhTugas){
		$currWeek		= findWeek($tkhTugas);
		$dplcateWeek 	= ($currWeek==$preWeek)? true:false;
		
		if (!$dplcateWeek){
			$weekCounter++;
		}

		if(checkCuti($tkhTugas)){ //Entry sekiranya tarikh ini = cuti
			$qryTugas	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							VALUES ('$id', '$tkhTugas', 'CUTI', 'CUTI', '$mode', '$weekCounter')";
			mysql_query($qryTugas) or die(mysql_error());
		}
		//Entry selain daripada hari cuti
		else{
			if($mode=='rakyat' && $tkhTugas==$tarikhAkhirDR){ //setkan entry utk hari pertama = titah agong
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI','$mode', '$weekCounter')";
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI','$mode', '$weekCounter')";
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', '', 'PETANG','$mode', '$weekCounter')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu)  
								VALUES ('$id', '$tkhTugas', '', 'PETANG','$mode', '$weekCounter')";
			}
			else{
				//PAGI
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI','$mode', '$weekCounter')";
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI','$mode', '$weekCounter')";
				//Sekiranya hari=khamis, maka PERBADANAN LABUAN akan bertugas
				if(hari($tkhTugas)=='Thu'){
					$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
									VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PAGI','$mode', '$weekCounter')";
				}
				
				//PETANG
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PETANG','$mode', '$weekCounter')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'PERBADANAN PUTRAJAYA', 'PETANG','$mode', '$weekCounter')";
				//Sekiranya hari=rabu, maka PERBADANAN LABUAN akan bertugas
				if(hari($tkhTugas)=='Wed'){ 
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
									VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PETANG','$mode', '$weekCounter')";
				}
			}		
		
			mysql_query($qryTugas1) or die(mysql_error());
			mysql_query($qryTugas2) or die(mysql_error());
			mysql_query($qryTugas3) or die(mysql_error());
			mysql_query($qryTugas4) or die(mysql_error());
						
		}
		$preWeek	= $currWeek;
		
		
	}
	//echo $weekCounter;
	//Automate nama petugas by giliran
	setPetugas('DBKL',$id);
	setPetugas('KWP',$id);
	setPetugas('PERBADANAN PUTRAJAYA',$id);
	setPetugas('PERBADANAN LABUAN',$id);
	
}


					
?>
<iframe name="gToday:normal:agenda.js" id="gToday:normal:agenda.js"
	src="include/calendar/ipopeng.htm" scrolling="no" frameborder="0"
	style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
	<LAYER name="gToday:normal:agenda.js" left="14" top="-5" src="calendar/npopeng.htm">     </LAYER>
</iframe>