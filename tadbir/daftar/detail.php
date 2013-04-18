<?php
	
	$id = $_GET['id_tbl'];
	$isAdmin = checkOfficer($_SESSION['userid'],1,$conn);
	//$app = $_GET['app'];
	//echo "app=".$app;		
	//$qry = "Select konfigurasi.id,konfigurasi.kategori,konfigurasi.kod,konfigurasi.butiran From konfigurasi WHERE konfigurasi.id ='$id'";
	$role_array = array();
	$qry = "SELECT * From pengguna where id_tbl = '$id'";
	$result = mysql_query($qry,$conn) or die(mysql_error()); 
	$row = mysql_fetch_array($result);
	$getRole = explode("+",$row['roles']);
	//$password = decrypt($row['password']);
	
	//$status = $row['status'];	
	$s_agensi = mysql_query("select nama from agensi where id = '" . $row['agensi_id'] . "'");
	$row_agensi = mysql_fetch_array($s_agensi);
	$agensi = $row_agensi[0];
	
	//$s_role = mysql_query("select role from roles where id = '" . $row['roles'] . "'");
	$s_role = mysql_query("select id,role from roles");
	while($r_role = mysql_fetch_array($s_role)){
		$idRole = $r_role[0];
		$nameRole = $r_role[1];
		$role_array[$idRole] = $nameRole;
	}
	
	function date_display($date){
		$dt = explode("-",$date);
		$date = implode("/",array($dt[2],$dt[1],$dt[0]));
		return $date;
	}
?>

