<?php
		
	function ListKategori($keyword,$def=""){
		foreach($keyword as $kategori){
			echo ($def<>$kategori)?"<option>$kategori</option>":"<option selected>$kategori</option>";
		}
	}
	
	$kategori = ($_POST['kategori'])?$_POST['kategori']:$row['kategori'];

	
	if($_GET['action']!='newdoc'){
		$id = $_GET['id'];	
		$kategori = $_GET['cat'];
		
		if ($kategori == "Kawasan Parlimen"){
	$qry = "Select kawasan.id, kawasan.nama From kawasan WHERE kawasan.id ='$id'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$butiran = $row['nama'];
	
	} else if ($kategori == "Parti"){
	$qry = "Select parti.id, parti.nama_pendek ,parti.nama_panjang From parti WHERE parti.id ='$id'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$kod = $row['nama_pendek'];
	$butiran = $row['nama_panjang'];
	
	} else{
		 
	$qry = "Select konfigurasi.id,konfigurasi.kategori,konfigurasi.kod,konfigurasi.butiran From konfigurasi WHERE konfigurasi.id ='$id'";
	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$kod = $row['kod'];
	$butiran = $row['butiran'];
	$kategori = $row['kategori'];
	
			}
		/*
		$qry = "SELECT konfigurasi.id,konfigurasi.kategori,konfigurasi.kod,konfigurasi.butiran FROM konfigurasi 
				WHERE konfigurasi.id ='$id'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$status = $row['status'];	
					
	$kategori = $row['kategori'];
	//$katakunci = ($_POST['kategori'])?$_POST['kategori']:$row['kategori'];
	*/
	}
	
?>

<!--<script language="javascript">alert (entry_form.kategori.value);</script>-->

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>KATAKUNCI<img src="../images/dot.gif"/></div>
<form id="entry_form2" name="entry_form2" method="post" onSubmit="return validateForm(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<fieldset><legend>Butiran Katakunci</legend>
<div class="sub"> 
<br/>
<table width=100%>
		<tr><td width=120>Kategori</td><td width=5>:</td><td><select name="kategori" onChange="">
		    <option></option><?php echo ListKategori($keyword,$kategori) ?></select></td></tr>
		<tr><td width=120>Kod</td><td width=5>:</td><td><p><input name="kod" value="<?php echo $kod ?>" size=10 class="txt"/> 
		<font class="fs">*pilihan </font>
		</p>
		</tr>
		<tr><td width=120>Butiran</td><td width=5>:</td><td><input name="butiran" value="<?php echo $butiran ?>" size=50 class="txt"/></td></tr>
</table>
 </div>
</fieldset>
<br/><br/>
<input type="submit" name="Simpan" value="SIMPAN" class="button"/>
</form>


