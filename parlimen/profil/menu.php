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
	<tr><td class="level1">Dewan Rakyat</td></tr>
	<tr><td><?php echo menu("Kemasukan Data","action=newdoc",$_GET['action'],"newdoc","../images/b1.gif")?></td></tr>
	
	<tr><td class="level2"><br/>Senarai Data</td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama","action=list&view=bynama","bynama",$_GET['view'],"../images/list.gif")?></td></tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Kawasan","action=list&view=bykawasan","bykawasan",$_GET['view'],"../images/list.gif")?><br/><br/></td></tr>-->
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<tr><td class="level2"><br/></td></tr>	
	<tr><td class="level1">Dewan Negara</td></tr>
	<tr><td><?php echo menu("Kemasukan Data","action=newdoc2",$_GET['action'],"newdoc2","../images/b1.gif")?></td></tr>	
	
	<tr><td class="level2"><br/>Senarai Data</td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama","action=list2&view=bynama2","bynama2",$_GET['view'],"../images/list.gif")?></td></tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Negeri","action=list2&view=bynegeri","bynegeri",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Negeri","action=list2&view=bynegeri","bynegeri",$_GET['view'],"../images/list.gif")?><br/><br/></td></tr>	-->

	<tr><td><br/><br/><br/><br/>
		<form name="search" action="redirect.php" method="post">	
			<!--<div><center>
				<img src="../images/search.gif"/>
				<input type="text" name="Carian" value="" size="20"/><br/>
				<input type="submit" value="Carian"/>
			</center></div>-->
		</form>
		</td>
	</tr>
	<tr>
	  <td><p>&nbsp;</p><center>
	    <p><a href="../logout.php"><img src="../images/logout.gif" alt="Logout" width="24" height="24" border="0"/>&nbsp;Logout</a></p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></td>
  </tr>
	
</table>
