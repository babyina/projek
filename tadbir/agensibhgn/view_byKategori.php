<?php 
//$sql1	= "SELECT DISTINCT kategori FROM konfigurasi ORDER BY kategori ASC";
//$rs1	= mysql_query($sql1);


?>
<table width=100% border=0 cellspacing=1 style="border-collapse:collapse">
	<tr>
		<td colspan="4"><strong>Senarai Agensi/ Bahagian Mengikut Kategori</strong></td>
	</tr>
	<tr valign="top">
		    <td>&nbsp;</td>
		    <td><a href="index.php?action=list&view=bykategori&senarai=1">Agensi</a> || 
			<a href="index.php?action=list&view=bykategori&senarai=2">Bahagian Kementerian Kesihatan</a> || 
			</td>
		    <td>&nbsp;</td>
			 <td>&nbsp;</td>
	      </tr>
	<tr>
	  <th width="5%">Bil</th>
	  <th width="40%">Nama Bahagian/Agensi Kementerian Kesihatan</th>
		<th width="33%">Kategori</th>
		<th width="15%">Peringkat TKSP</th>
		<th width="7%">Hapus?</th>
    </tr>
	<?php 	
	//while($rowGroup1=mysql_fetch_array($rs1)){
		//$group1		= $rowGroup1['kategori'];
		
		$senarai = $_GET['senarai'];
		
		
		if ($senarai==1){
		
		$sql2 		= "SELECT id, nama, nama_pendek, kategori, tksp
						FROM 
							agensi WHERE kategori ='Agensi'
						ORDER BY 
							kategori ASC";
		$rs2	= mysql_query($sql2);
		}
		
		else if ($senarai==2){
		$sql2 		= "SELECT id, nama, nama_pendek, kategori, tksp
						FROM 
							agensi WHERE kategori ='Bahagian Kementerian Kesihatan'
						ORDER BY 
							kategori ASC";
		$rs2	= mysql_query($sql2);
		} 
		
		else {
		
		$sql2 		= "SELECT id, nama, nama_pendek, kategori, tksp
						FROM 
							agensi
						ORDER BY 
							kategori ASC";
		$rs2	= mysql_query($sql2);
		
		}
		
		$rsNumRow	= mysql_num_rows($rs2);

		?>
		
		<?php
		if($rsNumRow == 0){
		?>
		<tr bgcolor="#B2DFEE">
		  <td colspan="4" class=rec style="padding-left:20px ">Tiada Rekod </td>
	    </tr>
		<?php
		}

		$i=0;
		while($rowData = mysql_fetch_array($rs2)){ 
		$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
		?>

		<tr bgcolor="<?php echo $rcolor; ?>">
		  <td class=rec style="padding-left:20px "><?php echo $i+1;?></td>
			<td class=rec><a href="index.php?action=details&id=<?php echo $rowData['id'];?>"><?php echo $rowData['nama']?></a>&nbsp;</td>
			<td class=rec><?php echo $rowData['kategori'];?></td>
			<td class=rec><?php if($rowData['tksp'] != null){echo $rowData['tksp'];} else { echo "Tiada";}?></td>
			<td class=rec align="center"><a href="index.php?action=deleteDoc&id=<?php echo $rowData['id'];?>"><img src="../images/del.gif" width="18" height="15" border="0"></a></td>
		</tr>

		<?php 
		$i++;
		}
		?>
		<tr>
		  <td colspan="4" class=rec>&nbsp;</td>
		</tr>		
		<?php
	//}?>
</table>
