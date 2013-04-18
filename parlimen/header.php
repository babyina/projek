<?php
	$main_path = "/parlimen/";
	$url = $_SERVER['PHP_SELF'];
	$path = pathinfo($url);
	$img =  str_replace($main_path, "", $path['dirname']);	
?>


<table border=0 width=100% cellspacing=0 >
	<tr height="69px" style="background-color:#0093a6;">
		<!--<td style="padding:0px"><img src="../images/<?php //echo $img ?>.jpg"></td>-->
		<td style="padding:0px"><img src="../parlimen/images/banner-in3.jpg"></td>
		<td></td>
	</tr>
</table>
<div style="background-color:#3F4C6B; text-align:right; border-top: 1px solid #C0C0C0;">
	<font style="color:#ffffff; font-family:Arial, Helvetica, sans-serif;font-size:8pt">
	<?php echo "Nama Pengguna: ".$_SESSION['nama']." (".$_SESSION['jawatan'].") Masa:".Date("j/n/Y-g:i:s A")."";?>
	<?php //echo "Nama Pengguna: ".$_SESSION['nama']." (".$_SESSION['jawatan'].") Masa:".Date("j/n/Y-g:i:s A",time()+(8*3600)).""; asal?>
	</font>
</div>