<form id="entry_form" name="entry_form" method="post">
<input type="hidden" name="app" value="<?php echo $app; ?>">
<fieldset style="width:auto ">
<legend>Pendaftaran Pengguna</legend>
<table width=100% cellspacing="3">
  <tr>
    <td colspan="3">
	<div style="width:250px; background-color:#CCCCFF; padding:3; float:right;">
		<?php
			$status_mohon = "";			
			if(strcmp($row['statusMohon'],"DAFTAR") == 0){
				$status_mohon = "DAFTAR";
			}elseif(strcmp($row['statusMohon'],"SAH") == 0){
				$status_mohon = "SAH";
			}elseif(strcmp($row['statusMohon'],"TIDAK SAH") == 0){
				$status_mohon = "TIDAK SAH";
			}else{
				if($_GET['action'] == "newdoc"){
					$status_mohon = "PERMOHONAN BARU";
				}elseif($app == "yes"){
					$status_mohon = "PERMOHONAN BARU";
				}elseif($app == "psu"){
					$status_mohon = "UNTUK DISAHKAN";
				}else{
					$status_mohon = "LULUS";
				}
			}
		
			if($_GET['action']=="newdoc")
				echo Date("d/m/Y");
			else{
				$date = $row['date'];
			}
		?>
		
		Tarikh Daftar :	<?php echo date_display($date);	?>
		
	</div> 
	</td>
  </tr>
	<tr><td width=164>Nama</td><td width="5">:</td><td> <?php echo stripslashes($row['nama']); ?></td></tr>
	<tr>
	  <td width=164>Bahagian/Agensi Kementerian Kesihatan </td>
	  <td width="5">:</td><td><?php echo $agensi; ?></td></tr>
	<tr><td width=164>Jawatan</td><td width="5">:</td><td><?php echo $row['jawatan']; ?></td></tr>
	<tr><td width=164>No. Telefon </td><td width="5">:</td><td><?php echo $row['telefon']; ?></td></tr>
	<tr><td width=164>No. Telefon Bimbit</td><td width="5">:</td><td><?php echo $row['handphone']; ?></td></tr>
	<tr><td width=164>Group E-mel SSJP</td><td width="5">:</td><td><?php echo $row['emel']; ?></td></tr>
	<tr><td width=164>E-mel Jabatan</td><td width="5">:</td><td><?php echo $row['emel_jab']; ?></td></tr>
	<tr><td width=164>ID Pengguna</td><td width="5">:</td><td><?php echo $row['id']; ?></td></tr>
	<tr>
	  <td>No. KP</td><td width="5">:</td>
	 
	  <td><?php echo $row['nokp']; ?></td>
    </tr>
	<tr>
	  <td>Capaian </td>
	  <td>:</td>
	  <td>
        <table width="100%">
          <tr>
            <td>Soal Jawab Parlimen</td>
            <td>
              <input type="radio" <?php if($row['modul1'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul1'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul1'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul1'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul1'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>
        <!--  <tr>
            <td>Kalendar</td>
            <td>
              <input type="radio" <?php if($row['modul2'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul2'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul2'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul2'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul2'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>-->
          <tr>
            <td>Profil</td>
            <td>
              <input type="radio" <?php if($row['modul3'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul3'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul3'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul3'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul3'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>
         <!-- <tr>
            <td>Jemaah Menteri</td>
            <td>
              <input type="radio" <?php if($row['modul4'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul4'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul4'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul4'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul4'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>-->
          <tr>
            <td>Pendaftaran</td>
            <td>
              <input type="radio" <?php if($row['modul5'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul5'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul5'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul5'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul5'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>
          <tr>
            <td>Katakunci</td>
            <td>
              <input type="radio" <?php if($row['modul6'] == 1){ print "checked"; } ?> disabled>
              Tahap 1
              <input type="radio" <?php if($row['modul6'] == 2){ print "checked"; } ?> disabled>
              Tahap 2
              <input type="radio" <?php if($row['modul6'] == 3){ print "checked"; } ?> disabled>
              Tahap 3
              <input type="radio" <?php if($row['modul6'] == 4){ print "checked"; } ?> disabled>
              Tahap 4
              <input type="radio" <?php if($row['modul6'] == 5){ print "checked"; } ?> disabled>
              Tahap 5 </td>
          </tr>
      </table></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr><td width=164>Kategori Pengguna </td><td width="5">:</td><td>
	<?php
		$sql = mysql_query("select id, role from roles order by sort");
		$i = 0;
		$getRole = explode("+",$row['roles']);
		while($rows = mysql_fetch_array($sql)){
			$i++;
			$idRole = $rows[0];
			$role = $rows[1];
			$checked = "";
			for($a=0;$a<=$i;$a++){
				if($getRole[$a] == $idRole){
					$checked = "checked";
				}
			}
	?>
		<input type="checkbox" <?php echo $checked; ?> disabled><?php echo  strtoupper($role); ?><br/>
	<?php
		}
	?>
	</td></tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<?php if(!empty($row['user'])){ ?>
	<tr><td width=164>Oleh</td><td width="5">:</td><td><?php echo $row['user']; ?></td></tr>
	<?php } ?>
	<tr><td colspan="3" align="left">	<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
	<?php
	//if($isAdmin && ($_GET['action'] == "details")){
		echo "<input class=\"button\" type=\"submit\" value=\"HAPUS\" name=\"DeleteUser\" onClick=\"return verify()\">";
	    echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit\"/>";				
//}
	//echo $row['statusMohon'];
	/*if($row['statusMohon']<>"DITOLAK"){ 
		if(($row['statusMohon']=="PERMOHONAN BARU") && $app=="yes")
			echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit\"/><br /><br />";
		if((($row['statusMohon']=="DAFTAR") || ($row['statusMohon']=="LULUS") || ($row['statusMohon']=="SAH") || ($row['statusMohon']=="TIDAK SAH"))&& empty($app))
			echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit\"/>";
		if(($row['statusMohon']=="UNTUK DISAHKAN") && $app=="psu")
			echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit\"/>";					
	} 
	if($isAdmin && strcmp($row['statusMohon'],"SAH") == 0){ 
	?>
		<input name="Daftar" type="hidden" value="daftar" />
		<input name="id" type="hidden" value="<?php echo $id ?>" />
		<input class="button" type="submit" value="DAFTAR" name="Simpan"/>
	<?php } 
	if(strcmp($app,"psu") == 0 && strcmp($row['statusMohon'],"UNTUK DISAHKAN") == 0){ 
	?>
		<input class="button" type="button" value="SAH" onClick="window.location='index.php?action=sah&id=<?php echo $_GET['id']; ?>'">
		<input class="button" type="button" value="TIDAK SAH" onClick="window.location='index.php?action=check&id=<?php echo $_GET['id']; ?>'">
		
	<?php }*/ ?>
	</td></tr>
</table>
</fieldset>
<table width="100%">
<tr>
	<td><br /><?php include('level.php'); ?></td>
</tr>
</table>

</form>
