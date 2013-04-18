<body>
<?php
	$conn = mysql_connect("localhost","root","") or die ("Could not connect");
	mysql_select_db("konfigurasi",$conn);
	function ListKategori($def=""){
		$qry = "SELECT DISTINCT(kategori) FROM konfigurasi ORDER BY kategori";
		$result = mysql_query($qry) or die("could not query ".mysql_error());
		while($rows = mysql_fetch_array($result)){			
			echo ($def<>$rows['kategori'])?"<option>".$rows['kategori']."</option>":"<option selected>".$rows['kategori']."</option>";
		}
	}
	if($_POST['Simpan']){
		$qry = "INSERT INTO konfigurasi (kategori,butiran) VALUES ('$kategori','$butiran')";
		mysql_query($qry) or die ("Could not save record");
		echo "<br/><br/><center><div class=\"subheader1\">Rekod Telah Disimpan</div></center>";
	}//simpan rekod baru
	elseif($mode=='delete'){		
		$i=0;
		foreach($DeleteId as $item){
			//echo $item."<br/>";
			$qry = "DELETE FROM konfigurasi WHERE id='$item'";
			mysql_query($qry) or die("Could not delete");
			$i++;
		}
		echo "<br/><br/><center><div class=\"subheader1\">".$i." item telah dihapuskan</div></center></div>";
	}//process selected for delete
	elseif($mode=='BorangKeyword'){
		?>
		<fieldset><legend><b>Keyword</b></legend>
		<form name="borang" method="post">
			<table>
				<tr><td>Kategori</td><td>:</td><td><select name="kategori"><option/><?php ListKategori() ?></select></td></tr>
				<tr><td>Butiran</td><td>:</td><td><input name="butiran" size="30"/></td></tr>
			</table>
			<br/><input type="submit" name="Simpan" value="SIMPAN"/>
		</form>
		</fieldset>
		<?php
	}//borang rekod baru
	elseif($action=="MengikutKategori"){
		$qry = "SELECT id,kategori, butiran FROM konfigurasi ORDER BY kategori,butiran ASC";
		$result = mysql_query($qry) or die("could not query");
		echo "<form name=\"borang\" method=\"post\" action=\"index.php?mode=delete&action=keyword\">";
		echo "<table>";
		echo "<tr><th/><th>Butiran</th></tr>";
		$cat = "";
		while($rows=mysql_fetch_array($result)){			
			if($cat<>$rows['kategori']){
				$cat = $rows['kategori'];
				echo "<tr><td colspan=\"2\"><b>".$cat."</b></td></tr>";
			}
			echo "<tr><td><input type=\"checkbox\" name=\"DeleteId[]\" value=\"".$rows['id']."\">&nbsp;&nbsp;<td>".$rows['butiran']."</td></tr>";
		}
		echo "</table>";
		echo "<hr/><a href='' onClick='submit();return false;'>Hapus Rekod </a>";
		echo "</form>";
	}//list by kategori
?>
</body>