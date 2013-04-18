<?php 
if (!isset($_SESSION)) {  session_start();}
	//$password=mysql_escape_string($_POST['password']);	for sql injection
    //$userid = mysql_escape_string($_POST['userid']);
$modul_id=2;
$Login = mysql_escape_string(trim($_POST['userid']));
$Pswd =  mysql_escape_string($_POST['password']);
$idpwd = mysql_escape_string(trim($_POST['password']));
$Pswd2 = md5($Pswd);
$encrypted_mypassword = md5($Pswd);
/*$kodkategori = $_POST['kodkategori'];*/

$kodkategori = 3;
//ditambah coding satuid pada 12/11/2010
/*include_once('satuid/satuid_caslibrary.php'); 
$Login =phpCAS::getUser();
$_SESSION['ssologin']=1;*/
$_SESSION['kodkategori'] = $kodkategori;

						require("config.php");
						$sql = "SELECT * FROM kategori WHERE kodkategori='$kodkategori'";
						$result = mysql_query($sql,$conn);
						$rows = mysql_num_rows($result);
						while ($row=mysql_fetch_array($result))
							{								
								$kodkategori=$row['kodkategori'];
								//echo $kodkategori;
							}
						if($rows>=1) 
							{
							//echo $rows;
							 //end check database
							// session_register('kodkategori');
							//$_SESSION['kodkategori'] = $kodkategori;
												
							}


