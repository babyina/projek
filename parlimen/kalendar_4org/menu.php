<?php
function menu($title,$url,$param,$name,$img){			
	$class = ($param == $name)?"highlight":"";
	if($class == "")
		return "<img src=\"$img\"/><a class=\"$class\" href=\"index.php?$url\">$title</a>";			
	else
		return "<img src=\"$img\"/><font class=\"highlight\">$title</font>";
}
?>

<table width=100% cellspacing="0" border=1 id="menu">
	<?php 
	//Hanya HEK sahaja yang boleh access
	if($isCalHek){?>
		<tr><td class="level1">Laporan Persidangan</td></tr>
		<tr><td><?php echo menu("Kemasukan Data","action=newdocLap",$_GET['action'],"newdocLap","../images/b3.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td class="level2"><img src="../images/b1.gif">Senarai Laporan</td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama","action=listLap&view=bynama","bynama",$_GET['view'],"../images/list.gif")?></td></tr> 
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Dewan Rakyat","action=listLap&view=byDewanRakyat","byDewanRakyat",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Dewan Negara","action=listLap&view=byDewanNegara","byDewanNegara",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
	<?php }?>
</table>
<br>
<table width=100% cellspacing="0" border=1 id="menu">
	<tr><td class="level1">Takwim Pegawai Bertugas</td></tr>
	<?php 
	//Hanya HEK sahaja yang boleh access
	if($isCalHek){?>
		<tr><td><?php echo menu("Kemasukan Data","action=newdocKal",$_GET['action'],"newdocKal","../images/b3.gif")?></td></tr>
	<?php }?>
	<tr><td><?php echo menu("Senarai Takwim","action=listKal&view=bynegara","bynegara",$_GET['view'],"../images/b1.gif")?></td></tr>
	<tr><td><?php //echo menu("Senarai Takwim2","action=listRizal&view=byDewan","byDewan",$_GET['view'],"../images/b1.gif")?></td></tr>
	<tr><td>&nbsp;</td></tr>
</table>
<br>
<table width=100% cellspacing="0" border=1 id="menu">
	<?php 
	//Hanya HEK sahaja yang boleh access
	if($isCalHek){?>
		<tr><td class="level1">Cuti Tahunan</td></tr>
		<tr><td><?php echo menu("Kemasukan Data","action=newdocCuti",$_GET['action'],"newdocCuti","../images/b3.gif")?></td></tr>
		<tr><td><?php echo menu("Senarai Cuti","action=listCuti&view=bytarikh","bytarikh",$_GET['view'],"../images/b1.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
	<?php }?>
</table>


