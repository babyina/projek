<?php	
function getName($key2,$key_name,$conn){
		
	if($key2=="sesi_dewan")
	{
		if($key_name == 1)
			$key_name = "Dewan Rakyat";
		elseif($key_name == 2)
			$key_name = "Dewan Negara";
	}		
	
	elseif($key2=="kawasan_id")
	{
	$qry = "SELECT nama FROM kawasan WHERE id='$key_name'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$key_name = $row['nama'];

	}
	
	elseif($key2=="ahli_dewan_id")
	{
	$qry = "SELECT nama FROM ahli_parlimen WHERE id='$key_name'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$key_name = $row['nama'];
//	echo $key_name;

	}
	
	elseif($key2=="parti_id")
	{
	$qry = "SELECT nama_pendek FROM parti WHERE id='$key_name'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$key_name = $row['nama_pendek'];
	}
	
	return $key_name;	
}
		
$pgNum = 1;
$pgRow = 20;
if(isset($_GET['page'])){
	$pgNum = $_GET['page'];
}else
	$pgNum = 1;
$offset =($pgNum -1)*$pgRow;

$cols = $_SESSION['cols'];
$qry = $_SESSION['sql'];
//echo $qry;
$head = array();$i = 0;
foreach($cols as $key)
{	
	if($key=="sesi_dewan")
		$head[$i] = "Sesi Dewan";
	if($key=="penggal")
		$head[$i] = "Penggal";
	if($key=="mesyuarat")
		$head[$i] = "Mesyuarat";
	if($key=="tkh_mula_bersidang")
		$head[$i] = "Tarikh Mula Bersidang";
	if($key=="tkh_akhir_bersidang")
		$head[$i] = "Tarikh Akhir Bersidang";
	if($key=="tkh_bentang_jawapan")
		$head[$i] = "Tarikh Dibentangkan";
	if($key=="no_soalan")
		$head[$i] = "No Soalan";
	if($key=="bentuk_soalan")
		$head[$i] = "Bentuk Soalan";
	if($key=="perkara")
		$head[$i] = "Perkara";
	if($key=="kawasan_id")
		$head[$i] = "Kawasan Parlimen";
	if($key=="ahli_dewan_id")
		$head[$i] = "Nama Y.B";
	if($key=="parti_id")
		$head[$i] = "Wakil";
	$i++;
}	
include('../view.php');
$view = new View();
$cols[] = $_POST['column'];
$view->ref = "index.php?mode=Parlimen&action=details&id=";
$view->table = "parlimen";
$view->limit = "LIMIT $offset,$pgRow";	
$view->query = $qry;	
$view->header = $head;
$view->col = array_slice($cols,1);
$view->key = array("id",$cols[0]);
$view->Query($conn,$db_voffice);	
$view->OutSearch($conn);
$ref = "<a href='' onClick=\"gotoPage(this);return false\" id=";
$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=KeputusanCarian&page=";
$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);	
//echo $head[0];
?>
