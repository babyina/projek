<script language="javascript">
function edit_soalan_kembali(){
//alert("test");
	document.edit_hantar_semula_form.EditSoalan.click();
}
function agensi(){
//alert("test");
	var td_pilih_kementerian = document.getElementById("pilih_kementerian"); 
	var td_pilih_kementerian2 = document.getElementById("pilih_kementerian2"); 
	var td_hantar= document.getElementById("hantar"); 
	
	td_pilih_kementerian.style.display='';
	td_pilih_kementerian2.style.display='';
	td_hantar.style.display='';
	
}
function tukar_kementerian(val)
{
//alert(val);
var kodKem = document.getElementById("kodKem"); 
kodKem.value=val;
}

function verify() {

	
var EditorInstance = FCKeditorAPI.GetInstance('catatan_kementerian');    //location_info is name of text area.
var catatan_kementerian = EditorInstance.GetXHTML(true);
	
	
	 if(document.getElementById("kodKem").value=='')
	{
	alert("Sila Pilih Kementerian");
	document.getElementById("kementerian").focus();
	return false;
	} 
	else if (catatan_kementerian=="") {
	alert("Sila Masukkan Catatan");
	EditorInstance.Focus();
	return false;
	}	
	else {
//alert(document.getElementById("kodKem").value);
	edit_hantar_semula_form.submit();
  	   }
}

</script>
<?php 
include("../js/FCKeditor/fckeditor.php");
$parlimen_id = $_POST['parlimen_id'];

$qry = "SELECT * FROM kementerian";
//echo $qry;
$result = mysql_query($qry,$conn) or die(mysql_error());
					
	


?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<br />
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
<form id="edit_hantar_semula_form" name="edit_hantar_semula_form"   enctype="multipart/form-data" method="post" onsubmit="if(toValidate) return verify();">
<fieldset><legend><b>Maklumat Soalan</b></legend>
<div class="sub">
	<table border="0" width="100%">
		<tr>
		  <td width="30%">&nbsp;</td>
		  <td width="1%">&nbsp;</td>
		  <td><div style="visibility:hidden">
          <input type="text" name="parlimen_id" value="<?php echo $parlimen_id; ?>"/>
         
           <input type="submit" value="Edit Soalanl" name="EditSoalan"/>
           </div></td>
	  </tr>
		
		<tr>
		  <td> Bahagian / Agensi di bawah kementerian Kesihatan</td>
		  <td> :</td>
		  <td>
                    <input type="radio" name="agensi1" value="1" onClick="edit_soalan_kembali();return(false)">
		      Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input type="radio" name="agensi2" value="2" onClick="agensi()">
			    Tidak<br/>
          </td>
	  </tr>
      <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
      <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
     
      <tr id="pilih_kementerian" style="display:none;">
		  <td>Pilih Kementerian</td>
		  <td> :</td>
		  <td>
           <input type="hidden" name="kodKem" id="kodKem"/>
          <select name="kementerian" id="kementerian" onChange="tukar_kementerian(this.value);">
          <option value=''>Sila Pilih Kementerian</option>
          <?php 
	         while($row = mysql_fetch_array($result)){
			?>
			<option value="<?php echo $row['kodKem'];?>"><?php echo $row['kementerian'];?></option>";			
		<?php }	
		?>
        </select>
          </td>
	  </tr>
      <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
       <tr  id="pilih_kementerian2" style="display:none;">
		  <td>Catatan</td>
		  <td>:</td>
		  <td><?php createRTF($sBasePath, 'catatan_kementerian','');?></td>
	  </tr>
      <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
      <tr id="hantar" style="display:none">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><input  class="button" type="submit" name="SimpanSoalan" value="SIMPAN" onclick="toValidate=true;simpan=false"/> </td>
	  </tr>
</table>		
</form>

<?php ?>
<!-- jamlee edited -->
