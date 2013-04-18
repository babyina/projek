<?php
// LDAP variables
$ldapuid = "application";
$ldaphost = "10.23.34.80";  // ldap servers
$ldapport = 389;       //  ldap server's port number"
$ldappswd = "cde3.4rfv";
$base_dn="ou=users, dc=gatekeeper, dc=treasury, dc=gov, dc=my";          
// Connecting to LDAP
$ldapconn = ldap_connect($ldaphost,$ldapport) or die( "Could not connect to {$ldaphost}");
//echo "<br>".$base_dn;
$login_ldap=ldap_bind($ldapconn,"uid=" . $ldapuid . "," . $base_dn,$ldappswd); 

?>
