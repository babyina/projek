<?php
		
		function getTKSP($def,$conn,$kategori,$tksp){ //checkbox

	   $qry = "SELECT * FROM pengguna WHERE jawatan LIKE '%TKSP%' and jawatan not LIKE 'pa%'";
	
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$pangkat=array();
		while($row = mysql_fetch_array($result)){
			$id = $row['jawatan'];
		
			$checked = "";
			if(is_array($tksp)){
				foreach($tksp as $key){
				 
					if($key == $id){
					 $checked = "checked";
					
					}
				}
			}
			
			if($id=="TKSP (S&K)")
			{
			$pangkat[1]=$id;
			}
			if($id=="TKSP (D)")
			{
			$pangkat[2]=$id;
			}
			if($id=="TKSP (P)")
			{
			$pangkat[3]=$id;
			}
			
			
			
			
		}
		$start=1;
		$time=3;
		for($start;$start<=$time;$start++)
		{
			if($pangkat[$start]==$tksp)
			{
			$td = "<input checked=\"yes\" type=\"radio\" name=\"tksp\" value=\"$pangkat[$start]\">".$pangkat[$start]."<br>";
			 }
			else
			$td = "<input  type=\"radio\" name=\"tksp\" value=\"$pangkat[$start]\">".$pangkat[$start]."<br>";
			echo $td;
		}
		
	}
	
	
		
		
	function ListKategori($keyword,$def=""){
		foreach($keyword as $kategori){
			echo ($def<>$kategori)?"<option>$kategori</option>":"<option selected>$kategori</option>";
		}
	}
	
	$kategori = ($_POST['kategori'])?$_POST['kategori']:$row['kategori'];

	
	if($_GET['action']!='newdoc'){
		$id = $_GET['id'];	
		
		$qry = "SELECT id, nama, nama_pendek, kategori,tksp
						FROM 
							agensi WHERE id='$id'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
					
	$kategori = $row['kategori'];
	//$katakunci = ($_POST['kategori'])?$_POST['kategori']:$row['kategori'];
	
	}
	
?>

<!--<script language="javascript">alert (entry_form.kategori.value);</script>-->

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>BAHAGIAN  /AGENSI MOH <img src="../images/dot.gif"/></div>
<form id="entry_form2" name="entry_form2" method="post" onSubmit="return validateForm(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<fieldset><legend>Butiran Agensi/ Bahagian Kementerian Kesihatan</legend>
<div class="sub"> 
<br/>
<table width=100%>
		<tr><td width=194>Kategori</td>
		<td width=10>:</td>
		<td width="1009"><!--select name="kategori" onChange="">
	      <option></option><?php echo ListKategori($keyword,$row['kategori']) ?></select-->
		  
		  <select name="kategori">
		  <option value="Agensi" <?php if($kategori=="Agensi"){ echo "selected";} ?>>Agensi</option>
          <option value="Bahagian Kementerian Kesihatan" <?php if($kategori=="Bahagian Kementerian Kesihatan"){ echo "selected";} ?>>Bahagian Kementerian Kesihatan</option>
		  </select></td></tr>
		<tr><td width=194>Nama Bahagian/Agensi Kementerian Kesihatan</td>
		<td width=10>:</td>
		<td><p><input name="nama" value="<?php echo $row['nama'] ?>" size=50 class="txt"/> 
		
		</p>
		</tr>
		<tr><td width=194>Nama Singkatan</td>
		<td width=10>:</td>
		<td><input name="nama_pendek" value="<?php echo $row['nama_pendek'] ?>" size=50 class="txt"/></td></tr>
       <tr>
	   <tr><td width=194>Peringkat TKSUP/KPK</td>
		<td width=10>:</td>
		<td> <?php   getTKSP($penyemaktksp,$conn,$sub_jawatan,$row['tksp']);?>
       </td>
	   </tr>
</table>
 </div>
</fieldset>
<br/><br/>
<input type="submit" name="Simpan" value="SIMPAN" class="button"/>



</form>


