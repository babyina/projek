<?php
include("../config.php");
include("include/func.php");
$id = $_GET['id'];
$getIdAhliParlimen = $_GET['idAhliParlimen'];
$getIdKawasan = $_GET['idKawasan'];
//print $getIdAhliParlimen;

if($_POST['simpan']){
	$namaYB = $getIdAhliParlimen;
	$idKawasan= $getIdKawasan;
	$soalan	= $_POST['soalan'];
	echo $namaYB .'>'.$idKawasan.'>'.$soalan;
	$sql= "INSERT kal_lapdwn_sb SET 
					Kal_lapdwn_id='".$id."',
					NamaYB='".$namaYB."',
					Kawasan='".$idKawasan."',
					Soalan='".$soalan."'";
	mysql_query($sql)or die(mysql_error()); 
	
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
	echo "	window.opener.location.reload();";
	//echo "	window.close();";
	echo "</script>";
	exit();	
}
?>
<script language="javascript">
	function redirect(){
		var id = document.getElementById('idAhliParlimen');
		var s = id.value.split(',');
		var url = 'KalSub_sb.php';
		if (id.length > 0){
			window.location = url + '?idAhliParlimen=' + s[0] + '&idKawasan=' + s[1];
			return true;
		}
	}
</script>
<title>Soalan Tambahan</title>
<link rel="stylesheet" href="../style.css" title="general" type="text/css"
<link href="..js/FCKeditor/_samples/sample.css" rel="stylesheet" type="text/css" />
<form method="post">
	<fieldset>
	<legend>Soalan Berkaitan</legend>
	<table>
		<tr>
			<td>Nama Ahli Parlimen</td>
			<td>:</td>
		  <td><select name="idAhliParlimen"  id="idAhliParlimen" onChange="redirect()">
			<?php
				$sql = mysql_query("select id, nama, kawasan_id from ahli_parlimen");
				while($row = mysql_fetch_array($sql)){
					$idAhliParlimen = $row[0];
					$namaAhliParlimen = $row[1];
					$idKawasan = $row[2];
					$is_selected = ($getIdAhliParlimen == $idAhliParlimen)? "selected":"";
					print "<option value=\"" . $idAhliParlimen .",". $idKawasan . "\" " . $is_selected . ">" . $namaAhliParlimen . "</option>";
				}
			?>
			</select> <input type="hidden" name="id" value="<?php echo $id;?>"></td>
		</tr>
		<?php
			$sql = mysql_query("select nama from kawasan where id = '$getIdKawasan'");
			$row = mysql_fetch_array($sql);
			$kawasan = $row[0];
		?>
		<tr>
			<td>Kawasan</td>
			<td>:</td>
			<td><?php echo $kawasan; ?></td>
		</tr>
		<tr>
			<td>Soalan Tambahan</td>
			<td>:</td>
			<td>
			<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
$sBasePath = '/kwp/parlimen/js/FCKeditor/' ;

$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Value		= 'This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.' ;
$oFCKeditor->Create() ;			

			?>
			&nbsp;</td>
		</tr>
	</table>
	<center><input type="submit" value="Simpan" name="simpan" class="button"></center>
</fieldset>
</form>