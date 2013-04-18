<?php
	
	$id = $_GET['id'];
			
	$qry = "Select id,tksp,nama, nama_pendek, kategori FROM agensi WHERE id ='$id'";
   
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>AGENSI/BAHAGIAN<img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend>Butiran Bahagian/Agensi Kementerian Kesihatan</legend>
<div class="sub">  </div><br />


<table width=100%>
		<tr><td width=120>Nama</td><td width="5">:</td><td><?php echo $row['nama'] ?></td></tr>
		<tr><td width=120>Nama Singkatan</td><td>:</td><td> <?php echo $row['nama_pendek'] ?></td></tr>
		<tr><td width=120>Kategori</td><td>:</td><td><?php echo $row['kategori'] ?></td></tr>
		<tr><td width=120>Tksp</td><td>:</td><td><?php echo $row['tksp'] ?></td></tr>
		<tr><td width=120>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>

</fieldset>
<br/><br/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
<?php
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
