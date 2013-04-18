<?php
	$pgNum = 1;
	$pgRow = 20;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}	
	$offset =($pgNum -1)*$pgRow;
?>
<body>
<?php
	if($_POST['Edit']){			
		$id = $_GET['id'];
		if($sys_acl >0 && $sys_acl<3){
			$qry = "SELECT * FROM pengguna WHERE Id='$id'";
			$result = mysql_query($qry) or die(mysql_error());
			$row = mysql_fetch_array($result);					
			include('ktangan_form.php');
		}else
			echo $acl_denied;
	}
	elseif($_POST['Kemaskini']){	
		$id = $_GET['id'];
		$Nama = $_POST['Nama'];$Jabatan = $_POST['Jabatan'];$Jawatan = $_POST['Jawatan'];
		$Telefon = $_POST['Telefon'];$Emel = $_POST['Emel'];$Handphone = $_POST['Handphone'];
		$qry = "UPDATE pengguna SET Nama='$Nama', Jabatan='$Jabatan',Jawatan='$Jawatan',Telefon='$Telefon',Handphone='$Handphone',Emel='$Emel' 
		WHERE Id = '$id'";
		mysql_query($qry,$conn) or die(mysql_error());
		echo $update_record_msg;
	}
	elseif($_GET['action']=='OpenDoc'){	
		$id = $_GET['id'];
		$qry = "SELECT * FROM pengguna WHERE Id='$id'";
		$result = mysql_query($qry) or die(mysql_error());
		$row = mysql_fetch_array($result);			
		include('ktangan_form.php');
	}
	elseif($action=='list' && $view='MengikutNama'){		
		$kod = $_GET['kod'];
		include("../view.php");
		
		$view = new View();
		$view->ref = "?mode=KTangan&action=OpenDoc&id=";
		$view->table = "pengguna";
		$view->limit = "LIMIT $offset,$pgRow";
		
		$view->col = array("Jawatan","Bahagian","Telefon","Emel");
		$view->header = array("Nama Pegawai","Jawatan","Jabatan","Telefon","Emel");
		$view->key = array("Id","Nama");
		$qry = "SELECT * FROM pengguna WHERE Jenis='$kod' ORDER BY Nama ASC ";
		$view->query = $qry;
		
		$view->Query($conn,$db_voffice);
		$view->out();
		
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?mode=KTangan&action=list&view=MengikutNama&kod=$kod&page=";
		$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);		
	}
 ?>
<body>