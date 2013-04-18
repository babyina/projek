<?php
	
	function getKeyword($category,$default,$conn){
		$qry = "SELECT id,nama FROM negeri ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['nama'];
			$id = $row['id'];
			$selected = ($id == $default)?"selected":"";
			echo "<option $selected value=\"$id\">".$item."</option>";
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
		
	$pangkat = empty($pangkat)?"YB Sen. ":$pangkat;
		
if($sys_acl==4 || !($isCalUser)){
	echo $acl_denied;
}else{

	if($_GET['action']!='newdoc2'){
		$id = $_GET['id'];	
		
		$qry2 = "SELECT ahli_parlimen.id,ahli_parlimen.sesi_dewan AS sesi,ahli_parlimen.nama AS nama_yb,ahli_parlimen.pangkat,
				ahli_parlimen.negeri,ahli_parlimen.status,ahli_parlimen.parti_id AS parti_id 
				FROM ahli_parlimen LEFT JOIN parti ON parti.id = ahli_parlimen.parti_id
				WHERE ahli_parlimen.id ='id'";
				
		$qry = "SELECT ahli_parlimen.id,ahli_parlimen.sesi_dewan AS sesi,ahli_parlimen.nama AS nama_yb,ahli_parlimen.pangkat,
				ahli_parlimen.parti_id AS parti_id,ahli_parlimen.kawasan_id AS kawasan_id,ahli_parlimen.negeri,ahli_parlimen.status FROM ahli_parlimen 
				WHERE ahli_parlimen.id ='$id'" ;
	
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$status = $row['status'];	
		
		$nama_yb = $_POST['nama_yb']?$_POST['nama_yb']:$row['nama_yb'];
		$negeri = $_POST['Negeri']?$_POST['Negeri']:$row['negeri'];
		$parti_id = $_POST['Parti']?$_POST['Parti']:$row['parti_id'];
		$pangkat = $_POST['pangkat']?$_POST['pangkat']:$row['pangkat'];
		$pangkat = empty($pangkat)?"YB Sen. ":$pangkat;
	}
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>PROFIL AHLI DEWAN NEGARA <img src="../images/dot.gif"/></div>
<form id="entry_form2" name="entry_form2" method="post" onSubmit="return validateForm(this)">
<fieldset><legend>Kemasukan Maklumat</legend>
<div class="sub"></div>

<table width=100%>
	<tr><td width=191>&nbsp;</td>
	<td width=32>&nbsp;</td>
	<td>&nbsp;</td></tr>
	<tr><td width=191>Sesi</td>
	<td width=32>:</td>
	<td width="717">Dewan Negara</td>
	</tr>
	<tr><td width=191>Gelaran/Pangkat</td>
	<td width=32>:</td>
	<td width="717"><input name="pangkat" value="<?php echo $pangkat ?>" size=70 class="txt"/></td></tr>
	<tr><td width=191>Nama YB Senator </td>
	<td width=32>:</td>
	<td width="717"><p>
 	  <input name="nama_yb" value="<?php echo $nama_yb ?>" size=70 class="txt"/></p></tr>
	<tr><td width=191>Negeri</td>
	<td width=32>:</td>
	<td width="717"><select name="Negeri" >
      <option></option><?php getKeyword("Negeri",$negeri,$conn) ?></select></td></tr>
	<tr>
	  <td>Parti Diwakili</td>
	  <td>:</td>
	  <td><select name="Parti">
        <option></option>
	    <?php getParti($parti_id,$conn) ?>
      </select></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
</table>

</fieldset>
<br/>

&nbsp;&nbsp;<input type="submit" value="SIMPAN" name="Simpan2" class="button" <?php if(($sys_acl==5) || ($sys_acl==4)){ echo 'disabled'; }?>/>
<!--<input class="button" type="submit" value="SIMPAN" name="Simpan2"/>-->
</form>
<?php } ?>
