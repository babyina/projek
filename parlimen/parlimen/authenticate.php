<?php
//use code to authenticate without ldap
/*
session_start();
require("config.php");
$userid = $_POST['userid'];
$password = $_POST['password'];
$qry = "SELECT pengguna.nama as nama,jawatan, pengguna.agensi_id, pengguna.telefon, agensi.nama AS agensi FROM pengguna,agensi WHERE pengguna.id = '$userid' AND pengguna.password=MD5('$password') AND pengguna.agensi_id = agensi.id";

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
	header("location:mainmenu.php");	
}else{
	$_SESSION['error'] = "Wrong username or password";
	header("location:index.php"); 
}
*/



//authenticate via ldap
class Access{	
	var $errMsg;	
	var $host;
	var $port;
	var $basedn;
	
	function Access($_host,$_port,$_basedn){
		$this->errMsg = "";
		$this->host = $_host;
		$this->port = $_port;
		$this->basedn = $_basedn;		
	}
	
	function ldap_authenticate($username,$password) {		
		if ($username != "" && $password != "") {
			$ds=@ldap_connect($this->host,$this->port);
			$r = @ldap_search( $ds, $this->basedn, 'uid=' . $username);
			if ($r) {
				$result = @ldap_get_entries( $ds, $r);
				if ($result[0]) {
					if (@ldap_bind( $ds, $result[0]['dn'], $password) ) {
						return $result[0];
					}else{
						$this->errMsg = "Id pengguna & katalaluan tidak sepadan";
					}
				}
			}
		}else{
			$this->errMsg = "Sila isikan Id Pengguna & Katalaluan";
		}
		return NULL;
	}
}

session_start();
$param = "?";
//if(isset($_POST['mode'])){$param = $param."mode=".$_POST['mode']."&";}
if(isset($_POST['action'])){$param = $param."action=".$_POST['action']."&";}
//if(isset($_POST['syst'])){$param = $param."syst=".$_POST['syst']."&";}
if(isset($_POST['id'])){$param = $param."id=".$_POST['id']."&";}
if(isset($_POST['cid'])){$param = $param."cid=".$_POST['cid']."&";}

if(isset($_POST['login'])){

    
	//$userid=$_POST['userid'];
	//$password=mysql_escape_string($_POST['password']);	 
	$password=$_POST['password'];	     
    //$userid = mysql_escape_string($_POST['userid']);
	 $userid = mysql_real_escape_string($_POST['userid']); 
	 $validpass=true;
	 $validpass=sahpass($password);
	 //if (!preg_match("/^[a-zA-Z0-9 \;\.\-\,\]+$/",$quest) )  
	  function sahpass($password)
	  {
	  if( preg_match( "/[a-z0-9_\']{0,}$/i", $password ) )   
            return false;
      }
	 
	echo $validpass;
//	$myAccess = new Access($ldapServer,$ldapPort,$ldapBase);	  

	//if($result = $myAccess->ldap_authenticate($userid,$password)){		 
	

mysql_close($conn);
?>
