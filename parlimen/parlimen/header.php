<?php
	$main_path = "/parlimen/";
	$url = $_SERVER['PHP_SELF'];
	$path = pathinfo($url);
	$img =  str_replace($main_path, "", $path['dirname']);	
?>
<div style="background-color:#0C4490">
<center><img src="../images/<?php echo $img ?>.jpg"</center><br/>
<div style="text-align:right; margin-right:10px"><font style="color:#ffffff;font-family:Arial;font-size:8pt;font-style:italic"><?php echo "Nama Pengguna: ".$_SESSION['nama']." (".$_SESSION['jawatan'].") Masa: ".Date("j/n/Y-g:i:s A")."";?></font></div>
</div>