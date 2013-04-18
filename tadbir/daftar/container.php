<?php
	$mode=$HTTP_GET_VARS['mode'];
	$action = $HTTP_GET_VARS['action'];
	switch ($mode){
		case "Pendaftaran":include('pendaftaran.php');break;
		case "KTangan":include("ktangan.php");break;		
		case "Keyword":include("keyword.php");break;
		case "Summary":include("summary.php");break;
		case "Modul":include("modul.php");break;
		case "list":
			if($rekod=='KTangan' && $action=='MengikutNama'){
				include('ktangan.php');
			}else{
				include('keyword.php');
			}
			break;
		case "delete":
			if($action=='keyword'){
				include('keyword.php');
			}elseif($action=='KTangan'){
				include('ktangan.php');
			}			
			break;
	}

?>