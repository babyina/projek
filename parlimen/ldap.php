<?
$dbhost = "localhost"; // server name
$dbuser = "root"; // database's user name
$dbpass = "xs2mysql"; // database's user password xs2mysql
$db     = "inteam"; // database name
$ldapserver = "mail.mardi.my"; // server ldap

/*
$array_OU = array(
			"ou" => "AD",
			"ou" => "BB",
			"ou" => "BT",
			"ou" => "BU",
			"ou" => "ET",
			"ou" => "HR",
			"ou" => "IS",
			"ou" => "KJ",
			"ou" => "LR",
			"ou" => "MA",
			"ou" => "PK",
			"ou" => "PKP",
			"ou" => "PS",
			"ou" => "PT",
			"ou" => "RI",
			"ou" => "SM",
			"ou" => "SR",
			"ou" => "TM",
			"ou" => "TS",
			"ou" => "UP"
					);
Senarai OU:
OU=AD
OU=BB
OU=BT
OU=BU
OU=ET
OU=HR
OU=IS
OU=KJ
OU=LR
OU=MA
OU=PK
OU=PKP
OU=PS 204org
OU=PT
OU=RI
OU=SM
OU=SR
OU=TM
OU=TS
OU=UP

OU=JICA X
OU=MGMT X
OU=TFNET X
 */

 $array_OU = array(
			"ou1" => "AD",
			"ou2" => "BB",
			"ou3" => "BT",
			"ou4" => "BU",
			"ou5" => "ET",
			"ou6" => "HR",
			"ou7" => "IS",
			"ou8" => "KJ",
			"ou9" => "LR",
			"ou10" => "MA",
			"ou11" => "PK",
			"ou12" => "PKP",
			"ou13" => "PS",
			"ou14" => "PT",
			"ou15" => "RI",
			"ou16" => "SM",
			"ou17" => "SR",
			"ou18" => "TM",
			"ou19" => "TS",
			"ou20" => "UP"
					);


	
$conn=mysql_connect($dbhost, $dbuser, $dbpass);
if(!$conn)	
	die("Pelayan Pangkalan Data terputus. Sila hubungi pegawai berkenaan.");		
if(!mysql_select_db($db,$conn))
	die("Pangkalan data tidak dapat disambung. Sila hubungi pegawai berkenaan.");

$query = "SELECT * FROM access_info WHERE uid = 'cikgu'";
$res = mysql_query($query)or die(mysql_error());
$re = mysql_fetch_array($res);
echo $re['uid'] . ": " . $re['noK']. "<br><br>"; 
$search = "uid=*";
$user = "CN=Cikgu Besar,OU=IS,O=MARDI";
$pass = "******"; //kena edit nih..tak leh tunjuk, nak run baru tunjuk

echo "<h3>Domino LDAP entries insert into mysql</h3>";
echo "Connecting domino ldap...";
$ds=ldap_connect($ldapserver);  // must be a valid LDAP server!
echo "connect result is ".$ds."<p>";

if ($ds) {
    echo "Binding ...";
    $r=ldap_bind($ds,$user,$pass);     // this is an "anonymous" bind, typically
                           // read-only access
    echo "Bind result is ".$r."<p>";

    echo "Searching for $search ...";
    // Search entry
	foreach($array_OU as $ou => $ouname){
		$ldapbase = "OU=$ouname,O=MARDI"; // ldap base
		echo "<h1>$ouname</h1>";
		$sr=ldap_search($ds,$ldapbase, $search);  
		echo "Search result is ".$sr."<p>";
	
		echo "Number of entires returned is ".ldap_count_entries($ds,$sr)."<p>";
	
		echo "Getting entries ...<p>";
		$info = ldap_get_entries($ds, $sr);
		echo "Data for ".$info["count"]." items returned:<p>";
	
		for ($i=0; $i<$info["count"]; $i++  ) {
	//	$bil++;
			echo "<b>CN:</b> ". $info[$i]["cn"][0] ."<br>";
			$noK = $info[$i]["employeeid"][0];
			$uid = $info[$i]["uid"][0];
			$mail = $info[$i]["mail"][0];
			echo "<b>No.K:</b> $noK<br><b>User ID:</b></b> $uid<br>";
			echo "<b>Email:</b> $mail<br>";
			$query = "INSERT INTO access_info (uid , noK , email) VALUES ('$uid', '$noK', '$mail')";
			$result = mysql_query($query)or $error=1;
			if($error==1){
			$query = "UPDATe access_info SET email = '$mail' WHERE uid = '$uid'";
			$result = mysql_query($query) or die (mysql_error());
			echo "<b>$uid updated</b><br><br>";
			}else{
			echo "Success insert value $i<br><br>"; }
	//	if ($bil==200){die("Stop!!!!");}
		}
	}
    echo "Closing connection";
    ldap_close($ds);

} else {
    echo "<h4>Unable to connect to LDAP server</h4>";
} 

?>