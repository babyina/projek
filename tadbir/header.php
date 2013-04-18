<?php
	$main_path = "/tadbir/";
	$url = $_SERVER['PHP_SELF'];
	$path = pathinfo($url);
	$img =  str_replace($main_path, "", $path['dirname']);	
?>
<table border=0 width=100% cellspacing=0>
	<tr height="69px" style="background-image:url(../images/bgDark.jpg);">
		<!--<td><img src="../images/<?php //echo $img ?>.jpg"></td>-->
		<td><img src="../images/daftar.jpg"></td>
		<td></td>
	</tr>
</table>
<div style="background-color:#3F4C6B; text-align:right; border-top: 1px solid #C0C0C0;">
	<font style="color:#ffffff; font-family:Arial, Helvetica, sans-serif;font-size:8pt">
	<?php echo "Nama Pengguna: ".$_SESSION['nama']." (".$_SESSION['jawatan'].") Masa: ".Date("j/n/Y-g:i:s A")."";?>
	</font>
</div>
