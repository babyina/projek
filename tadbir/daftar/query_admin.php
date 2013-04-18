<?php
	$isAdmin = checkOfficer($_SESSION['userid'],1,$conn);
	$sys_acl = checkModul($conn,$db_voffice,"Modul5",$_SESSION['userid']);
	if($sys_acl>2){
		echo $acl_denied;
		echo "</tr></table>";
		include("../footer.php");
		exit(0);
	}
	
	if(!empty($app) && ($_GET['action']=="newdoc")){ 
		echo $acl_denied;
		echo "</tr></table>";
		include("../footer.php");
		exit(0);
	}
	
	$pgNum = 1;
	$pgRow = 20;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}
	$offset =($pgNum -1)*$pgRow;
	
	$change = 0;
	$pwdDisabled = "";
	$type = "";
	if($_GET['action'] != "newdoc"){
		$change = 1;
		$pwdDisabled = "disabled";
		$type = "edit";
	}
	
	//$user_type = "SELECT * FROM kod_sistem WHERE kategori='Jenis Pengguna' ORDER BY kod";	
	//$advance6 = array("Lihat Laporan","Lihat Agensi","Komen");
	
	function date_display($date){
		$dt = explode("-",$date);
		$date = implode("/",array($dt[2],$dt[1],$dt[0]));
		return $date;
	}
	
	function checkBox($name,$value,$label,$checked=""){
		return "<input type=\"radio\" name='$name' value='$value' class=\"noBorder\" $checked>$label";
	}
	
	function advanceBox($items,$name,$value_array){
		foreach($items as $node){
			$checked = in_array($node,$value_array)?"checked":"";
			echo "<input type=\"checkbox\" name=\"$name\" value=\"$node\" $checked>$node";
		}
	}
	
	function getKeyword($category,$default,$conn){
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['butiran'];
			$selected = ($item == $default)?"selected":"";
			echo "<option $selected>".$item."</option>";
		}
	}
	
	function getAgensi($def,$conn){		
		$qry = "SELECT agensi.id AS id, agensi.nama, agensi.nama AS nama FROM agensi ORDER BY nama_pendek";

		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama']."</option>";
		}				
	}
	
	function Validator($Katalaluan,$Katalaluan2){
		if (Katalaluan != Katalaluan2){
		//<script language="javascript">
		echo 'Katalaluan anda tidak sepadan. Sila masukkan semula Pengesahan Katalaluan.';
		}
	return true;
	}
	 
	function getKawasan($def,$conn){		
		$qry = "SELECT id,nama FROM kawasan ORDER BY nama";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama']."</option>";			
		}				
	}
		
	function getParti($def,$conn){
		$qry = "SELECT id,nama_pendek FROM parti ORDER BY nama_pendek";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['nama_pendek']."</option>";
		}
	}
	
	function getRoles($def,$conn){		
		$qry = "SELECT id, role FROM roles ORDER BY sort ";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$selected = ($id == $def)?"selected":"";
			echo "<option $selected value=\"$id\">".$row['role']."</option>";			
		}				
	}
	
	function print_red($text){
		print "<font color=\"red\"><strong>" . $text . "</strong></font>"; 
	}
	
	function phone_num($num, $i){
		$x = explode("-",$num);
		//echo $x[$i];
		return $x[$i];
	}
	
	function get_pre_num($num){		
	
	$pre = array("012","013","014","016","017","019");
	foreach($pre as $key){
		$selected = ($key == $num)?"selected":"";
		echo "<option $selected value=\"$key\">".$key."</option>";			
	}				
}
	
	function senaraiPengguna($conn,$db,$ldapServer,$ldapPort,$base,$def='',$pattern='A'){
		$qry = "SELECT id FROM pengguna";
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row= mysql_fetch_array($result)){
			$registered[$row['id']] = $row['id']; //echo $row['id'];
		}

		echo "$connect = ldap_connect($ldapServer, $ldapPort)";
		$userldap = "CN=Shahrudin bin Md Nor,OU=Bhg. SMaT,0=KWP";
		$pass = "dino5133";

		//echo "$bind = ldap_bind($connect,$userldap,$pass)";
		echo $connect = ldap_connect($ldapServer, $ldapPort);
		if($connect){
			echo "connected";
			$bind = ldap_bind($connect,$userldap,$pass);
			$search = ldap_search($connect,$base,"cn=$pattern*");
			$info = ldap_get_entries($connect,$search);
			for($i=0;$i<$info["count"];$i++){						
				$id = $info[$i]['uid'][0];
				$name[$id]= $info[$i]['cn'][0];
			}
		}else echo "connection failed";
		if($info["count"]>0){
			asort($name);
			$list = current($name);
			while($list <> null){
				if(key($name)<>$registered[key($name)]){
					if(key($name) <> $def)
						echo "<option value='".key($name)."'>".$list."</option>";
					else
						echo "<option value='".key($name)."' selected>".$list."</option>";
				}
				$list = next($name);
			}	
		}
	}		
	
	$userId = $_GET['id_tbl'];
	$qry = mysql_query("SELECT * FROM pengguna WHERE id_tbl = '$userId'");
	$row = mysql_fetch_array($qry);
	$sistem = $row['sistem'];
	
	$sql_role = mysql_query("select id, role from roles order by sort");
	$total_role = mysql_num_rows($sql_role);
	
	$font_color = $_GET['action'];
	if(strcmp($font_color,"newdoc") == 0){ $font_color = "red"; }

