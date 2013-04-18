<body>
<?php
	function Paging($resultAll,$pgRow=20,$ref,$currentPage){
		$factor = 5;		
		$page = array();
		$total = mysql_fetch_object($resultAll)->Bil;			
		$pg = $total/$pgRow + (($total%$pgRow >0)?1:0);
		$totalPage = floor($pg);
		for($i=1;$i<=ceil($pg);$i++){
			$page[$i] = $i;
		}		
		$start = ($currentPage%$factor==0)?floor($currentPage/$factor):floor($currentPage/$factor)+1;		
		$mula = $factor*($start-1) + 1;	
		echo "<table border=\"0\" width=\"60%\">";
		echo "<tr><td align=\"left\">";
		echo ($mula-1>0)?$ref.($mula-1)."\"><img src='../images/previous.gif'></a>":"";
		for($i=$mula;($i<=$factor*$start);$i++){			
			echo ($i<=$pg)?$ref.$i."\">[".$i."]</a>&nbsp;":"";
		}
		echo ($i<$pg)?$ref.$i."\"><img src='../images/next.gif'></a>":"";		
		echo "</td><td align=\"right\">m.s $currentPage/$totalPage</td></tr>";		
		echo "</table>";
	}
	
	$pgNum = 1;
	$pgRow = 20;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	};
	$offset =($pgNum -1)*$pgRow;
		
	mysql_select_db($db_voffice,$conn);

	function ListKategori($keyword,$def=""){
		foreach($keyword as $kategori){
			echo ($def<>$kategori)?"<option>$kategori</option>":"<option selected>$kategori</option>";
		}
	}
	
	
	if($_POST['Simpan']){
		$kategori = $_POST['kategori'];$butiran=$_POST['butiran'];$kod=$_POST['kod'];$butiran2=$_POST['butiran2'];
		$qry = "INSERT INTO konfigurasi (kategori,butiran,kod,butiran2) VALUES ('$kategori','$butiran','$kod','$butiran2')";
		mysql_query($qry) or die (mysql_error());
		echo $save_record_msg;
	}//simpan rekod baru
	elseif($_POST['Kemaskini']){		
		$id = $_GET['id'];$kategori=$_POST['kategori'];$butiran = $_POST['butiran'];$kod = $_POST['kod'];$butiran2=$_POST['butiran2'];
		$qry = "UPDATE konfigurasi SET kategori='$kategori',butiran='$butiran',kod='$kod',butiran2='$butiran2' WHERE id='$id'";
		mysql_query($qry) or die(mysql_error());
		echo $update_record_msg;
	}//update
	elseif($_POST['deleteDoc']){
		if($_GET['mode']=='Keyword'){
			$id = $_POST['id'];
			$qry = "DELETE FROM konfigurasi WHERE id = '$id'";
			mysql_query($qry) or die(mysql_error());
			header("location:".$_SERVER['HTTP_REFERER']);
		}
	}//delete
	elseif($_POST['Edit']){	
		if($sys_acl!=0 && $sys_acl <=2){
			$id = $_GET['id'];
			$qry = "SELECT * FROM Agensi";
			$result = mysql_query($qry) or die(mysql_error());
			$row = mysql_fetch_array($result);
			include('keyword_form.php');
		}else
			//laila add here
			$id = $_GET['id'];
			$qry = "SELECT * FROM konfigurasi WHERE id='$id'";
			$result = mysql_query($qry) or die(mysql_error());
			$row = mysql_fetch_array($result);
			include('keyword_form.php');
			//echo $acl_deny_access;
			//laila edit until here
	}//open doc or edit
	elseif($_GET['action']=='OpenDoc'){						
		$id = $_GET['id'];
		$qry = "SELECT * FROM konfigurasi WHERE id='$id'";
		$result = mysql_query($qry) or die(mysql_error());
		$row = mysql_fetch_array($result);
		include('editKatakunci.php');		
	}//open doc or edit
	elseif($_GET['action']=='NewDoc'){
		include('editKatakunci.php');
	}//borang rekod baru
	elseif($_GET['action']=="list" && $_GET['view']=="MengikutKategori"){
		$qry = "SELECT id,kategori, butiran,kod FROM konfigurasi ORDER BY kategori,kod,butiran ASC LIMIT $offset, $pgRow";
		$result = mysql_query($qry) or die("could not query");		
		//laila: ganti nama borang dgn entry_form
		echo "<form name=\"entry_form\" method=\"post\">";
		echo "<table border=\"1\" width=\"60%\">";
		echo "<tr><th/><th/><th>Butiran</th>".($sys_acl==1?"<th>Hapus?</th>":"")."</tr>";
		$cat = "";
		while($rows=mysql_fetch_array($result)){			
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			$i++;
			if($cat<>$rows['kategori']){
				$cat = $rows['kategori'];
				echo "<tr><td colspan=".($isAdmin?"4":"3")."><b>".$cat."</b></td></tr>";
			}			
			$url = "<a href='index.php?mode=Keyword&action=OpenDoc&id=".$rows['id']."'>".$rows['butiran']."</a>";
			$del = $sys_acl==1?"<td align=\"center\"><a href='' onClick=\"return deleteDoc('Keyword','".$rows['id']."')\"><img src=\"../images/del.gif\" class=\"del\"></a></td>":"";			
			echo "<tr bgcolor=\"".$rcolor."\"><td/><td>&nbsp;".$rows['kod']."</td><td>".$url."</td>".$del."</tr>";
		}		
		echo "</table>";
		$resultAll = mysql_query("SELECT COUNT(*) AS Bil FROM konfigurasi") or die(mysql_error());
		$ref = "<a href=\"".$_SERVER['PHP_SELF']."?mode=Keyword&action=list&view=MengikutKategori&page=";
		Paging($resultAll,$pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);						
		echo "</form>";
	}//list by kategori
?>
</body>