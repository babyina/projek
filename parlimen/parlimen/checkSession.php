<?php
session_start();
if ($_SESSION['valid'] == false){
	$url 		= $_SERVER['PHP_SELF'];
	$path 		= pathinfo($url);
	$qstring	= $_SERVER['QUERY_STRING'];
	
	$cont	= rawurlencode($path["dirname"].'/'.$path["basename"].'?'.$qstring);
	echo "Invalid Session";	
	header("location:../index.php?cont=".$cont);
	//header("location:../index.php");
	exit(0);
}else{
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >9000000000000){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
}
?>