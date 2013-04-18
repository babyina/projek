<?php
	function menu($title,$url,$param,$name,$img){			
		$class = ($param == $name)?"highlight":"";
		if($class == "")
			return "<img src=\"$img\"/><a class=\"$class\" href=\"index.php?$url\">$title</a>";			
		else
			return "<img src=\"$img\"/><font class=\"highlight\">$title</font>";
	}
?>

<table width=100% cellspacing="0" border=1>
	<tr><td class="level1">Soalan Parlimen (Baru)</td></tr>
	<tr><td><?php echo menu("Kemasukan Data","action=newdoc",$_GET['action'],"newdoc","../images/b1.gif")?></td></tr>
	
	<tr><td class="level2"><br/>Senarai Data</td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh","action=list&view=bydate","bydate",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama Y.B","action=list&view=byyb","byyb",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>
	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Aturan Urusan Mesyuarat","action=aturan","aturan",$_GET['action'],"../images/list.gif")?><br/><br/></td></tr>

	<tr><td class="level1">Soalan Parlimen (Lama)</td></tr>
	<tr><td><?php echo menu("Kemasukan Data","action=olddoc",$_GET['action'],"olddoc","../images/b1.gif")?></td></tr>	
	
	<tr><td class="level2"><br/>Senarai Data</td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh","action=list&view=obydate","obydate",$_GET['view'],"../images/list.gif")?></td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Sesi","action=list&view=obysesi","obysesi",$_GET['view'],"../images/list.gif")?><br/><br/></td></tr>	
	
	<tr><td class="level1">Sesi Perbahasan</td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Daftar Sesi Perbahasan","action=newbahas","newbahas",$_GET['view'],"../images/list.gif")?></td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Sesi","action=list&view=bbysesi","bbysesi",$_GET['view'],"../images/list.gif")?></td></tr>	
	
	<tr>
		<td><br/><br/>
		<form name="search" action="redirect.php" method="post">
			<div>
				<input type="text" name="Carian" class="txt" value="" size="20"/>
				<img src="../images/search.gif"/>
				<br /><input name="rekod" type="radio" value="1" <?php if($_GET['rekod'] == 1){?>checked="checked"<?php } ?> /> Rekod Lama<br />&nbsp;&nbsp;&nbsp&nbsp;- <font size="-8" color="#0000CC">Tahun 2008 Ke Bawah</font> 		
				<br /><input name="rekod" type="radio" value="0" <?php if($_GET['rekod'] == 0 or $_GET['rekod'] == ''){?>checked="checked"<?php } ?>  /> Rekod Baru<br />&nbsp;&nbsp;&nbsp&nbsp;- <font size="-8" color="#0000CC">Tahun 2009 Ke Atas</font>
			</div>
		<!-- <center><img src="../images/search.gif"/><a href="index.php?action=CarianLengkap">Carian Lengkap</a></center><br /> -->
		</form>
		</td>
	</tr>
</table>