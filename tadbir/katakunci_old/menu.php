<?php
	function menu($title,$url,$param,$name,$img){			
		$class = ($param == $name)?"highlight":"";
		if($class == "")
			return "<img src=\"$img\"/><a class=\"$class\" href=\"index.php?$url\">$title</a>";			
		else
			return "<img src=\"$img\"/><font class=\"highlight\">$title</font>";
	}
?>

<table width=100% cellspacing="0" border=0 id="menu">	
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama","action=list&view=bynama","bynama",$_GET['view'],"../images/list.gif")?></td></tr>-->	
	<tr>
	  <td class="level1">Katakunci</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
  </tr>
	<tr><td><?php echo menu("Kemasukan Data","action=newdoc",$_GET['action'],"newdoc","../images/b1.gif")?></td></tr>	
	<tr>
	  <td class="level2"><?php echo menu("Senarai Kata Kunci","action=list&view=bykategori","bykategori",$_GET['view'],"../images/b1.gif")?></td>
  </tr>
	<tr>
	  <td class="level2"><?php echo menu("Senarai Kawasan Parlimen","action=list&view=bykawasan","bykawasan",$_GET['view'],"../images/b1.gif")?></td>
	  </td>
  </tr>
  <tr>
	  <td class="level2"><?php echo menu("Senarai Parti","action=list&view=byparti","byparti",$_GET['view'],"../images/b1.gif")?></td>
	  </td>
  </tr>
	
	<tr><td>
		<!--
		<form name="search" action="redirect.php" method="post">	
			<div><center>
			<img src="../images/search.gif"/>
			<input type="text" name="Carian" value="" size="20"/><br/>
			<input type="submit" value="Carian"/>
			</center></div>
		</form>	 
		-->
		</td></tr>	
</table>
