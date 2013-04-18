<?php
	session_start();
	include("../view.php");
	
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isAdmin = checkOfficer($_SESSION['userid'],1,$conn);
	$isPSU = checkOfficer($_SESSION['userid'],8,$conn);	 
	
	$pgNum = 1;
	$pgRow = 25;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}else
		$pgNum = 1;
	$offset =($pgNum -1)*$pgRow;
	
	$view_name = $_GET['view'];
	$view = new View();

if($_GET['view']=='bynama' || $_GET['view']==''){
	
	$qry_all = "SELECT pengguna.sistem,pengguna.nama,pengguna.agensi_id,pengguna.nokp,pengguna.jawatan,
				pengguna.emel,pengguna.telefon,agensi.nama, pengguna.id FROM pengguna
				LEFT JOIN agensi ON pengguna.agensi_id = agensi.id";
		
	$qry = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.nokp,pengguna.jawatan ,
			pengguna.emel, pengguna.telefon, agensi.nama AS nama_agensi, pengguna.id,pengguna.id_tbl FROM pengguna 
			LEFT JOIN agensi ON pengguna.agensi_id = agensi.id ORDER BY pengguna.nama
			LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		//$view->col = array("nama_agensi","jawatan","telefon","emel");
		$view->col = array("nokp","nama_agensi","jawatan","emel");//add by zaidi for report on nokp
		//$view->header = array("Nama","Agensi/Bahagian di Kementerian Kesihatan","Jawatan","No. Telefon","E-mel");
		$view->header = array("Nama","No KP","Agensi/Bahagian di Kementerian Kesihatan","Jawatan","E-mel");
		//$view->key = array("id","nama");
		$view->key = array("id_tbl","nama");
		$view->ref = "index.php?action=details&id_tbl=";
				
		$view->query($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bynama&page=";

}

elseif($_GET['view'] =='byagensi'){
	$qry_all = "SELECT pengguna.sistem,pengguna.nama,pengguna.agensi_id,pengguna.nokp,pengguna.jawatan,
				pengguna.emel,pengguna.telefon,agensi.nama, pengguna.id FROM pengguna
				LEFT JOIN agensi ON pengguna.agensi_id = agensi.id
				WHERE pengguna.agensi_id<>0";
		
	$qry = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.nokp,pengguna.jawatan ,
			pengguna.emel, pengguna.telefon, agensi.nama AS nama_agensi, pengguna.id,pengguna.id_tbl FROM pengguna 
			LEFT JOIN agensi ON pengguna.agensi_id = agensi.id 
			WHERE pengguna.agensi_id<>0 
			ORDER BY agensi.nama ASC, pengguna.nama ASC
			LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nokp","jawatan","emel");
		$view->header = array("Nama","No KP","Jawatan","E-mel");
		$view->cat = "nama_agensi";
		$view->key = array("id_tbl","nama");
		$view->ref = "index.php?action=details&id_tbl=";
		$view->query($conn,$db_voffice);
		$view->OutCat2();
		//$view->out();ng
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byagensi&page=";
}


elseif($_GET['view'] =='bykategori'){
/*
	$qry_all = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.jawatan ,
			pengguna.emel, pengguna.telefon, roles.role AS role, pengguna.id FROM pengguna 
			LEFT JOIN roles ON pengguna.roles LIKE '%agensi.id%'  
			WHERE pengguna.agensi_id=0";
		
	$qry = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.jawatan ,
			pengguna.emel, pengguna.telefon, roles.role AS role, pengguna.id FROM pengguna 
			LEFT JOIN roles ON pengguna.roles LIKE '%agensi.id%'  
			WHERE pengguna.agensi_id=0 
			ORDER BY jawatan ASC, nama Asc
			LIMIT $offset,$pgRow";
	
	$qry_all 	= "SELECT pengguna.nama FROM pengguna";
	$qry		= "SELECT * FROM pengguna ORDER BY nama";
	
	echo $qry;
	$view->query_all = $qry_all;
	$view->query = $qry;
	$view->col = array("jawatan","telefon","emel");
	$view->header = array("Nama","Jawatan","No. Telefon","E-mel");
	$view->cat = "role";
	$view->key = array("id","nama");
	$view->ref = "index.php?action=details&id=";
	$view->query($conn,$db_voffice);
	$view->OutCat2();
	//$view->out();
	$ref = "<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bykategori&page=";
*/
	include ("view_byKategori.php");
}


elseif($_GET['view'] =='bykategori'){
	$qry_all = "SELECT pengguna.sistem,pengguna.nama,pengguna.agensi_id,pengguna.jawatan,
				pengguna.emel,pengguna.telefon,agensi.nama, pengguna.id FROM pengguna
				LEFT JOIN agensi ON pengguna.agensi_id = agensi.id";
		
	$qry = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.jawatan ,
			pengguna.emel, pengguna.telefon, agensi.nama AS nama_agensi, pengguna.id, pengguna.roles As roles FROM pengguna 
			LEFT JOIN agensi ON pengguna.agensi_id = agensi.id ORDER BY pengguna.roles
			LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama_agensi","jawatan","telefon","emel");
		$view->header = array("Nama","Agensi/Bahagian di Kementerian Kesihatan","Jawatan","No. Telefon","E-mel");
		$view->cat = "roles";
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details&id=";
		$view->query($conn,$db_voffice);
		//$view->OutCat2();
		$view->OutCat3();
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?mode=Pendaftaran&action=list&view=bykategori&page=";
}

elseif($_GET['view']=='bytahap'){
	
		$qry_all = "SELECT nama, modul1, modul2, modul3, modul4, modul5, modul6, id FROM pengguna ORDER BY nama";
		$qry = "SELECT nama, modul1, modul2, modul3, modul4, modul5, modul6, id FROM pengguna ORDER BY nama LIMIT $offset,$pgRow";
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("modul1","modul2","modul3","modul4","modul5","modul6");
		$view->header = array("Nama","Soal Jawab Parlimen","Kalendar Parlimen","Profil","Jemaah Menteri","Pendaftaran","Kata Kunci");
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details&id=";
		$view->query($conn,$db_voffice);
		$view->out2();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bytahap&page=";

}

elseif($_GET['view'] =='bysistem'){
	//$qry_all = "SELECT pengguna.sistem,pengguna.nama,pengguna.agensi_id,pengguna.jawatan,
	//			pengguna.emel,pengguna.telefon,agensi.nama, pengguna.id FROM pengguna
	//			LEFT JOIN agensi ON pengguna.agensi_id = agensi.id";
	
	$qry_all = "SELECT nama,modul1,modul2,modul3,modul4,modul5,modul6,id,sistem FROM pengguna ORDER BY sistem ASC";
	$qry = "SELECT nama,modul1,modul2,modul3,modul4,modul5,modul6,id,sistem FROM pengguna ORDER BY sistem ASC, nama ASC LIMIT $offset, $pgRow";
		
	//$qry = "SELECT pengguna.sistem, pengguna.nama, pengguna.agensi_id,pengguna.jawatan , 
	//		pengguna.emel, pengguna.telefon, agensi.nama AS nama_agensi, pengguna.id FROM pengguna 
	//		LEFT JOIN agensi ON pengguna.agensi_id = agensi.id ORDER BY pengguna.roles
	//		LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("modul1","modul2","modul3","modul4","modul5","modul6");
		$view->header = array("Nama","Tahap 1","Tahap 2","Tahap 3","Tahap 4","Tahap 5","Tahap 6");
		//$view->col = array("nama_agensi","jawatan","telefon","emel");
		//$view->header = array("Nama","Agensi/Bahagian di Kementerian Kesihatan","Jawatan","No. Telefon","E-mel");
		$view->cat = "sistem";
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details&id=";
		$view->query($conn,$db_voffice);
		$view->OutCat2();
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?mode=Pendaftaran&action=list&view=bysistem&page=";
}
elseif($_GET['view'] =='bystatus'){

	$qry_all = "SELECT nama, jawatan, telefon, emel, statusMohon, id from pengguna order by statusMohon, nama";
		
	$qry = "SELECT nama, jawatan, telefon, emel, statusMohon, id from pengguna order by statusMohon, nama LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("jawatan","telefon","emel");
		$view->header = array("Nama","Jawatan","No. Telefon","E-mel");
		$view->cat = "statusMohon";
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details&id=";
		$view->query($conn,$db_voffice);
		$view->OutCat2();
		//$view->out();ng
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?mode=Pendaftaran&action=list&view=bystatus&page=";
}
elseif($_GET['view'] =='perhatian'){

	$view->col = array("jawatan","telefon","emel");
	$view->header = array("Nama","Jawatan","No. Telefon","E-mel");
	$view->key = array("id","nama");
	$view->ref = "index.php?action=details&id=";


	if($isPSU)
	{	
		$query_all = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='UNTUK DISAHKAN' ORDER BY nama";
		$qry = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='UNTUK DISAHKAN' ORDER BY nama LIMIT $offset,$pgRow";
				
		$view->query = $qry;
		$view->query_all = $query_all;
		$view->query($conn,$db_voffice);	
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=perhatian&page=";	
		
	}

	if($isHEK)
	{	
		$query_all = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='PERMOHONAN BARU' ORDER BY nama";
		$qry = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='PERMOHONAN BARU' ORDER BY nama LIMIT $offset,$pgRow";
				
		$view->query = $qry;
		$view->query_all = $query_all;
		$view->query($conn,$db_voffice);	
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=perhatian&page=";	
		
	}
	
	if($isAdmin)
	{	
		$query_all = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE (statusMohon='LULUS' OR statusMohon='SAH' OR statusMohon='TIDAK SAH') ORDER BY nama";
		$qry = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE (statusMohon='LULUS' OR statusMohon='SAH' OR statusMohon='TIDAK SAH') ORDER BY nama LIMIT $offset,$pgRow";
				
		$view->query = $qry;
		$view->query_all = $query_all;
		$view->query($conn,$db_voffice);	
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=perhatian&page=";	
		
	}
	


}
$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);


?>