<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jawapan Perkara Berbangkit</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="multifile_compressed.js"></script>
		<script language="JavaScript" src="../validation.js" type="text/javascript"></script>	
		<script language="javascript">
		var $id = 0;
		var a_state = 0;
		var image1 = new Image(); image1.src = "../images/expand.gif";
		var image2 = new Image(); image2.src = "../images/collapse.gif";
		
		function collapse(state,div){
			var obj = document.getElementById(div.name);								
			
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
</head>

<body bgcolor="#e7efff">
<?php
include("../config.php");
include("../keyword.php");

if($_POST['SimpanJawapanPP'])
{
	$id = $_POST['id'];
	$cid = $_POST['cid'];
	$status = $_POST['status'];
	$korperat_tarikh = $_POST['korperat_tarikh'];
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Korperat_Jawapan']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']);
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$jawapan_id = "0";
	$bahas_id = $cid;
	include("lampiran_bahas.php");

	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "UPDATE sesi_bahas_detail SET jawapan='$korperat_jawapan', maklumat_tambahan = '$korperat_tambahan' WHERE ref_no = '$cid' AND bahas_id='$id'";
	
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "<font class=fs>Jawapan telah disimpan.</font>";
	echo "<br><center>".$msg."</center>";
	
}


if($_GET['id'] || $_POST['id'])
{
		$id = ($_GET['id'])?$_GET['id']:$_POST['id'];
		$qry2 = "select ref_no,bahas_id,yb,tkh_dibahas from sesi_bahas_detail where bahas_id='$id' order by tkh_dibahas,yb ASC";
		$result2 = mysql_query($qry2) or die (mysql_error());
		if(mysql_num_rows($result2)>0)
		{
		?>
<br />
&nbsp;&nbsp;&nbsp;<INPUT type="button" value="TUTUP" onClick="window.close()" class="button"> 
		<form method="post" action="form_jawapan.php" enctype="multipart/form-data">
		<table width="120%" border="0">
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="100%">
	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="65%">
		<tr bgcolor="#ff66ff"><th>Bil</th><th>Tarikh</th><th>Ahli Yang Berhormat</th><?php echo ($sys_acl==1)?"<th>Hapus ?</th>":""?></tr>
	<?php	
			
		while($rows = mysql_fetch_array($result2)){
			$del = ($sys_acl==1)?"<td align=\"center\"><a href='' onClick=\"return deleteDoc('BahasDetails',".$rows['bahas_id'].")\"><img src=\"../images/del.gif\"></a></td>":"";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			?>			
			<tr bgcolor="<?php echo $rcolor ?>">
			<td align="center"><?php echo ($i+1) ?></td>
			<td align="center"><a href="form_jawapan.php?action=jawapan&id=<?php echo $id ?>&cid=<?php echo $rows['ref_no'] ?>"><?php echo DisplayDate($rows['tkh_dibahas']) ?></a></td><td><center><?php echo $rows['yb'] ?></center></td><?php echo $del ?></tr>
<?php
			$i++;
		}
		?></table></td>
  </tr>
</table>

		
		<?php
		if($_GET["cid"])
		{
			$cid=($_GET['cid'])?$_GET['cid']:$_POST['cid'];
		
			$qry3 = "select * from sesi_bahas_detail where bahas_id='$id' AND ref_no='$cid'";
			$result3 = mysql_query($qry3) or die (mysql_error());
				
				
			$qry = "SELECT bahas_agensi.agensi_id, jawapan, tambahan, keterangan_tambahan,agensi.nama 
			FROM bahas_agensi, agensi WHERE bahas_agensi.bahas_id='$cid' AND bahas_agensi.agensi_id=agensi.id";
			$result = mysql_query($qry,$conn) or die (mysql_error());

			$count = 0;
			while($row = mysql_fetch_array($result))
			{
				$count++;
				$div = "agensi".$count;
				$nama = $row['nama'];
				$tajuk = "Jawapan dari ".$nama;
				$jawapan = $row['jawapan'];
				$tambahan = $row['tambahan'];
				$tambahan = (!empty($row['tambahan']))?"<tr><td></td><td> $tambahan</td><td></td></tr>":"";
				
				?>
				
				<a href="" onClick="a_state=collapse(a_state,<?php echo $div ?>);return false;"><img id="img_collapse" name="img_collapse" src="../images/collapse.gif"/></a>
				
				
				<div id="<?php echo $div ?>" name="<?php echo $div ?>" class="box" style="padding:10px;width:100%">
				
				<table width="100%" border="0">
				 <tr>
   					 <td width="8%">&nbsp;</td>
 					 <td width="84%"><font class="agen"><strong><?php echo $tajuk ?></strong></font></td>
    				 <td width="8%">&nbsp;</td>
 				 </tr>
  				<tr>
				  	<td>&nbsp;</td>
    				<td><?php echo $jawapan  ?></td>
  					<td>&nbsp;</td>
 				 </tr>
  				<?php echo $tambahan  ?>
  				<?php echo $keterangan_tambahan  ?>
 				 <tr>
 				    <td>&nbsp;</td>
    				<td>&nbsp;</td>
   				    <td>&nbsp;</td>
 				 </tr>
				</table>
				</div>
				<hr class="line"/>
			<?php
			}	
			while($row3 = mysql_fetch_array($result3))
			{
			?>
			<br />
		
			<fieldset><legend><b><?php echo formatDate($row3['tkh_dibahas']) ?></b></legend>
			<div class="sub">
			<table width="92%" border="0">
	
			<tr><td>&nbsp;&nbsp;</td><td>
			<table border="0">
				 <tr>
	 				   <td width="203"></td>
	 				   <td width="15"></td>
 					   <td width="635"><a href="" onClick="window.open('frm_jwpnto_hek.php?cid=<?php echo $cid ?>')">[Lihat Jawapan Agensi]</a></td>
	 			 </tr>
	 			 <tr>
	 				   <td width="203"><?php echo $sesi_dewan=='2'?"Nama Y.B Senator":"Ahli Yang Berhormat" ?></td>
	 				   <td width="15">:</td>
 					   <td width="635"><?php echo $row3['yb'] ?></td>
	 			 </tr>
	  			  <tr>
	 				   <td>Perkara Yang Dibangkitkan	</td>
	 				   <td>:</td>
  					  <td width="635"><?php echo nl2br($row3['perkara']) ?></td>
		      </tr>
				  <tr>
 					   <td>Jawapan</td>
	 				   <td>:</td>
	  				  <td><textarea name="Korperat_Jawapan" rows="5" cols="45"><?php echo $row3['jawapan'] ?></textarea></td>
		      </tr>
				   <tr>
	 				   <td>Maklumat Tambahan</td>
	 				   <td>:</td>
	  				  <td><textarea name="Korperat_Tambahan" rows="5" cols="45"><?php echo $row3['maklumat_tambahan'] ?></textarea></td>
	 			   </tr>
  				  <tr>
		 				   <td>Lampiran	</td>
	 				   <td>:</td>
	  				  <td>
				
						<?php //display the attachments if any	
						$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id=0 AND bahas_id='$cid'";
						$res = mysql_query($qry,$conn);
						while($row3 = mysql_fetch_array($res)){
							$nama_fail = $row3['nama_fail'];
							$path = "../parlimen/lampiran/$nama_fail";
							echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";

						}
						?>		
					  <br /><br />
					  <input id="my_file_element" type="file" name="file_1" /></td>
		      </tr>
					<tr>
            			<td></td>
           			 <td width></td>
           			 <td><!-- This is where the output will appear -->
            			    <div id="files_list"></div>
             			   <script>
							<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
							var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 5 );
							<!-- Pass in the file element -->
							multi_selector.addElement( document.getElementById( 'my_file_element' ) );
							</script></td>
        			</tr>				   
				   	<tr><td colspan="2">&nbsp;
					
					</td>
					<td><br /><center>
					<input type="hidden" name="id" value="<?php echo $id ?>"/>	
					<input type="hidden" name="cid" value="<?php echo $cid ?>"/>	
					<input name="SimpanJawapanPP" type="submit" value="SIMPAN" class="button"/>
					</td>
					</tr>		   
			</table>  
			</td>
			</tr>
			</table>
			</div>
			</fieldset>

<?php 
			}//while
	}//if GET CID
	}//if qry2
 echo "</form>";	
}// if GET ID
?>








</body>
</html>
