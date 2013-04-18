<?php 
$view_k =$_GET[view];
?>
<table width=100% border=0 cellspacing=1 style="border-collapse:collapse">
	<tr>
		<td colspan="4"><strong>Senarai Kata Kunci Mengikut Kawasan Parlimen</strong></td>
	</tr>
	<tr>
	  <th width="4%">Bil</th>
	  <th width="42%">Butiran</th>
		
		<th width="5%">Hapus?</th>
    </tr>
	<?php 	
	$sql2 		= "SELECT id, nama
						FROM 
							kawasan
						ORDER BY 
							nama ASC";
		$rs2	= mysql_query($sql2);
		$rsNumRow	= mysql_num_rows($rs2);
	
	
	while($rowGroup1=mysql_fetch_array($rs2)){
		$cat = "Kawasan Parlimen";
		

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
			<td class=rec><a href="index.php?action=details&id=<?php echo $rowData['id'];?>&cat=<?php echo $cat;?>"><?php echo $rowData['nama']?></a>&nbsp;</td>
			<td class=rec align="center"><a href="index.php?action=deleteDoc&id=<?php echo $rowData['id'];?>&view_k=<?php echo $view_k;?>"><img src="../images/del.gif" width="18" height="15" border="0"></a></td>
		</tr>

		<?php 
		$i++;
		}
		?>
		<tr>
		  <td colspan="4" class=rec>&nbsp;</td>
		</tr>		
		<?php
	}?>
</table>
