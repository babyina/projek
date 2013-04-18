<?php	
session_start();
include("../js/FCKeditor/fckeditor.php");
?>

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
		//var a_state = 1;
		var image1 = new Image(); image1.src = "../images/expand.gif";
		var image2 = new Image(); image2.src = "../images/collapse.gif";
		
		function collapse(state,div,img){
			var obj = document.getElementById(div.name);								
			var image = document.getElementById(img.name);

			if(state==0){
				obj.style.display = 'none';							
				image.src = image1.src;
				return 1;
			}else{
				obj.style.display = '';
				image.src = image2.src;
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
	$tajuk_mt = addslashes($_POST['tajuk_mt']);
	$catatan = $korperat_catatan;
	$jawapan_id = "0";
	$bahas_id = $cid;
	include("lampiran_bahas.php");

	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "UPDATE sesi_bahas_detail SET jawapan='$korperat_jawapan', tajuk_mt='$tajuk_mt', maklumat_tambahan = '$korperat_tambahan' WHERE ref_no = '$cid' AND bahas_id='$id'";
	
	
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

		<form method="post" action="form_jawapan.php" enctype="multipart/form-data">
		<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="2"><br />
    <input name="button" type="button" class="button" onclick="window.close()" value="TUTUP" /><br /><br /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="6%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
    <td colspan="2">	
	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="93%">
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
		} ?>
	</table><br />	</td>
    <td width="8%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>  <td width="2%">&nbsp;</td>
    <td width="76%">
		<?php
		if($_GET["cid"])
		{
			$cid=($_GET['cid'])?$_GET['cid']:$_POST['cid'];
		
			$qry3 = "select * from sesi_bahas_detail where bahas_id='$id' AND ref_no='$cid'";
			$result3 = mysql_query($qry3) or die (mysql_error());
				
				
			$qry = "SELECT bahas_agensi.agensi_id, jawapan, tambahan, keterangan_tambahan,agensi.nama 
			FROM bahas_agensi, agensi WHERE bahas_agensi.bahas_id='$cid' AND bahas_agensi.agensi_id=agensi.id";
			$result = mysql_query($qry,$conn) or die (mysql_error());


				$div = "agensi".$count;
				$img_collapse = "img_collapse".$count;
				$state_per = "state".$count;
				?>
				<script language="javascript">
					var <?php echo $state_per ?> = 1;

				</script>
				<?php 


			$count = 0;
			while($row = mysql_fetch_array($result))
			{
				$count++;
				$div = "agensi".$count;
				$img_collapse = "img_collapse".$count;
				$state_per = "state".$count;
				$nama = $row['nama'];
				$tajuk = "Jawapan dari ".$nama;
				$jawapan_agensi = $row['jawapan']; 
				if(!empty($row['tambahan']))
					$jawapan_agensi .= "<br><br><br><b>Maklumat Tambahan</b></br><br>".$row['tambahan'];
				if(!empty($row['keterangan_tambahan']))
					$jawapan_agensi .= "<br><br><br><b>Keterangan Tambahan</b></br><br>".$row['keterangan_tambahan'];
				//$tambahan = (!empty($row['tambahan']))?"<tr><td width=\"18%\">Maklumat Tambahan</td><td width=\"1%\">&nbsp;</td><td><textarea name=\"\" cols=\"60\" rows=\"5\">$tambahan</textarea></td></tr>":"";
				?>
				<script language="javascript">
					var <?php echo $state_per ?> = 1;

				</script>
								
				&nbsp;&nbsp;<font class="fs"><strong><?php echo $tajuk ?></strong></font><a href="" onclick="<?php echo $state_per ?>=collapse(<?php echo $state_per ?>,<?php echo $div ?>,<?php echo $img_collapse ?>);return false;"><img id="<?php echo $img_collapse ?>" name="<?php echo $img_collapse ?>" src="../images/expand.gif" border="0"/></a><br />
				<div id="<?php echo $div ?>" name="<?php echo $div ?>" style="padding:10px;width:100%;display:none">
				<?php createRTF($sBasePath, $div, $jawapan_agensi);?>				
				</div>
				
	<?php
			}	 ?>	</td>
    <td width="8%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
	<?php 
		while($row3 = mysql_fetch_array($result3))
		{ ?>
			<br /><br /><br /><fieldset><legend><b><?php echo formatDate($row3['tkh_dibahas']) ?></b></legend>
			<div class="sub">
			<table width="92%" border="0">
	
			<tr><td>&nbsp;&nbsp;</td><td>
			<table border="0">
	 			 <tr>
	 			   <td>&nbsp;</td>
	 			   <td>&nbsp;</td>
	 			   <td>&nbsp;</td>
 			    </tr>
	 			 <tr>
	 				   <td width="184"><?php echo $sesi_dewan=='2'?"Nama Y.B Senator":"Ahli Yang Berhormat" ?></td>
	 				   <td width="14">:</td>
 					   <td width="506"><?php echo $row3['yb'] ?></td>
	 			 </tr>
	  			  <tr>
	  			    <td>&nbsp;</td>
	  			    <td>&nbsp;</td>
	  			    <td>&nbsp;</td>
  			    </tr>
	  			  <tr>
	 				   <td><strong>Perkara Yang Dibangkitkan	</strong></td>
	 				   <td>:</td>
  					  <td width="506">&nbsp;</td>
		      </tr>
				  <tr>
				    <td colspan="3">&nbsp;</td>
			    </tr>
				  <tr>
				    <td colspan="3"><?php createRTF($sBasePath, 'Perkara_berbangkit', $row3['perkara']);?></td>
			    </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			    </tr>
				  <tr>
 					   <td><strong>Jawapan</strong></td>
	 				   <td>:</td>
  				    <td>&nbsp;</td>
		      </tr>
				   <tr>
				     <td colspan="3">&nbsp;</td>
		        </tr>
				   <tr>
				     <td colspan="3"><?php createRTF($sBasePath, 'Korperat_Jawapan', $row3['jawapan']);?></td>
		        </tr>
				   <tr>
				     <td>&nbsp;</td>
				     <td>&nbsp;</td>
				     <td>&nbsp;</td>
		        </tr>
				   <tr>
	 				   <td><strong>Maklumat Tambahan</strong></td>
	 				   <td>:</td>
  				     <td>&nbsp;</td>
	 			   </tr>
  				   <tr>
  				     <td colspan="3">&nbsp;</td>
		        </tr>
  				   <tr>
  				     <td colspan="3"> <font color="#CC3333">
					 Untuk tujuan laporan.<br />
					   -  Bagi kemasukan pada ruang, isikan ruang Tajuk di bawah.<br />
				     -  Bagi lampiran, nama fail akan digunakan sebagai Tajuk.</font> </td>
		        </tr>
  				   <tr>
  				     <td colspan="3">&nbsp;</td>
		        </tr>
  				   <tr>
  				     <td colspan="3">Tajuk&nbsp;&nbsp;&nbsp;&nbsp;
  				       <input class="txt" name="tajuk_mt" type="text" size="110" value="<?php echo $row3['tajuk_mt'] ?>"/> </td>
		        </tr>
  				   <tr>
  				     <td colspan="3"><?php createRTF($sBasePath, 'Korperat_Tambahan', $row3['maklumat_tambahan']);?></td>
		        </tr>
			       <tr>
			         <td>&nbsp;</td>
			         <td>&nbsp;</td>
			         <td>&nbsp;</td>
	            </tr>
		          <tr>
		 				   <td>Lampiran	</td>
	 				   <td>:</td>
	  				  <td>
					  <input id="my_file_element" type="file" name="file_1" /><br />
					  <?php //display the attachments if any	
						$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id=0 AND bahas_id='$cid'";
						$res = mysql_query($qry,$conn);
						while($row3 = mysql_fetch_array($res)){
							$nama_fail = $row3['nama_fail'];
							$path = "../parlimen/lampiran/$nama_fail";
							echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";

						}
						?>						</td>
		      </tr>
					<tr>
            			<td></td>
           			 <td width></td>
           			 <td><!-- This is where the output will appear -->
            			    <div id="files_list"></div>
             			   <script>
							<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
							var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
							<!-- Pass in the file element -->
							multi_selector.addElement( document.getElementById( 'my_file_element' ) );
							</script></td>
        			</tr>				   
				   	<tr><td colspan="2">&nbsp;
					
					</td>
					<td><br /><center>
					<input type="hidden" name="id" value="<?php echo $id ?>"/>	
					<input type="hidden" name="cid" value="<?php echo $cid ?>"/>	
					<input name="SimpanJawapanPP" type="submit" value="SIMPAN" class="button"/>					</td>
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
?>	</td>
    <td>&nbsp;</td>
  </tr>
</table>