?>
<script language="javascript">
	function validForm(form){
		var msj = '';
		var error = 0; //success
		var nama = form.Nama2.value;
		var agensi = form.Agensi.selectedIndex;
		var jawatan = form.Jawatan.value;
		var telefon = form.Telefon.value;
		var handphone = form.Handphone.value;
		var emel = form.Emel.value;
		var emel2 = form.Emel_jab.value;
		//var idUser = form.IDnama.value;
		var nokp = form.kp1.value;
		//var pwd1 = form.Katalaluan.value;
		//var pwd2 = form.Katalaluan2.value; 
		var idagensi = form.check_idagensi.value; 
		
		//var box_chk = document.getElementById('changePwd');
		
		//if(box_chk.checked){
		//alert("telah dipilih")
		
		//}
       		//alert(nokp)
			if(nama.length < 1){
			msj = 'Sila masukkan nama pengguna';
			form.Nama2.focus();
			error = 1;
		}
    
		
		//alert(idagensi)
		if(emel.length < 1){
			msj = 'Sila masukkan group emel pengguna';
			form.Emel.focus();
			error = 1;
		}
		if(emel2.length < 1){
			msj = 'Sila masukkan emel jabatan pengguna';
			alert(msj)
			form.Emel_jab.focus();
			return false; 
		}
		
		//if(handphone.length < 1){
		//	msj = 'Sila masukkan no telefon bimbit pengguna';
		//	form.Handphone.focus();
		//	error = 1;
		//}
		
		if(telefon.length < 1){
			msj = 'Sila masukkan no telefon pengguna';
			form.Telefon.focus();
			error = 1;
		}
		
		if(jawatan.length < 1){
			msj = 'Sila masukkan jawatan pengguna';
			form.Jawatan.focus();
			error = 1;
		}
		
		if(agensi < 1){
			msj = 'Sila pilih bahagian/agensi Kementerian Kesihatan';
			form.Agensi.focus();
			error = 1;
		}


		
		
		if(nokp.length < 1){
			msj = 'Sila masukkan No Kp 12 pengguna';
			form.kp1.focus();
			error = 1;
		} else {
			if(nokp.length != 12){
				msj = 'Sila pastikan NOKP 12 dimasukkan';
				form.kp1.focus();
				error = 1;
			}
		}
		
		if(idagensi == 50 || idagensi == 53 || idagensi == 54) 
		{
		var in_out=document.getElementById("in_out").value;
		//alert("agensi"+in_out)
		
		if(in_out==1)
		{
		   var pwd1 = form.Katalaluan.value;
		var pwd2 = form.Katalaluan2.value; 
		  // alert(pwd1)
		if(pwd1 != pwd2){
			msj = 'Katalaluan pengguna tidak sama.\n\nMasukkan semula';
			form.Katalaluan.focus();
			error = 1;
		}
		
		if(pwd1.length < 1 || pwd2.length < 1){
			msj = 'Masukkan katalaluan dan pengesahan katalaluan';
			form.Katalaluan.focus();
			error = 1;
		}
		
		if(pwd1.length < 4 || pwd2.length < 4){
			msj = 'Katalaluan terlalu pendek.\n\nSila masukkan semula';
			form.Katalaluan.focus();
			error = 1;
		}
		
		//alert("pilih 2")
		}
		
		
		}
				
		if(idagensi == 50 || idagensi == 53 || idagensi == 54)
		{
	    var box_chk = document.getElementById('changePwd');
		var in_out=document.getElementById("in_out").value;
		if(box_chk.checked){
		//alert("telah pilih")
	    var pwd1 = form.Katalaluan.value;
		var pwd2 = form.Katalaluan2.value; 
		  // alert(pwd1)
		if(pwd1 != pwd2){
			msj = 'Katalaluan pengguna tidak sama.\n\nMasukkan semula';
			form.Katalaluan.focus();
			error = 1;
		}
		
		if(pwd1.length < 1 || pwd2.length < 1){
			msj = 'Masukkan katalaluan dan pengesahan katalaluan';
			form.Katalaluan.focus();
			error = 1;
		}
		
		if(pwd1.length < 4 || pwd2.length < 4){
			msj = 'Katalaluan terlalu pendek.\n\nSila masukkan semula';
			form.Katalaluan.focus();
			error = 1;
		}
		
      }

		
		}
		
		
		if(error > 0){
			alert(msj);
			return false;
		} //else
			//return true;
			
		var valid, el, els = document.getElementsByName("cb[]"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Kategori Pengguna");
			return(false);
		}
		

		var valid, el, els = document.getElementsByName("mod1"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Parlimen");
			return(false);
		}
		
		/*var valid, el, els = document.getElementsByName("mod2"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Kalendar");
			return(false);
		}*/

		var valid, el, els = document.getElementsByName("mod3"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Profil");
			return(false);
		}

		/*var valid, el, els = document.getElementsByName("mod4"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Jemaah Menteri");
			return(false);
		}
       */
		var valid, el, els = document.getElementsByName("mod5"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Pendaftaran");
			return(false);
		}
	
		var valid, el, els = document.getElementsByName("mod6"); 
		valid = false;
		for(var n=0, len=els.length; n<len; n++){
	    	el = els[n];
			if(el.checked == 1){
				valid = true;
			}
		} 
	
		if(valid==false)
		{
			alert("Sila pilih Tahap Capaian bagi modul Katakunci");
			return(false);
		}
		
	}
	
	function copyNama(){
		var nama = document.getElementById('Nama2');
		var Id = document.getElementById('IDnama');
		nama = nama.value;
		nama_s = nama.split(' ');
		check_nama = nama_s[0];
		if(check_nama.length <0){
			Id.value = '';
		}
		else{
			//n = substr(check_nama,0,7);
			Id.value = check_nama.substr(0,8);
		}
	}
	
		function copyNamaOri(){
		var nama = document.getElementById('Nama2'); 
		var Id = document.getElementById('IDnama');
		nama = nama.value;
		nama_s = nama.split(' ');
		check_nama = nama_s[0];
		if(check_nama.length <0){
			Id.value = '';
		}
		else{
			//n = substr(check_nama,0,7);
			Id.value = check_nama.substr(0,8);
		}
	}
	
	function enablePassword(){
	
	   var klaluan_ = document.getElementById("klaluan");
	   var sahKlaluan = document.getElementById("sah_klaluan");
		
		var box = document.getElementById('changePwd');
		var pwd1 = document.getElementById('Katalaluan');
		var pwd2 = document.getElementById('Katalaluan2');
		if(box.checked){
		   klaluan_.style.display = '';
		   sahKlaluan .style.display = '';
		 
			//alert('test');
			//pwd1.disabled = false;
			//pwd2.disabled = false;
		} else {
		    klaluan_.style.display = 'none';
		   sahKlaluan .style.display = 'none';
			//pwd1.disabled = true;
			//pwd2.disabled = true;
		}
	}
	
	//rizal
	function showTR(id){
		alert(id);
		if (document.getElementById && document.createTextNode){
			var tr=document.getElementById(id);
			alert(zz);
			if(tr.style.display=='' || tr.style.display=='none'){
				tr.style.display='inline'; 
			}else {
				tr.style.display='none'; 
			}       
		}
	}
	
	function number_only(me,evt)
{ 


	var key = window.event ? evt.keyCode : evt.which;
	//alert(key);
	if(isNaN(me.value+String.fromCharCode(key)) || String.fromCharCode(key)==" ") 
	{
		blok_nilai(evt,key);
	} 
	// titik perpuluhan 
	theval=me.value+String.fromCharCode(key);
	decimal = theval.indexOf(".");
	if(decimal>=1)
	{
		if(decimal+4<theval.length)
			{
				blok_nilai(evt,key);
			}
	}
	

}
function blok_nilai(evt,key)
{
	if(window.event)
			{ 
				event.returnValue = false;
			}else
			{
				if(key==8||key==0) //if delete  atau backspace pressed..
				{
					
				}
				else
				{
					evt.preventDefault();
				}
			}
}
	
function checkemel(form,idemail)
{
var validRegExp;
var idemail=idemail;
    //validRegExp =/^[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]/;
	//validRegExp =/@[a-zA-Z]+\.[a-zA-Z]/;
	validRegExp =/^[A-Za-z0-9\_-]+.[A-Za-z0-9\_-]+@[A-Za-z0-9\_-]+\.[a-zA-Z]/;
  var strEmail =document.getElementById(idemail).value

    if (strEmail.search(validRegExp) == -1) 
   {
      alert('alamat e-mail tidak sah.\n Sila masukkan semula');  
	  //setTimeout((document.getElementById('emel_kelab').focus()),5)
	  setTimeout("document.getElementById('"+idemail+"').focus();",0);

      return false;
    } 
    return true; 
}

</script>
