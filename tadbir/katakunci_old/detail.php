<?php
	
	$id = $_GET['id'];
	$kategori = $_GET['cat'];	
	
	if ($kategori == "Kawasan Parlimen"){
	$qry = "Select kawasan.id, kawasan.nama From kawasan WHERE kawasan.id ='$id'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$butiran = $row['nama'];
	
	} 
	else if ($kategori == "Parti"){
	$qry = "Select parti.id, parti.nama_pendek ,parti.nama_panjang From parti WHERE parti.id ='$id'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$kod = $row['nama_pendek'];
	$butiran = $row['nama_panjang'];
	
	} else {
		
	$qry = "Select konfigurasi.id,konfigurasi.kategori,konfigurasi.kod,konfigurasi.butiran From konfigurasi WHERE konfigurasi.id ='$id'";
	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$kod = $row['kod'];
	$butiran = $row['butiran'];	}
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>KATAKUNCI<img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend>Butiran Katakunci</legend>
<div class="sub">  </div><br />


<table width=100%>
		<tr><td width=120>Kategori</td><td width="5">:</td><td><?php echo $kategori?></td></tr>
		<tr><td width=120>Kod</td><td>:</td><td> <?php echo $kod ?></td></tr>
		<tr><td width=120>Butiran</td><td>:</td><td><?php echo $butiran ?></td></tr>
		<tr><td width=120>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>

</fieldset>
<br/><br/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="cat" value="<?php echo $_GET['cat'] ?>"/><?php
if($sys_acl<3)
{
echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit\"/>";
}
if($sys_acl==1)
{
echo "&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" type=\"submit\" value=\"HAPUS\" name=\"Hapus\" onClick=\"return verify()\"/>";
}
?>
</form>
