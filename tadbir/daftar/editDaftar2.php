<?php
	
	function getKeyword($category,$default,$conn){
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['butiran'];
			$selected = ($item == $default)?"selected":"";
			echo "<option $selected>".$item."</option>";
		}
	}
	
	function getAgensi($def,$conn){		
		$qry = "SELECT agensi.id AS id, agensi.nama, agensi.nama_pendek AS pendek FROM agensi ORDER BY nama_pendek";

		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['pendek']."</option>";			
		}				
	}
	
	function Validator($Katalaluan,$Katalaluan2){
		if (Katalaluan != Katalaluan2){
		//<script type="text/javascript">
		echo "Katalaluan anda tidak sepadan. Sila masukkan katalaluan semula di medan Pengesahan Katalaluan.";
		}
	return true;
	}
	  
	function getKawasan($def,$conn){		
		$qry = "SELECT id,nama FROM kawasan ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama']."</option>";			
		}				
	}
		
	function getParti($def,$conn){
		$qry = "SELECT id,nama_pendek FROM parti ORDER BY nama_pendek";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama_pendek']."</option>";
		}
	}
	
	function getRoles($def,$conn){		
		$qry = "SELECT id, role FROM roles ORDER BY role ";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['role']."</option>";			
		}				
	}
	
	$agensi_id = $_POST['Agensi']?$_POST['Agensi']:$row['agensi_id'];
	$jawatan = $_POST['Jawatan']?$_POST['Jawatan']:$row['Jawatan'];
	$id_nama = $_POST['ID_Nama']?$_POST['ID_Nama']:$row['ID_Nama'];
	
	if($_GET['action']!='newdoc'){
		$id = $_GET['id'];	
		
		$qry = "SELECT ahli_parlimen.id,ahli_parlimen.sesi_dewan AS sesi,ahli_parlimen.nama AS nama_yb,
				ahli_parlimen.parti_id AS parti,ahli_parlimen.kawasan_id AS kawasan,ahli_parlimen.status,parti.id FROM ahli_parlimen 
				Inner Join parti ON ahli_parlimen.parti_id = parti.nama_pendek
				WHERE ahli_parlimen.id ='$id'" ;
	
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$status = $row['status'];	
		
		$nama = $_POST['Nama']?$_POST['Nama']:$row['Nama'];
		$agensi_id = $_POST['Agensi2']?$_POST['Agensi2']:$row['agensi_id'];
		$jawatan = $_POST['Jawatan']?$_POST['Jawatan']:$row['Jawatan'];
		$tel = $_POST['Telefon']?$_POST['Telefon']:$row['Telefon'];
		$hp = $_POST['Handphone']?$_POST['Handphone']:$row['Handphone'];
		$emel = $_POST['Emel']?$_POST['Emel']:$row['Emel'];
		$id_nama = $_POST['ID_Nama']?$_POST['ID_Nama']:$row['ID'];
		$katalaluan = $_POST['Katalaluan']?$_POST['Katalaluan']:$row['Katalaluan'];
		$katalaluan2 = $_POST['Katalaluan2']?$_POST['Katalaluan2']:$row['Katalaluan2'];
		$katalaluan2 = $_POST['Katalaluan2']?$_POST['Katalaluan2']:$row['Katalaluan2'];
		$kategori = $_POST['Kategori']?$_POST['Kategori']:$row['Kategori'];
		
		/*laila tambah here
		
		$mod3=  $_POST['mod3'];$mod4 = $_POST['mod4'];
		$mod5=  $_POST['mod5'];$mod6 = $_POST['mod6'];
		$advance6 = $_POST['Advance6']<>""?implode(";",$_POST['Advance6']):"";
		$qry = "UPDATE pengguna SET Nama='$Nama',Jabatan='$Jabatan',Jawatan='$Jawatan',Telefon='$Telefon',Handphone = '$Handphone',
		Emel='$Emel',Kategori='$Kategori',Jenis='$Jenis',Modul1='$mod1',Modul2='$mod2',Modul3='$mod3',Modul4='$mod4',Modul5='$mod5',Modul6='$mod6',
		Advance6='$advance6'
		WHERE Id='$id'";
		mysql_query($qry,$conn) or die(mysql_error());
		echo $update_record_msg;	
		end here*/
	}
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>PENDAFTARAN PENGGUNA <img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend></legend>
<div class="sub">  </div>
</fieldset>

