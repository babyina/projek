<?php 
	$view = $_GET['view'];
	switch($view){
		case	'byDewan': byDewan();break;
	}	
?>

<?php
//Function : Senarai(view) status permohonan mengikut tarikh permohonan
function byDewan(){ 
	?>
	<table width="100%" align="center" border="0" >
		<tr height="20">
		  <td width="80%"><div align="left"><strong>Senarai Soal Jawab Mengikut Status Jawapan</strong></div>
		  <td width="20%" align="right">
		  <select name="senarai" id="senarai" onChange="MM_jumpMenu('parent',this,0)">
			  <option value="index.php?action=listRizal&view=bystatus" selected>Semua</option>
			  <option value="index.php?action=listRizal&view=bystatus">Mengikut Tindakan Agensi</option>
			  <option value="index.php?action=listRizal&view=bystatus">Mengikut Tindakan HEK</option>
			</select>
		</tr>
	</table>
	<table width="100%" align="center" border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse">
		<tr>
			<th width="19" scope="col" >Bil</th>
			<th width="81" scope="col" >Parlimen / Penggal / Mesyuarat</th>	
			<th width="349" scope="col" >Tarikh Mula </th>
			<th width="312" scope="col" >Tarikh Akhir </th>
			<th width="183" scope="col" >Bentuk Soalan </th>
		</tr>
		<?php
		$sql1 	= "SELECT 
					DISTINCT parlimen.status AS status
					FROM parlimen,ahli_parlimen
					WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
					ORDER BY parlimen.tkh_bentang_jawapan ASC";
		$rs1	= mysql_query($sql1) or die(mysql_error());
		while($row1=mysql_fetch_array($rs1)){
			$bil	= 1;
			$status = $row1['status'];
			?>
			<tr>
				<td colspan="5" class="group1"><?php //echo strtoupper(getStatusName($status)); ?></td>
			</tr>
			<?php
			$sql2 = "SELECT 
						parlimen.status AS status, 
						parlimen.id, 
						parlimen.tkh_bentang_jawapan AS Tarikh,
						ahli_parlimen.nama AS nama_yb, 
						bentuk_soalan,
						no_soalan, 
						parlimen.status,
						perkara
					FROM parlimen,ahli_parlimen
					WHERE 
						parlimen.status = '$status' AND 
						parlimen.ahli_dewan_id = ahli_parlimen.id
					ORDER BY 
						parlimen.tkh_bentang_jawapan ASC";

			$rs2		= mysql_query($sql2) or die(mysql_error());
			while($row2=mysql_fetch_array($rs2)){
				$rowcolor	= ($bil % 2)? "#C3D9FF" : "#e7efff";
				?>
				<tr valign="top" style="background-color:<?php echo $rowcolor;?>" onmouseover="this.style.backgroundColor='#dddddd';" onmouseout="this.style.backgroundColor='<?php echo $rowcolor;?>';">
					<td align="right" style="padding-right:5px;" ><?php echo $bil; ?></td>
					<td><a href="index.php?action=details&id=<?php echo $row2['id']; ?>"><?php echo reverse($row2['Tarikh']); ?></a></td>
					<td><?php echo ucwords(strtolower($row2['nama_yb'])); ?></td>
					<td><?php echo $row2['no_soalan'].'. '.$row2['perkara']; ?></td>
					<td><?php echo $row2['bentuk_soalan']; ?></td>
				</tr>

				<?php
				$bil++;
			}?>
			<?php 
		}
		?>
	</table>
<?php 
} ?>