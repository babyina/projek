<?php session_start();
	
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isAdmin = checkOfficer($_SESSION['userid'],1,$conn);
	$isPSU = checkOfficer($_SESSION['userid'],8,$conn);
?>	
<script language="JavaScript" src="../validation.js" type="text/javascript"></script>
<script language="javascript">
	var $id = 0;
	var a_state = 0;
	var image1 = new Image(); image1.src = "../images/expand.gif";
	var image2 = new Image(); image2.src = "../images/collapse.gif"; 
	
	function collapse(state){
		var obj = document.getElementById("agensi");									
		if(state==0){
			obj.style.display = 'none';							
			document['img_collapse'].src = image1.src;
			return 1;
		}else{
			obj.style.display = '';
			document['img_collapse'].src = image2.src;
			return 0;
		}
	}
</script>
		
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
	<tr><td class="level1">Pendaftaran Pengguna </td></tr>
	<!--<tr><td class="m_item"><img src="../images/b4.gif"/><a style="<?php echo menuClick($_GET['view'],"Perhatian") ?>"href="index.php?action=list&view=perhatian">Untuk Tindakan</a>-->
	<?php 
	
	/*if($isPSU)
	{	
		$query = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='UNTUK DISAHKAN' ORDER BY nama";	
	}

	if($isHEK)
	{	
		$query = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE statusMohon='PERMOHONAN BARU' ORDER BY nama";	
	}
	
	if($isAdmin)
	{	
		$query = "SELECT nama, jawatan, telefon, emel, statusMohon, id FROM pengguna WHERE (statusMohon='LULUS' OR statusMohon='SAH' OR statusMohon='TIDAK SAH') ORDER BY nama";		
	}
	mysql_select_db ($db_voffice, $conn) or die (mysql_error());
	
	$result = mysql_query($query, $conn)or die(mysql_error());
	$totalrows= mysql_num_rows($result);
	
	if ($totalrows >0){ ?> <img src="../images/baru.gif"/> <?php } 
	*/?>
	
	
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	<?php if(checkOfficer($_SESSION['userid'],1,$conn)){ ?>
		<tr><td><?php echo menu("Kemasukan Data","action=newdoc3",$_GET['action'],"newdoc","../images/b3.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>	
	<?php }?>
	<tr>
	  <td class="level2"><img src="../images/b1.gif">Laporan</td>
	</tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama","action=list&view=bynama","bynama",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Agensi/Bhgn","action=list&view=byagensi","byagensi",$_GET['view'],"../images/list.gif")?></td></tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Kategori","action=list&view=bykategori","bykategori",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tahap Capaian","action=list&view=bytahap","bytahap",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<?php
	/*<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Sistem","action=list&view=bysistem","bysistem",$_GET['view'],"../images/list.gif")?></td></tr>*/
	?>
	<tr><td>&nbsp;</td></tr>
	<tr><td class="level2"><img src="../images/b1.gif">Ringkasan Capaian Modul</td></tr>	
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Soal Jawab Parlimen","action=modul&view=1","1",$_GET['view'],"../images/list.gif")?></td></tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Kalendar Parlimen","action=modul&view=2","2",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Profil","action=modul&view=3","3",$_GET['view'],"../images/list.gif")?></td></tr>
	<!--<tr><td><img src="../images/blank.gif"/><?php echo menu("Jemaah Menteri","action=modul&view=4","4",$_GET['view'],"../images/list.gif")?></td></tr>-->
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Pendaftaran","action=modul&view=5","5",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr><td><img src="../images/blank.gif"/><?php echo menu("Katakunci","action=modul&view=6","6",$_GET['view'],"../images/list.gif")?></td></tr>
	<tr>
	  <td>&nbsp;</td>
	</tr>
	<?php
	/*
	<tr><td>
		<form name="search" action="redirect.php" method="post">	
			<div style="padding-left:10px ">
			<input type="text" name="Carian" value="" size="20" class="text"/> <img src="../images/search.gif"/>
			<!--<input type="submit" value="Carian" class="button"/>-->
			</div>
		</form>
	</td></tr>
	*/
	?>
</table>