<fieldset>
<table width=100%>
		<tr><td><span class="box"><input type="hidden" name="nama_penuh" value="<?php echo $nama_penuh ?>"/></span></td><td>&nbsp;</td><td colspan="2">&nbsp;</td></tr>
		<tr><td><input type="hidden" name="pattern" value="<?php echo $pattern ?>"/></td><td>&nbsp;</td><td colspan="2">
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='A';document.submit()" value="A" />
          		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='B';document.submit()" value="B" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='C';document.submit()" value="C" />
           		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='D';document.submit()" value="D" />
           		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='E';document.submit()" value="E" />
         		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='F';document.submit()" value="F" />
           		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='G';document.submit()" value="G" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='H';document.submit()" value="H" />
           		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='I';document.submit()" value="I" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='J';document.submit()" value="J" />
          		<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='K';document.submit()" value="K" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='L';document.submit()" value="L" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='M';document.submit()" value="M" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='N';document.submit()" value="N" />
            	<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='O';document.submit()" value="O" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='P';document.submit()" value="P" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='Q';document.submit()" value="Q" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='R';document.submit()" value="R" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='S';document.submit()" value="S" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='T';document.submit()" value="T" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='U';document.submit()" value="U" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='V';document.submit()" value="V" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='W';document.submit()" value="W" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='X';document.submit()" value="X" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='Y';document.submit()" value="Y" />
				<input class="button" name="submit" type="submit" onClick="document.entry_form.pattern.value ='Z';document.submit()" value="Z" /></td></tr>
		
		<!--<tr><td width=164>Nama Sistem </td><td width=10>&nbsp;</td><td colspan="2"><input name="Sistem" class="txt" size="40"></td></tr>-->
		<tr><td width=164>Nama</td><td width=10>:</td><td colspan="2"><p><select class="txt" name="Nama" onChange="submit()"><option/><?php //senaraiPengguna($conn,$db_voffice,$ldapServer,$ldapPort,$ldapBase,$nama,$pattern)?></select></p></td></tr>
		<tr><td width=164>&nbsp;</td><td width=10>&nbsp;</td><td colspan="2"><input name="Nama2" class="txt" size="40"></td></tr>
		<tr><td width=164>Bahagian/Agensi di Kementerian Kesihatan </td><td width=10>:</td><td colspan="2">
			<select name="Agensi" onChange="submit()"><option></option><?php getAgensi($agensi_id,$conn) ?></select>
			<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>"/></tr>
		<tr><td width=164>Jawatan</td><td width=10>:</td><td colspan="2"><input name="Jawatan" class="txt" size="40"></td></tr>
		<tr><td width=164>No. Telefon </td><td width=10>:</td><td colspan="2"><input name="Telefon" class="txt" size="40" maxlength="12"></td></tr>
		<tr>
		  <td width=164>No. Telefon Bimbit</td>
		  <td width=10>:</td><td colspan="2"><input name="Handphone" class="txt" size="40" maxlength="12"></td></tr>
		<tr><td width=164>E-mel</td><td width=10>:</td><td colspan="2"><input name="Emel" class="txt" size="40" maxlength="12"></td></tr>
		<tr><td width=164>&nbsp;</td><td width=10>&nbsp;</td><td colspan="2">&nbsp;</td></tr>
		<tr><td width=164>ID Pengguna</td><td width=10>:</td><td colspan="2"><input name="ID_nama" class="txt" size="40" maxlength="12">
			<span class="stylenote">(min = 3 char, max = 8 char )</span></td></tr>
		<tr><td width=164>Katalaluan</td><td width=10>:</td><td colspan="2"><input name="Katalaluan" type="password"  size="34" maxlength="12">
			<span class="stylenote">(min = 6 char)</span></td></tr>
		<tr><td width=164>Pengesahan Katalaluan </td><td width=10>:</td><td colspan="2"><input name="Katalaluan2" type="password"  size="34" maxlength="12">
			<span class="stylenote"> (masukkan semula katalaluan)</span></td></tr>
		<tr><td width=164>Kategori Pengguna </td><td width=10>:</td><td colspan="2"><select name="Kategori" onChange="submit()"><option></option><?php getRoles($roles_id,$conn) ?></select>
            <input type="hidden" name="roles_id" value="<?php echo $roles_id ?>"/></td></tr>
		<tr><td width=164>&nbsp;</td><td width=10>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td width=164>Capaian </td><td width=10>:</td>
		<td width="188" bgcolor="#E0EEE0" border=0>Soal Jawab Parlimen </td>
			
			<td width="371" bgcolor="#E0EEE0">
				<input type="radio" name="mod2" value="1" class="noBorder">Tahap 1
                <input type="radio" name="mod2" value="2" class="noBorder">Tahap 2
                <input type="radio" name="mod2" value="3" class="noBorder">Tahap 3
                <input type="radio" name="mod2" value="4" class="noBorder">Tahap 4
                <input type="radio" name="mod2" value="5" class="noBorder"checked >Tahap 5</td></tr>
		
		<tr><td>&nbsp;</td><td>&nbsp;</td>
		<td>Kalendar</td>
			<td>
				<input type="radio" name="mod2" value="1" class="noBorder">Tahap 1
				<input type="radio" name="mod2" value="2" class="noBorder">Tahap 2
				<input type="radio" name="mod2" value="3" class="noBorder">Tahap 3
				<input type="radio" name="mod2" value="4" class="noBorder">Tahap 4
				<input type="radio" name="mod2" value="5" class="noBorder"checked >Tahap 5 
			</td>
    	</tr>
		
		<tr><td>&nbsp;</td><td>&nbsp;</td>
		  <td bgcolor="#E0EEE0">Profil</td>
			<td bgcolor="#E0EEE0">
				<input type="radio" name="mod3" value="1" class="noBorder">Tahap 1
				<input type="radio" name="mod3" value="2" class="noBorder">Tahap 2
				<input type="radio" name="mod3" value="3" class="noBorder">Tahap 3
				<input type="radio" name="mod3" value="4" class="noBorder">Tahap 4
				<input type="radio" name="mod3" value="5" class="noBorder"checked >Tahap 5 
			</td>
   		</tr>
		
		<tr><td>&nbsp;</td><td>&nbsp;</td>
		  <td>Jemaah Menteri </td>
			<td>
				<input type="radio" name="mod4" value="1" class="noBorder">Tahap 1
				<input type="radio" name="mod4" value="2" class="noBorder">Tahap 2
				<input type="radio" name="mod4" value="3" class="noBorder">Tahap 3
				<input type="radio" name="mod4" value="4" class="noBorder">Tahap 4
				<input type="radio" name="mod4" value="5" class="noBorder"checked >Tahap 5 
			</td>
		</tr>
				
		<tr><td>&nbsp;</td><td>&nbsp;</td>
		  <td bgcolor="#E0EEE0">Pendaftaran</td>
		  <td bgcolor="#E0EEE0">
				<input type="radio" name="mod5" value="1" class="noBorder">Tahap 1
				<input type="radio" name="mod5" value="2" class="noBorder">Tahap 2
				<input type="radio" name="mod5" value="3" class="noBorder">Tahap 3
				<input type="radio" name="mod5" value="4" class="noBorder">Tahap 4
				<input type="radio" name="mod5" value="5" class="noBorder"checked >Tahap 5 
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Katakunci</td>
		  <td>
            <input type="radio" name="mod5" value="1" class="noBorder">Tahap 1
            <input type="radio" name="mod5" value="2" class="noBorder">Tahap 2
            <input type="radio" name="mod5" value="3" class="noBorder">Tahap 3
            <input type="radio" name="mod5" value="4" class="noBorder">Tahap 4
            <input type="radio" name="mod5" value="5" class="noBorder"checked >Tahap 5 </td>
	</tr>

		<tr><td width=164>&nbsp;</td><td width=10>&nbsp;</td><td colspan="2">&nbsp;</td></tr>
		<tr><td width=164>Tarikh Pendaftaran</td><td width=10>:</td><td colspan="2"><font style="color:black;font-family:Arial;font-size:10pt"><?php echo Date("j/n/Y-g:i:s A");?></font></td></tr>
		<tr><td width=164>Oleh</td><td width=10>:</td><td colspan="2"><font style="color:black;font-family:Arial;font-size:10pt"><?php echo $_SESSION['nama']; ?></font></td></tr>
		<tr><td width=164>Kekerapan Login </td><td width=10>:</td>
		<td>Parlimen : 
		  <input name="parCount" type="txt"  size="10" maxlength="12"></td>
		<td>Jemaah Menteri : 
		  <input name="jemCount" type="txt"  size="10" maxlength="12"></td></tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

</table>
</fieldset>
<table width=100%>
		  <!--<input type="hidden" value="1" name="Refresh"/>-->
	<tr><td width="49%"><input class="button" type="submit" value="Simpan" name="Simpan"/>
    	<input class="button" type="submit" value="Daftar" name="Simpan&Daftar2"/></td>
	<td width="9%">&nbsp;</td><td width="42%" colspan="2"><div align="right">Status:
        <input name="status" type="txt" size="10" maxlength="12"></div></td></tr>
</table>
<div align="left"><p>      

<?php
include("summary.php");
?>

</p>
</div>
</form>
