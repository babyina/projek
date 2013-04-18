<?php

session_start();
include("../js/FCKeditor/fckeditor.php");
require("query_soalan.php");
$current_time = date("d-m-Y G:i:s");
if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	
	$qry = "SELECT status,korperat_jawapan,korperat_tambahan,korperat_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	?>
	<br />
	
	
<script language="javascript">

	var state_jaw = 1;
	var state_tamb = 1;
	
</script>
 
	<form name="edit_jawapann" enctype="multipart/form-data" method="post" onSubmit="if(toValidate) return validateFormKorperat(this)">
	<fieldset><legend><b>Edit Jawapan Hal Ehwal Korperat</b></legend>
	<div class="sub">
	
		<?php
		$view = "false";
	
#--------------------------------------------------------- status = 3,21,22,10  -----------------------------------------------------------		
		if($status == 3||$status == 10||$status == 21||$status == 22) //utk view portion agensi
		{ 
		
		//if($status==3){
		?>
		<br />
		<?php } 
		
		 ?>
<table border=0 width="100%">
		<tr>
			<td width=219>Jawapan</td>
			<td width=3>:</td>
			<td width="749"><a href="" onclick="state_jaw=collapse(state_jaw,div_jaw,img_collapse);return false;"><img id="img_collapse" name="img_collapse" src="../images/expand.gif" border="0"/></a>			</td>
		</tr>
		<tr>
			<td width=219></td>
			<td width=3></td>
			<td>
				<div id="div_jaw" name="div_jaw" style="padding:5px;width:100%;display:none">
				<?php createRTF($sBasePath, 'Korperat_Jawapan', $row['korperat_jawapan']);?>
				</div>
			</td>
		</tr>
		<tr>
			<td width=219>Maklumat Tambahan</td>
			<td width=3>:</td>
			<td><a href="" onclick="state_tamb=collapse(state_tamb,div_tamb,img_collapse_t);return false;"><img id="img_collapse_t" name="img_collapse_t" src="../images/expand.gif" border="0"/></a>			</td>
		</tr>
		<tr>
			<td width=219></td>
			<td width=3></td>
			<td>
				<div id="div_tamb" name="div_tamb" style="padding:5px;width:100%;display:none">
				 <?php createRTF($sBasePath, 'Korperat_Tambahan', $row['korperat_tambahan']);?>
				</div>
			</td>
	  </tr>
		<?php if($status == 3) { ?>		  
			<tr>
			  <td width=219>Catatan Sekira Ada Pindaan</td>
			  <td width=3>:</td>
			<td><textarea name="Korperat_Catatan" rows=5 cols=45><?php echo $row['korperat_catatan'] ?></textarea></td></tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		  <?php } ?>	
			<tr><td width=219>Lampiran</td><td width=3>:</td>
			<td><input id="my_file_element" type="file" name="file_1" /></td>
			</tr>
          <tr>
            <td width=219></td>
            <td width=3></td>
            <td><!-- This is where the output will appear -->
                <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td>
          </tr>
		    <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
              <?php //display the attachments if any	
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a><br>";
			}
			?></td>
          </tr>		  
		  <tr>
		    <br>
		    <td colspan="3"><br>
	         <? // <font class="current_user">Nama Pegawai Bertugas : <?php echo  $_SESSION['nama']."  ".$current_time ?></font></td>
		  </tr>
      </table>
		<br><br>
	</div>
	</fieldset>
	
	&nbsp;
	
	
    </form>
	<?php }
	
	 ?>
  