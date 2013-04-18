<?php
	include("query_admin2.php");	
?>

<?php 
$kod=1;
?>
<form id="entry_form" name="entry_form" method="post" onSubmit="return validtreasury(this)">  
<input type="hidden" name="edit" value="<?php echo $type; ?>">
<fieldset style="width:auto "><legend style="width:auto ">Pendaftaran Pengguna -> Perbendaharaan</legend>
<table width=100% cellspacing="2">
		<tr>
		  <td colspan="5">&nbsp;</td> 
  </tr>
		<tr>
		  <td colspan="5">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="56%"><font class="fs">Sila lengkapkan medan bertanda (*) </font></td>
				<td width="44%" colspan="3">
				<div style="width:250px;  padding:3; float:right;">
					<?php
						//Untuk status borang
						/*$status_mohon = "";			
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
					?>
					<!--Status :	<?php echo $status_mohon; ?>-->
					<input type="hidden" name="status" class="txt" readonly size="20" value="<?php echo $row['statusMohon']; ?>">
					<br>
					<!--Tarikh Daftar :-->	<?php 
						//Untuk tarikh daftar
						/*if($_GET['action']=="newdoc")
							echo $date = Date("d/m/Y");
						else{
							$date = $row['date'];
							echo date_display($date);
						}*/
						?>
					<br>
					<!--Permohonan Dari Sistem : <?php echo $row['sistem']; ?>-->
				</div>
				</td>
            </tr>
          </table>
		  </td>
    </tr>
		<tr><td><span class="box"><input type="hidden" name="nama_penuh" value="<?php echo $nama_penuh ?>"/></span></td>
		  <td>&nbsp;</td>
	    <td>&nbsp;</td><td colspan="2">&nbsp;</td></tr>
		
		<!--<tr><td width=164>Nama Sistem </td><td width=10>&nbsp;</td><td colspan="2"><input name="Sistem" class="txt" size="40"></td></tr>-->


<tr>
	<td width=174>Nama</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Nama2" class="txt" size="40" onBlur="copyNama()" value="<?php echo $nama; ?>"></td>
</tr>
<tr>
	<td width=174>Bahagian/Agensi Kementerian Kesihatan</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2">
  <select name="Agensi"><option value="0">&nbsp;</option><?php getAgensi($agensi,$conn,$kod) ?></select></tr>
<tr>
	<td width=174>Jawatan</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Jawatan" class="txt" size="40" value="<?php echo $jawatan ; ?>"></td>
</tr>
<tr>
	<td width=174>No. Telefon </td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input type="text" onBlur="checkNumeric(this,'','','','','');" name="Code" class="txt" size="3" maxlength="3" value="<?php echo  phone_num($telefon,0) ; ?>"/> 
    -  <input onBlur="checkNumeric(this,'','','','','');" name="Telefon" class="txt" size="10" maxlength="9" value="<?php echo phone_num($telefon,1) ; ?>"></td>
</tr>
<tr>
	<td width=174>No. Telefon Bimbit</td>
	<td width=17>&nbsp;</td>
	<td width=3>:</td><td colspan="2"> 
	  <input type="text" onblur="checkNumeric(this,'','','','','');" name="Pre_num" class="txt" size="3" maxlength="3" value="<?php echo  phone_num($hp,0); ?>"/> 
	  - 
	  <input onBlur="checkNumeric(this,'','','','','');" name="Handphone" class="txt" size="10" maxlength="9" value="<?php echo phone_num($hp,1); ?>"></td>
</tr>
<tr>
	<td width=174>Group E-mel SSJP</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Emel" class="txt" size="40" value="<?php echo $emel; ?>"></td>
</tr>
<tr>
	<td width=174>E-mel Jabatan</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Emel_jab" class="txt" size="40" value="<?php echo $emel2; ?>"></td>
</tr>
<tr>
	<td width=174>&nbsp;</td>
	<td width=17>&nbsp;</td>
	<td width=3>&nbsp;</td>
	<td colspan="2">&nbsp;</td>
</tr>
<!--<tr>
	<td width=174>ID Pengguna</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="IDnama" class="txt" size="34" maxlength="34" value="<?php echo $row['id']; ?>">
	<font style="color:<?php echo $font_color; ?>;">&nbsp;(min = 3 char)</font>	</td>
