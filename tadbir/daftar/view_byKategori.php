<?php 
$sqlRole	= "SELECT * FROM roles ORDER BY role";
$rsRole		= mysql_query($sqlRole);

?>
<table width=100% border=0 cellspacing=1 style="border-collapse:collapse">
	<tr>
		<td colspan="6"><strong>Senarai Pengguna Mengikut Kategori</strong></td>
	</tr>
	<tr>
	  <th width="4%">Bil</th>
	  <th width="28%">Nama</th>
		<th width="22%">Agensi / Bahagian di Kementerian Kesihatan</th>
		<th width="16%">Jawatan</th>
	    <th width="11%">No. Telefon</th>
	    <th width="19%">Emel</th>
	</tr>
	<?php 	
	while($rowRole=mysql_fetch_array($rsRole)){
		$roleId		= $rowRole['id'];
		$roleName	= strtoupper($rowRole['role']);
		$roleVar1	= $roleId;
		$roleVar2	= '%+'.$roleId;
		$roleVar3	= $roleId.'+%';
		$roleVar4	= '%+'.$roleId.'+%';
	
		$sqlKategori = "SELECT pengguna.*, agensi.nama AS agensi
						FROM pengguna
						LEFT JOIN agensi ON pengguna.agensi_id = agensi.id
						WHERE 
							pengguna.roles LIKE '$roleVar1' OR
							pengguna.roles LIKE '$roleVar2' OR
							pengguna.roles LIKE '$roleVar3' OR
							pengguna.roles LIKE '$roleVar4'
						ORDER BY pengguna.nama ASC";
		$rsKategori	= mysql_query($sqlKategori);
		$rsNumRow	= mysql_num_rows($rsKategori);

		?>
		<tr>
		  <td colspan="6" style="color:#990000; font-size:10pt; font-weight:bold"><?php echo $roleName; ?></td>
		</tr>
		<?php
		if($rsNumRow == 0){
		?>
		<tr bgcolor="#B2DFEE">
		  <td colspan="6" class=rec style="padding-left:20px ">Tiada Rekod </td>
	    </tr>
		<?php
		}

		$i=0;
		while($rowKategori = mysql_fetch_array($rsKategori)){ 
		$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
		?>

		<tr bgcolor="<?php echo $rcolor; ?>">
		  <td class=rec style="padding-left:20px "><?php echo $i+1;?></td>
			<td class=rec><a href="index.php?action=details&id=<?php echo $rowKategori['id'];?>"><?php echo stripslashes($rowKategori['nama'])?></a>&nbsp;</td>
			<td class=rec><?php echo $rowKategori['agensi'];?></td>
			<td class=rec><?php echo $rowKategori['jawatan'];?>&nbsp;</td>
			<td class=rec><?php echo $rowKategori['telefon'];?></td>
			<td class=rec><?php echo $rowKategori['emel'];?></td>
		</tr>

		<?php 
		$i++;
		}
		?>
		<tr>
		  <td colspan="6" class=rec>&nbsp;</td>
		</tr>		
		<?php
	}?>
</table>
