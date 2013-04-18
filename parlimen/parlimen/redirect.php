<?php
//echo  "ccxcx".$_POST['flag_lap'];

//if(($_POST['flag_lap']=='C2')|| ($_POST['flag_lap']=='C3')) 

if(($_POST['flag_lap']=='C2')|| ($_POST['flag_lap']=='C3')) 
//if($_POST['Carian'])
{
header('Location:index.php?action=search&Carian='.$_POST['Carian'].'&rekod='.$_POST['rekod'].'&title='.$_POST['tajuk']);
exit;
}


else

if(($_POST['flag_lap']=='C4'))  
//if($_POST['Date'])
{
header('Location:index.php?action=search&Carian='.$_POST['Date'].'&rekod='.$_POST['rekod'].'&title='.$_POST['tajuk']);
exit;
}



?>