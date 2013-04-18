<script>
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
</script>
<?php
require('config.php');
require('phpmailer/class.phpmailer.php');

$show_form = true;
$error_msg = array();

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

if(isset($_POST['daftar'])){
	$nama = $_POST['Nama2'];
	$agensi = explode(",",$_POST['agensi_id']);
	$agensi_id = $agensi[0];
	$agensi_nama = (empty($agensi[1]))?"":" dari agensi ".$agensi[1];
	$jawatan = $_POST['jawatan'];
	$telefon = $_POST['Code']."-".$_POST['Telefon'];
	$handphone = $_POST['Pre_num']."-".$_POST['Handphone'];
	$emel = $_POST['emel'];
	$idUser = $_POST['IDnama'];
	$pwdUser1 = $_POST['pwdUser1'];
	$pwdUser2 = $_POST['pwdUser2'];
	$sistem = $_POST['sistem'];
	$statusMohon = "PERMOHONAN BARU";
	$sql = "";
	//echo $idUser;
	
	//CHECK REDUNDANCY 
	if(!empty($idUser)){
	$qry = "SELECT * From pengguna where id = '$idUser'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	
	if(mysql_num_rows($result)>0)
	{
		$error_msg[] = "ID telah wujud. Sila masukkan ID yang baru<br>";
	}
	}
	if(empty($nama))
		$error_msg[] = "Sila masukkan Nama anda";
	if(empty($jawatan))
		$error_msg[] = "Sila masukkan Jawatan anda";
	if(empty($telefon))
		$error_msg[] = "Sila masukkan Nombor Telefon anda";			
	if(empty($handphone))
		$error_msg[] = "Sila masukkan Nombor Telefon Bimbit anda";	
	if(empty($emel)){
		$error_msg[] = "Sila masukkan alamat Emel anda";
	}elseif(!empty($emel)){
		#email validation
		if(!eregi("^[A-Za-z0-9\_-]+.[A-Za-z0-9\_-]+@[A-Za-z0-9\_-]+[A-Za-z0-9\_-]*", $emel))
			$error_msg[] = "Alamat emel ($emel) tidak sah, sila masukkan semula";
	}
	if(empty($idUser))
		$error_msg[] = "Sila masukkan ID Pengguna";
	if(empty($pwdUser1))
		$error_msg[] = "Sila masukkan Katalaluan";				
	if(empty($pwdUser2))
		$error_msg[] = "Sila masukkan Pengesahan Katalaluan";	
	if(!empty($pwdUser1) && !empty($pwdUser2))
	{
		if($pwdUser1<>$pwdUser2)
			$error_msg[] = "Katalaluan pengguna tidak sama. Masukkan semula";		
	}
	if(empty($error_msg))
	{	
		$sql = 	"INSERT INTO pengguna (id,sistem,nama,agensi_id,jawatan,telefon,handphone,emel,password,user,date,statusMohon,temp) " .
			"VALUES " .
			"('$idUser','$sistem','$nama','$agensi_id','$jawatan','$telefon','$handphone','$emel',MD5('$pwdUser2'),'',now(),'$statusMohon','$pwdUser2')";
	}
	else{
		echo "<br>";
		foreach($error_msg AS $err){
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<font class=\"fs\">* $err</font><br>";
		}	
		echo "<br>";
		//include("form_daftar.php");	
	}


	if(!empty($sql)){
	if(mysql_query($sql)){
		$process_mail = false;
		include("bar.php");
		//$show_form = false;
		//$err_msg = "Tahniah. Pendaftaran berjaya .<a href=\"javascript:window.close()\">Kembali..</a>";
		$url = ."http://".$_SERVER['HTTP_HOST']."/ssjp/"."tadbir/login.php?action=details&id=" . $idUser;

		$subject = "Pendaftaran Pengguna ".$sistem;
		$message .= "Tuan/Puan,\n\n";
		$message .= "Saya " . $nama . " (" . $jawatan . ") " . $agensi_nama . " ingin memohon untuk mendaftar ";
		$message .= "sebagai pengguna ". $sistem ."\n\n";
		$message .= "Mohon perhatian dan pertimbangan Tuan. \n\n";
		$message .= "Sekian, terima kasih.\n\n";
		$message .= "Sila klik url bawah untuk keterangan lanjut. \n\n" . $url;
		$header = "From: " . $nama . "<" . $emel . ">";
		//$header = "From: jamlee.yanggitom@treasury.gov.my";
		//$sendTo = "jamlee.yanggitom@treasury.gov.my";
		// email HEK
		$roles_array = array();
		$query = mysql_query("SELECT roles, emel FROM pengguna");
		while($rows = mysql_fetch_array($query)){
			$roles_array[$rows[0]] = $rows[1];
		}
		$emailHek = "";
		$error = 0;
		if($process_mail){
		foreach($roles_array as $role => $email){
			$roles = explode("+",$role);
			foreach($roles as $r){
				if($r == 3){
				//echo $email;
					//$emailHek = $email;
					if(mail($email,$subject,$message,$header)){
						$error = 1;
					}
				}
			}
		}
		}
		//$sendTo = $emailHek;
		//$sendTo = "jamlee.yanggitom@treasury.gov.my"; //email penerima - hek
		//$header = "From: " . $nama . "<" . $emel . ">"; // email sender - user
		if($error > 0){
			$err_msg = 	"Terima Kasih. Permohonan anda akan dihantar kepada Hal Ehwal Korperat." .
						"<br/>" .
						"<a href=\"javascript:window.close()\">Tutup..</a>";
			$show_form = false;
		}else{
			$err_msg = "Maaf. Emel permohonan anda gagal dihantar";
			$show_form = false;
		}
		/*
		if(mail($sendTo,$subject,$message,$header)){
			$err_msg = 	"Tahniah. Permohonan anda akan dihantar kepada " .
						$sendTo . "<br/>" .
						"<a href=\"javascript:window.close()\">Keluar..</a>";
		}else{
			$err_msg = "Maaf. Emel permohonan anda gagal dihantar";
		}
		*/
	}
	}
}

include("form_daftar.php");
?>