</tr>-->
<tr>
	<td width=174>No KP</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Idkp" onblur="checkNumeric(this,'','','','','');" class="txt" size="12" maxlength="12" value="<?php echo $id_nama;  ?>">
	<!--<font style="color:<?php echo $font_color; ?>;">&nbsp;(min = 3 char)</font>-->	</td>
</tr>


<?php
	//if($change > 0){
?>
<!--<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="181"><input type="checkbox" name="changePwd" id="changePwd" onClick="javascript: enablePassword()">Tukar Katalaluan</td>
</tr>
<?php
	//}
?>
<tr style="display:display ">
	<td width=174>Katalaluan</td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Katalaluan"  id="Katalaluan" type="password"  size="34" maxlength="34" <?php echo $pwdDisabled; ?> class="txt">
	<input type="hidden" name="password" value="<?php echo $row['password']; ?>">
	<font style="color:<?php echo $font_color; ?>;">(min = 6 char)</font></td>
</tr>
<tr>
	<td width=174>Pengesahan Katalaluan </td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td>
	<td colspan="2"><input name="Katalaluan2" id="Katalaluan2" type="password"  size="34" maxlength="34" <?php echo $pwdDisabled; ?> class="txt">
	<font style="color:<?php echo $font_color; ?>;">&nbsp;(masukkan semula katalaluan)</font></td>
</tr>-->
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td>Capaian Modul </td>
  <td>&nbsp;</td>
  <td>:</td>
  <td bgcolor="#E0EEE0" border=0>Soal Jawab Parlimen </td>
  <td width="586" bgcolor="#E0EEE0">
    <input type="radio" name="mod1" value="1" class="noBorder" <?php if($modul1 == 1) print "checked" ?>>Tahap 1
                <input type="radio" name="mod1" value="2" class="noBorder" <?php if($modul1 == 2) print "checked" ?>>Tahap 2
                <input type="radio" name="mod1" value="3" class="noBorder" <?php if($modul1 == 3) print "checked" ?>>Tahap 3
                <input type="radio" name="mod1" value="4" class="noBorder" <?php if($modul1 == 4) print "checked" ?>>Tahap 4
                <input type="radio" name="mod1" value="5" class="noBorder" <?php if($modul1 == 5) print "checked" ?>>Tahap 5	</td>
</tr>
<!--<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Kalendar</td>
  <td>
    <input type="radio" name="mod2" value="1" class="noBorder" <?php if($row['modul2'] == 1) print "checked" ?>>Tahap 1
    <input type="radio" name="mod2" value="2" class="noBorder" <?php if($row['modul2'] == 2) print "checked" ?>>Tahap 2
    <input type="radio" name="mod2" value="3" class="noBorder" <?php if($row['modul2'] == 3) print "checked" ?>>Tahap 3
    <input type="radio" name="mod2" value="4" class="noBorder" <?php if($row['modul2'] == 4) print "checked" ?>>Tahap 4
    <input type="radio" name="mod2" value="5" class="noBorder" <?php if(($row['modul2'] == 5) || (!isset($row['modul2']))) print "checked" ?>>Tahap 5 
  </td>
</tr>-->
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td bgcolor="#E0EEE0">Profil</td>
  <td bgcolor="#E0EEE0">
   <input type="radio" name="mod3" value="1" class="noBorder" <?php if($modul3 == 1) print "checked" ?>>Tahap 1
				<input type="radio" name="mod3" value="2" class="noBorder" <?php if($modul3 == 2) print "checked" ?>>Tahap 2
				<input type="radio" name="mod3" value="3" class="noBorder" <?php if($modul3 == 3) print "checked" ?>>Tahap 3
				<input type="radio" name="mod3" value="4" class="noBorder" <?php if($modul3 == 4) print "checked" ?>>Tahap 4
				<input type="radio" name="mod3" value="5" class="noBorder" <?php if($modul3 == 5) print "checked" ?>>Tahap 5	
  </td>
</tr>
<!--<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Jemaah Menteri </td>
  <td>
    <input type="radio" name="mod4" value="1" class="noBorder" <?php if($row['modul4'] == 1) print "checked" ?>>Tahap 1
    <input type="radio" name="mod4" value="2" class="noBorder" <?php if($row['modul4'] == 2) print "checked" ?>>Tahap 2
    <input type="radio" name="mod4" value="3" class="noBorder" <?php if($row['modul4'] == 3) print "checked" ?>>Tahap 3
    <input type="radio" name="mod4" value="4" class="noBorder" <?php if($row['modul4'] == 4) print "checked" ?>>Tahap 4
    <input type="radio" name="mod4" value="5" class="noBorder" <?php if(($row['modul4'] == 5) || (!isset($row['modul4']))) print "checked" ?>>Tahap 5 
  </td>
