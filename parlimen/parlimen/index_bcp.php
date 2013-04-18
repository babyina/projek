<script language="javascript">
	var state_jaw = 1;
	var state_tamb = 1;
	function penerangan(val)
{

var td_bentuk_soalan= document.getElementById("jns_soalan");
	if(val=='s1')
	{
	
	td_bentuk_soalan.value = 's1';
	}
	if(val=='s2')
	{
	
	td_bentuk_soalan.value = 's2';
	}
}


</script>
<?php
session_start();
include("../js/FCKeditor/fckeditor.php");
$current_time = date("d-m-Y G:i:s");
//if(checkACL($_SESSION['userid'],3,null,$conn) == false){ asal 23 jan 2009


	$parlimen_id = $_POST['parlimen_id'];
	//$agensix = $_POST['agensik']; 
			
	$qry = "SELECT korperat_jawapan,korperat_tambahan,catatan_final,agensi,no_soalan,jns_soalan,created_by FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row21 = mysql_fetch_array($result);
	//$agensix = $_POST['agensik']; 
	?><br />
	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
	<?php include("inc_butirSoalan.php");
	include("jawapan_agensi.php");  ?>
 <?php $qry_pppb2 = "SELECT nama,jawatan,bhg,catatan,tarikh,status,Length(catatan) AS length_catatan FROM semakan
			WHERE parlimen_id ='$parlimen_id' AND status!='25' ORDER BY tarikh" ;
			$result_pppb2 = mysql_query($qry_pppb2,$conn) or die(mysql_error());
	//echo $qry_pppb2 ;
$bil=0;
$totalRows = mysql_num_rows($result_pppb2);
					

if($totalRows >0)
{
?>

<fieldset class="highlight" style="width:auto ">
<legend width="326px">Semakan</legend>

<table width="100%" border="1" class="style4">
  <tr class="semakan">
    <td width="51" align="center" >Bil</td>
    <td width="186" align="center">Oleh</td>
     <td width="186" align="center">Jawatan</td>
    <td width="194" align="center">Tarikh</td>
    
    <td align="center" width="326">Catatan</td>
  </tr>
 <?php 
 while($row_pppb2 = mysql_fetch_array($result_pppb2))
 {
 $bil++;
 ?>
 <tr bgcolor="#FF99CC">
 <td align="center"><?php echo  $bil ?>  </td>
 <td style="text-transform:uppercase;"><?php echo $row_pppb2 ['nama'];?> </td>
 <td><?php echo $row_pppb2['jawatan']; ?></td>
 <td><?php echo date('j-n-Y-g:i:s A', strtotime($row_pppb2['tarikh'])); ?></td>
  <td><?php 
  
  $text1=strip_tags($row_pppb2['catatan']);

  echo substr($text1,0,40)."&nbsp;";?><img src="images/plusIcon.jpg" border="0"  onclick="return toggleMe('para<?php echo $bil?>')"/><br/>&nbsp;
  
 <div id="para<?php echo $bil?>" style="background-color:#FFFFCC;display:none;">
 <?php if($row_pppb2 ['catatan']!=NULL)
{echo $row_pppb2 ['catatan']."<p>&nbsp;</p>";}
else{
echo "Tiada catatan dimasukkan";} ?>
</div></td>
 </tr>
 
<?php
	}	
 ?>
</table>
  </fieldset> 
  <?php } ?>  
	<form name="edit_jawapan3" method="post" onSubmit="if(toValidate) return validateFormFinalBcp(this)">
	<br />
	<fieldset>
	<!--<legend><b>Jawapan Akhir Hal Ehwal Korperat</b></legend>-->
	<legend><b>Jawapan Akhir Diluluskan</b></legend> 
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			<td width=196>Jawapan</td>
			<td width=3>:</td>
			<td width="772">
				<?php createRTF($sBasePath, 'Jawapan_Final', $row21['korperat_jawapan']);?>
			</td>
			</tr>
			
			<tr>
				<td width=196>Maklumat Tambahan</td><td width=3>:</td>
				<td>
				<?php createRTF($sBasePath, 'Korperat_Tambahan', $row21['korperat_tambahan']);?>
				</td>
			</tr>
			
			<!--<tr valign="top"><td width=196>Catatan4</td><td width=3>:</td><td><textarea name="Catatan_Final" rows=5 cols=55><?php echo $row21['catatan_final'] ?></textarea></td></tr>-->
			<!--<tr><td width=196>Lampiran4</td><td width=3>:</td><td>
			<?php //display the attachments if any
			//$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$parlimen_id'";
			//$res = mysql_query($qry,$conn);
			//while($row3 = mysql_fetch_array($res)){
				//$nama_fail = $row3['nama_fail'];
				////echo $parlimen_id;
				//echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			//}
			?>
			</td></tr>-->
		  <tr>
		    <br>
		    <td>Bentuk Soalan:</td>
            <td colspan="2">
            <?php 
          $cat = "Kategori Soalan";
		get_bentukSoalan($conn,$cat,$parlimen_id);
				
			?> 
            
	          <!--font class="current_user">Nama Pegawai Bertugas : <!--?php echo  $_SESSION['nama']."  ".$current_time ?></font><br /><br />
			<!--jamlee edited-->
<!--jamlee edited-->			</td>
		  </tr>
			
		</table>
	</div>
	</fieldset>	<br /><br />
	<table width="200" border="0">
      <tr>
        <td>
        <input type="hidden" name="jns_soalan" id="jns_soalan" value="<?php echo $row21['jns_soalan'];?>"/>
		<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
		<input type="hidden" name="agensi" value="<?php echo $row21['agensi']; ?>"/>
		<input type="hidden" name="no_soalan" value="<?php echo $row21['no_soalan']; ?>"/>
      
		<input class="button" name="SimpanJawapanAkhirBcp" type="submit" value="SIMPAN" onClick="toValidate=true"/>
		</td>
      <td>
		<!--<td><input class="button" name="SimpanHantarJawapanAkhir" type="button" value="TEKS AKHIR" onclick="validateFormFinal(this)"/>-->
      </table>
</form>
		</td>

      </tr>
    </table>
		


