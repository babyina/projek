<?php 
session_start();
//--------------------- auto logout ----------------------------//
if($_SESSION['timer']<>null){
	//if(time() - $_SESSION['timer'] >300){
	if(time() - $_SESSION['timer'] >1200){
		//auto logout after 5 minute		
		//header("location:auto_logout.php");
		//exit(0);
	}	
}
$_SESSION['timer'] = time()+0; //set to current time
if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}

if ($_SESSION['valid'] == false){
	echo "invalid session";	
	exit(0);
}
//---------------------------------------------------------------//
	

include("../config.php");
include('../keyword.php');

$sys_acl = checkModul($conn,$db_voffice,"modul1",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}

$isHEK 			= checkOfficer($_SESSION['userid'],3,$conn);	
$isPengurusan 	= checkOfficer($_SESSION['userid'],4,$conn);
$isPengesahan 	= checkOfficer($_SESSION['userid'],5,$conn);
$isSUSK_PTTK 	= checkOfficer($_SESSION['userid'],11,$conn);
$isKSP 			= checkOfficer($_SESSION['userid'],8,$conn);
	
?>
<html>
	<head>
		<title>Sistem Soal Jawab Parlimen</title>
		<body onbeforeunload="LOGOUTFUNCTION()">
	 <link href="../jQuery/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="../jQuery/jquery.min.js"></script>
    <script src="../jQuery/jquery-ui.min.js"></script>
	<script src="../file.js"></script>
 	<script type="text/javascript" SRC="../jQuery/jquery-idleTimeout.js"></script>
		<link rel="stylesheet" href="../style.css"> 
		<style type="text/css">
			div.scroll {
				height: 100px;
				width: auto;
				overflow: auto;
				border: 1px solid #CCC;
				background-color: #FFFFFF;
				padding: 8px;
			}
		</style>
        <script type="text/javascript">
		$(document).ready(function(){
         $(document).idleTimeout({
      //             1200000
		//inactivity:1200000,
		inactivity:1150000,
        noconfirm: 10000,
       sessionAlive: 100000  
    });
  }); 
		/* start here kod by masitah
		var t=setTimeout("test();",1200000);
		
		function time()
		{
		t=setTimeout("test();",1200000);
		}

		function test()
		{
			var where_to=confirm("Adakah anda ingin keluar dari sistem??");
			
			if (where_to== true)
 			{
   			window.location="../logout.php";
 			}
			else
		 	{
 		
  			}
			clearTimeout(t);
			time();
		}
		end */
</script> 
		<script type="text/javascript">
		function LOGOUTFUNCTION()
		{
		
   
		//if (window.event.clientX>500 || window.event.clientY<0) 
		if (window.event.clientY<0) 
			{
			window.location.href = "../logout.php";
			
				}
             
			}
		
		</script> 
		<script language='javascript' src="../popcalendar.js"></script>
		<script language="JavaScript" SRC="../function.js"></script>
		<script src="multifile_compressed.js"></script> <!-- Include the MULTI_UPLOAD function  -->
		<script language="javascript">
			var $id = 0;
			//var a_state = 1;
			var image1 = new Image(); image1.src = "../images/expand.gif";
			var image2 = new Image(); image2.src = "../images/collapse.gif";
			
			function collapse(state,div,img){
				var obj = document.getElementById(div.name);								
				var image = document.getElementById(img.name);
	
				if(state==0){
					obj.style.display = 'none';							
					image.src = image1.src;
					return 1;
				}else{
					obj.style.display = '';
					image.src = image2.src;
					return 0;
				}
			}
			</script>
<?php
if($_GET['action']=="search" and $_GET['rekod']==1){
include("../../soal_jawab/java_search.php");	
}
?>
</head>
<?php if($_GET['action']=="search" and $_GET['rekod']==1){?>
<body onLoad="searchPrompt('<?php echo $_GET['Carian']; ?>', true, 'red', 'yellow');">
<?php } else { ?>
<body>
<?php } ?>
		<table border=0 width=100% cellspacing=0 height="100%">
			<tr><td style="padding:0px"><?php include("../header.php") ?></td></tr>
			<tr height="100%"><td style="padding:0px">
				<table border=0 width=100% cellspacing=0 height="100%">
					<tr>
						<td valign="top" width="200" bgcolor="#e7efff" style="padding-left:10px">
							<div align="center">
								<a href="../mainmenu.php"><img src="../images/home.gif" border="0" alt="Menu Utama"/></a> <a href="../logout.php"></a>
								<a href="../logout.php"><img src="../images/logout.gif" alt="Logout" width="20" height="20" border="0" align="bottom"/></a>
							</div>
							<?php include("menu.php")?>
						</td>
					  <td valign="top" bgColor="#e7efff" style="padding:10px 10px"><?php include("content.php") ?></td>
					</tr>
				</table>
			</td></tr>
			<tr><td style="padding:0px"><?php include("../footer.php") ?></td></tr>
		</table>
	</body>
</html>