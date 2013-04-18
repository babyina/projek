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
	$password=mysql_escape_string($_POST['password']);	
    $userid = mysql_escape_string($_POST['userid']);
	
//	$myAccess = new Access($ldapServer,$ldapPort,$ldapBase);	

	//if($result = $myAccess->ldap_authenticate($userid,$password)){		
	if(isset($userid) && isset($password))
	{
		
		/*
		$qry = "SELECT Nama,Kategori,Jabatan,Jenis FROM pengguna WHERE Id='$userid'";		
		
		mysql_select_db($db_voffice,$conn) or die(mysql_error());
		$res = mysql_query($qry,$conn) or die(mysql_error());		
		if(mysql_num_rows($res)<=0){
			$isAuthenticate = false;
			$errMsg = "Pengguna belum berdaftar";
		}else{
			$row = mysql_fetch_array($res);
			$isAuthenticate = true;			
			$_SESSION['userid'] = $userid;			
			$_SESSION['fullname'] = $row['Nama'];			
			$_SESSION['administrator'] = ($row['Kategori']=='admin')?true:false;
			$_SESSION['pengurusan'] = ($row['Jenis']== 7)?true:false;
			$_SESSION['dpa'] = ($row['Jenis']== 6)?true:false;					
			$_SESSION['jabatan'] = $row['Jabatan'];	
			$_SESSION['_jabatan'] = $row['Jabatan'];
			$_SESSION['valid'] = true;		
			*/
		$isAuthenticate = true;	
		$errMsg = "Pengguna belum berdaftar";
		require("config.php");
		//$userid = $_POST['userid'];
		//$password = $_POST['password'];
		$qry = "SELECT pengguna.nama as nama, pengguna.jawatan, pengguna.emel, pengguna.agensi_id, pengguna.telefon FROM pengguna WHERE pengguna.id = '$userid' AND pengguna.password=MD5('$password') AND statusMohon = 'DAFTAR'";
		
		mysql_select_db($db_voffice, $conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		if(mysql_num_rows($result)>0){
		
			$row = mysql_fetch_array($result);
			$_SESSION['userid'] = $userid;
			$_SESSION['nama'] = $row['nama'];
			$_SESSION['agensi_id'] = $row['agensi_id'];
			$_SESSION['jawatan'] = $row['jawatan'];
			$_SESSION['emel'] = $row['emel'];
			$_SESSION['telefon'] = $row['telefon'];
			$_SESSION['valid'] = true;	
			//header("location:mainmenu.php");
		}else{
			if ($_POST['action']=='details') {
					header("location:login.php?valid=false&action=details&id=".$_POST['id']);
			}elseif ($_POST['action']=='detailsbahas') {
					header("location:login.php?valid=false&action=detailsbahas&cid=".$_POST['cid']);
			}else
				header("location:index.php?valid=false"); 
			exit;
		}
		
		if($_SESSION['agensi_id']<>0)
		{
			$id = $_SESSION['agensi_id'];
			$qry2 = "SELECT agensi.nama AS agensi FROM agensi WHERE agensi.id = '$id'";
			mysql_select_db($db_voffice, $conn) or die(mysql_error());
			$result2 = mysql_query($qry2,$conn) or die(mysql_error());
			
			$row2 = mysql_fetch_array($result2);
			$_SESSION['agensi'] = $row2['agensi'];
		}
		
	}
	}else{ //if login

		$isAuthenticate = false;
		//$errMsg = $myAccess->errMsg;
	}

	if($isAuthenticate == true){
	$action = $_POST['id'];
		//record user login
		$logintime = date("Y-m-d H:i:s");
		$qry = "INSERT INTO history (UserId,Login) VALUES ('$userid','$logintime')";
		mysql_query($qry,$conn) or die(mysql_error());
		$_SESSION['_login_id'] = mysql_insert_id();
		//direct user to location or main menu
		if(isset($_POST['action'])){
			if ($_POST['action']=='details') {
					header("location:parlimen/index.php?action=details&id=".$_POST['id']);
			}
			elseif ($_POST['action']=='detailsbahas') {/*
			?><script> alert("<? echo $action ?>"); </script> <?php
			*/			
				if(isset($_POST['id'])){
					header("location:parlimen/index.php?action=detailsbahas&id=".$_POST['id']);
				}
				elseif(isset($_POST['cid'])){				
					header("location:parlimen/index.php?action=detailsbahas&cid=".$_POST['cid']);
				}
			}
			elseif($_POST['action']=='detailsKal') {
				header("location:kalendar/index.php?action=detailsKal&id=".$_POST['id']);
			}
			else{
				header("location:mainmenu.php"); 
			}
			//}
		}elseif($_GET['cont']){
			$cont	= rawurldecode($_GET['cont']);
			header("location:".$cont);
		}
		else {		
			header("location:mainmenu.php");	
		}
	}else {	
		$log = "index.php".$param;
		?>
		<table width="300" style="border-style:double;border-color:red;border-width:3px">			
			<tr><td>
			<img src="images/login_err.gif"/></td>
			<td style="font-size:14;font-weight:bold">
			Pengguna Tidak Disahkan.
			<?php echo $errMsg ?><br/>
			<a href='<?php echo $log ?>'>Login semula</a>
			</td></tr>
		</table>
		
		<?php
	}


mysql_close($conn);
?>