</tr> -->
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td bgcolor="#E0EEE0">Pendaftaran</td>
  <td bgcolor="#E0EEE0">
   <input type="radio" name="mod5" value="1" class="noBorder" <?php if($modul5 == 1) print "checked" ?>>Tahap 1
				<input type="radio" name="mod5" value="2" class="noBorder" <?php if($modul5== 2) print "checked" ?>>Tahap 2
				<input type="radio" name="mod5" value="3" class="noBorder" <?php if($modul5 == 3) print "checked" ?>>Tahap 3
				<input type="radio" name="mod5" value="4" class="noBorder" <?php if($modul5 == 4) print "checked" ?>>Tahap 4
				<input type="radio" name="mod5" value="5" class="noBorder" <?php if($modul5 == 5) print "checked" ?>>Tahap 5   
  </td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td  bgcolor="#E0EEE0">Katakunci</td>
  <td  bgcolor="#E0EEE0">
  <input type="radio" name="mod6" value="1" class="noBorder" <?php if($modul6 == 1) print "checked" ?>>Tahap 1
            <input type="radio" name="mod6" value="2" class="noBorder" <?php if($modul6== 2) print "checked" ?>>Tahap 2
            <input type="radio" name="mod6" value="3" class="noBorder" <?php if($modul6 == 3) print "checked" ?>>Tahap 3
            <input type="radio" name="mod6" value="4" class="noBorder" <?php if($modul6 == 4) print "checked" ?>>Tahap 4
            <input type="radio" name="mod6" value="5" class="noBorder" <?php if($modul6 == 5) print "checked" ?>>Tahap 5	
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width=174>Kategori Pengguna </td>
	<td width=17><?php print_red("*") ?></td>
	<td width=3>:</td><td colspan="2">
	<?php
       $sql_role_mof = mysql_query("select id, role from  roles  order by sort");
		$i = 0;
		$getRole 	= explode("+",$roles_id);
		$tip		= array('',							
							'Sekiranya pengguna adalah daripada bahagian/agensi',							
							'Wakil Bahagian Perancangan Korperat (BCP) untuk membuat soalan ',
							'',
							'Eg: Ketua Setiausaha Perbendaharaan,Pegawai Tugas Khas',
							'Bertanggungjawab untuk menyediakan draf jawapan bahagian',
							'Bertanggungjawab untuk menyediakan jawapan akhir yang telah diluluskan',
							'Semakan dari pihak pengurusan pertama (eg:TKSP (P),TKSP (D),TKSP (S & K))',
							'Wakil dari SMAT untuk meluluskan permohonan pengguna dari luar',);
		while($rows = mysql_fetch_array($sql_role_mof)){
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
		<input type="checkbox" name="cb[]" value="<?php echo $idRole; ?>" <?php echo $checked; ?>>
		<?php echo  strtoupper($role); ?>
		<br/> 
	<?php
		}
	?>
	</td>
</tr>
<!--<tr>
	<td width=164>Oleh</td>
	<td width=10>:</td>
	<td colspan="2"><?php echo $_SESSION['nama']; ?></td>
</tr>
<tr>
	<td width=164>Kekerapan Login </td>
	<td width=10>:</td>
	<td>Parlimen : <input name="parlimen" class="txt"  size="10" maxlength="12"></td>
	<td>Jemaah Menteri : <input name="kabinet" class="txt"  size="10" maxlength="12"></td>
</tr>-->
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
</fieldset>
<table width=100%>
		  <!--<input type="hidden" value="1" name="Refresh"/>-->
	<tr>
	<td width="49%">
	<input name="sistem" type="hidden" value="<?php echo $sistem ?>" />
	
	
				<input class="button" type="submit" value="DAFTAR" name="SimpanLDAP"/> 
				<input class="button" type="hidden" value="1" name="LDAP"/>
				
	</td>
	<td width="42%" colspan="3" align="right"></td>
	</tr>
</table>
<div align="left"><p>

<?php
include("level.php");
?>

</p>

</form>
