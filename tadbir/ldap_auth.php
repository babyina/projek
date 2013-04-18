<?php           
session_write_close(); 
session_start(); 
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('display_errors', 1);
$userid = $_POST['userid'];
$password = $_POST['password'];
if($userid!="" && $password!="")  
{ //if password & uname not empty ---> proceed  

   if($userid=="admin")
   {
   //check password admin dari database
   $isAuthenticate = true;	
		$errMsg = "Pengguna belum berdaftar";
		require("config.php");
		//$userid = $_POST['userid'];
		//$password = $_POST['password'];
		$qry = "SELECT pengguna.nama as nama,pengguna.agensi_id, pengguna.jawatan, pengguna.roles, agensi.nama AS agensi FROM pengguna,agensi WHERE pengguna.id = '$userid' AND pengguna.password=MD5('$password') AND statusMohon = 'DAFTAR'";
		
		mysql_select_db($db_voffice, $conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$_SESSION['userid'] = $userid;
			$_SESSION['nama'] = $row['nama'];
			$_SESSION['agensi'] = $row['agensi'];
			$_SESSION['agensi_id'] = $row['agensi_id'];
			$_SESSION['roles'] = $row['roles'];	
			$_SESSION['jawatan'] = $row['jawatan'];	
			$_SESSION['valid'] = true;			
			header("location:mainmenu.php");	
		}
   }
   else
   {
		 require 'conn_ldap.php'; /// connection ke ldap
		 require 'config.php'; //connection ke database
		 //echo "id:". $Login;
		 //echo "base_dn:". $base_dn;
		 
		 //cari user yang dimasukkan dalam ldap entries 
		 
		 $sr = ldap_search($ldapconn,$base_dn,"(noKP=".$userid.")") or die ("Ralat capaian login ke LDAP. <br> Sila Maklumkan kepada   Pentadbir sistem");
		 $info = ldap_get_entries($ldapconn, $sr);
		 
		 //echo print_r($info);
		 //echo "<br>".$info["count"];
		 
		 for ($i=0; $i<$info["count"]; $i++) 
		 {
		 
		  $ic_ = $info[$i]["noKP"];
		  $user_ = $info[$i]["dn"];
		  $name_ = $info[$i]["cn"][0];
		  $jawatan_ = $info[$i]["jawatan"][0];
		  $gred_ = $info[$i]["gredJawatan"][0];
		  $ext_ = $info[$i]["sambungan"][0];
		  $email_ = $info[$i]["email"][0];
		  $unit_ = $info[$i]["unit"][0];
		  $seksyen_ = $info[$i]["seksyen"][0];
		  $sektor_ = $info[$i]["sektor"][0];
		  $bahagian_ = $info[$i]["bahagian"][0];
		  $uid_ = $info[$i]["uid"][0];
		  
		  
		 // echo $user_;
		 }
		 if($user_!="")//if  user exist in ldap entries ---> proceed to login
		 
		 { 
		 
		  require 'conn_ldap.php';
		  //Temporary Login to myexchange server  
		   $user_="uid=".$userid.",".$base_dn;
		 //Temporary Login to myexchange server  --remove this line to login to satuid
		  //echo "kotung:".$user_ ;
		  $ldapconn2 = ldap_connect($ldaphost,$ldapport) or die( "Could not connect to {$ldaphost}");
		  if($ldapconn2)
		  { //if connection to ldap is working->proceed to login
		   
		   $login_ldap = ldap_bind($ldapconn2,$user_,$password);
		   
		   if($login_ldap)
		   {//if login successfull
		   // register sessions & values
		  
			 //ambil maklumat pengguna dari LDAP dan simpan dalam sessions. 
			 $_SESSION['s_usr_id']=$userid;
			 $_SESSION['s_name']=$name_;
			 $_SESSION['s_email']=$email_;
			 $_SESSION['s_jawatan']=$jawatan_;
			 $_SESSION['s_extension']=$ext_;
			 $_SESSION['s_bhgn']=$bahagian_;
			 $_SESSION['s_seksyen']=$seksyen_;
			 $_SESSION['s_unit']=$unit_;
			   
			 //check user roles (permission to use spesific modules)
			 //echo "success";
			 mysql_select_db($database_conn, $conn);
			 $query_rs_pengguna = " SELECT * from pengguna WHERE trim(id)='".trim($uid_)."'";
			 $rs_pengguna = mysql_query($query_rs_pengguna,$conn) or die(mysql_error());
			 $row_rs_pengguna = mysql_fetch_assoc($rs_pengguna);
			 $totalRows_rs_pengguna = mysql_num_rows($rs_pengguna);
			 if($totalRows_rs_pengguna>=1)
			 { 
			 
			 //proceed to-->page admin
			 //register session untuk kegunaan next pages
			 
			 $row = mysql_fetch_array($result);
			 
			 //ambil maklumat pengguna dari database dan simpan dalam sessions
					$_SESSION['userid'] = $userid;
					$_SESSION['nama'] = $row_rs_pengguna['nama'];
					$_SESSION['agensi'] = $row_rs_pengguna['agensi'];
					$_SESSION['agensi_id'] = $row_rs_pengguna['agensi_id'];
					$_SESSION['roles'] = $row_rs_pengguna['roles'];	
					$_SESSION['jawatan'] = $row_rs_pengguna['jawatan'];	
					$_SESSION['valid'] = true;			
				// forward ke	page mainmenu.php
			 header ("location:mainmenu.php"); 
			 
			 }
			 else
			 {
			 //user not exist in the database 
			 //back to login page and notify
			 header ("location:index.php?ref=2");  
			 
			 }
		 
		   }
		   else
		   {
			//if unable to login 
			//wrong password 
			//back to login page
			   
			 header ("location:index.php?ref=4");
			
		   }
			ldap_close($ldapconn);
		  }
		  else 
		  {
		   //if connection to ldap server fail
		   //back to login & notify user
		   header ("location:index.php?ref=5");
		  }
		 }
		  else 
		 {
		 //if user not exist on LDAP
		 //notify user
		 //back to login page
		header ("location:index.php?ref=5");
		 }
		 
  }// end check admin
 
}
else
{
//if username / password is empty
//notify user
//back to login page
header ("location:index.php?ref=6");
}

?>