if($kodkategori >= 1 and $kodkategori <= 5 ){//1
	//echo "tttt";

	if($kodkategori == 1){//2

	 //login ke ldap
	 if($Login!="" && $Pswd!=""){//3
	 
	 
	require 'conn_ldap.php';
	//echo "id:". $Login;
	//echo "base_dn:". $base_dn;
	$sr = ldap_search($ldapconn,$base_dn,"(noKP=".$Login.")") or die ("Ralat capaian login ke LDAP. <br> Sila Maklumkan kepada Pentadbir sistem");
	$info = ldap_get_entries($ldapconn, $sr);
	
	//echo print_r($info);
	//echo "<br>".$info["count"];
	
	for ($i=0; $i<$info["count"]; $i++) 
		{//4
			$ic_ = $info[$i]["noKP"];
			$user_ = $info[$i]["dn"];
			$name_ = $info[$i]["cn"][0];
			$jawatan_ = $info[$i]["jawatan"][0];
			//$gred_ = $info[$i]["gredJawatan"][0];
			$ext_ = $info[$i]["sambungan"][0];
			$email_ = $info[$i]["email"][0];
			$ic_2=$info[$i]["nokp"][0];
			//$unit_ = $info[$i]["unit"][0];
			//$seksyen_ = $info[$i]["seksyen"][0];
			//$sektor_ = $info[$i]["sektor"][0];
			$bahagian_ = $info[$i]["bahagian"][0];
			$uid_ = $info[$i]["uid"][0];
		}//4
	
	$name_=addslashes($name_);
		
	if($user_!="")//if password and username not empty 
			{//5
				$ldapconn2 = ldap_connect($ldaphost,$ldapport) or die( "Could not connect to {$ldaphost}");
				
				if($ldapconn2)
				{//6
			  $login_ldap = ldap_bind($ldapconn2,$user_,$idpwd) or die("<script>window.alert('No KP dan Katalaluan tidak sepadan ');location.href='index.php';</script>");
			//echo "test";   
			
					
					if($login_ldap)
					{//7
						session_register('s_name','s_email');
						session_register('s_usr_id');
						session_register('s_usr_level');
						
						$_SESSION['userid']=$Login;
						$_SESSION['nama']=$name_;
						$_SESSION['s_email']=$email_;
						$_SESSION['jawatan']=$jawatan_ ;
						//$_SESSION['jawatan']=$ic_2;
						$_SESSION['s_extension']=$ext_;
						$_SESSION['s_bhgn']=$bahagian_;
						$_SESSION['s_seksyen']=$seksyen_;
						$_SESSION['s_unit']=$unit_;
						$_SESSION['valid'] = true;	
						
						$qry_ldap = "select * from pengguna where pengguna.nokp = '$Login'";

                         mysql_select_db($db_voffice, $conn) or die(mysql_error());
                        $result_ldap = mysql_query($qry_ldap,$conn) or die(mysql_error());
                         if(mysql_num_rows($result_ldap)>0){
												
					   $logintime = date("Y-m-d H:i:s");
		               $qry = "INSERT INTO history (UserId,nokp,modul_id,Login) VALUES ('$name_','$ic_2','$modul_id','$logintime')";
		                mysql_query($qry,$conn) or die(mysql_error());
		                $_SESSION['_login_id'] = mysql_insert_id();
						
						echo("<script>location.href='mainmenu.php';</script>");
																	
					
						}
						else
						{
						 $modul_id=3;
						 $logintime = date("Y-m-d H:i:s");
    					 $qry = "INSERT INTO history (UserId,nokp,modul_id,Login) VALUES ('$name_','$ic_2','$modul_id','$logintime')";
						 mysql_query($qry,$conn) or die(mysql_error());
   						 $_SESSION['_login_id'] = mysql_insert_id();
						echo ("<script>window.alert('Pengguna Belum Berdaftar');location.href='index.php';</script>");
						}

						
				//echo $Login. "<BR>";
				//echo "nama ialah".$bahagian_  . "<BR>";
				//return "valid";
				//echo "valid:";
				
						}//7
						
						else
						{//9
							//return "fail1";
							echo "fail to connect to ldap";
						}//9
			ldap_close($ldapconn);
		}//6
		}//5
			else 
			{
			//return "fail2";
			//echo "fail2 kkkk";
			$_SESSION['jns_kategori']=1;
			echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
			
			}
			
	}//3
//validation	
$_SESSION['jns_kategori']=1;
if($Login=="" && $Pswd=="")
{//12
echo ("<script>window.alert('Sila Masukkan NoKP Dan Katalaluan Anda!!');location.href='index.php';</script>");
}//12
	
	if($Login=="" && $Pswd!="")
{//13
echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
}//13

if($Login!="" && $Pswd=="")
{//14
echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
}//14
	
	}//2


			if($kodkategori >= 2 and $kodkategori <= 5){//10
			//echo "mm";
			
//session_start();
//$_SESSION['kodkategori'] = $kodkategori;
//require("config.php");
$userid = mysql_escape_string(trim($_POST['userid']));
$password =mysql_escape_string(trim($_POST['password']));
$qry = "SELECT pengguna.nama as nama,jawatan, pengguna.agensi_id, pengguna.telefon, agensi.nama AS agensi FROM pengguna,agensi WHERE pengguna.nokp = '$userid' AND pengguna.password=MD5('$password') AND pengguna.agensi_id = agensi.id";

mysql_select_db($db_voffice, $conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
if(mysql_num_rows($result)>0){
	$row = mysql_fetch_array($result);
	$_SESSION['userid'] = $userid;
	$_SESSION['nama'] = $row['nama'];
	$_SESSION['agensi'] = $row['agensi'];
	$_SESSION['agensi_id'] = $row['agensi_id'];
	$_SESSION['jawatan'] = $row['jawatan'];
	$_SESSION['telefon'] = $row['telefon'];
	$_SESSION['valid'] = true;		
     $logintime = date("Y-m-d H:i:s");
      $qry = "INSERT INTO history (UserId,nokp,modul_id,Login) VALUES ('".$_SESSION['nama']."','$userid','$modul_id','$logintime')";
	 mysql_query($qry,$conn) or die(mysql_error());
    $_SESSION['_login_id'] = mysql_insert_id();
	
			
	header("location:mainmenu.php");	
}

if($Login=="" && $Pswd=="")
{
echo ("<script>window.alert('Sila Masukkan No KP  Dan Katalaluan Anda!!');location.href='index.php';</script>");
}
if($Login=="" && $Pswd!=""){
echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
}
if($Login!="" && $Pswd==""){
echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
}
else
{
	//echo "Wrong username or password";
	//$_SESSION['error'] = "Wrong username or password";
	//header("location:index2.php"); 
	$_SESSION['jns_kategori']=2;
	echo ("<script>window.alert('No KP dan Katalaluan tidak sepadan');location.href='index.php';</script>");
}
				}//10
	
}//1

	 
else
{
	//echo "masukkan pwd";	
	echo ("<script>window.alert('Sila Pilih Kategori!!');location.href='index.php';</script>");
}

//echo("<script>location.href='menu.php'; <//script>");	
?>
