<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carian</title>
</head>

<body>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
<div align="center">
<?php echo "<form name=\"testcari\" method=\"post\">"; ?>
<table width="531" border="0">
  <tr>
    <th width="47" height="43" scope="col"><div align="center">Carian</div></th> 
    <th width="5" scope="col"><div align="center">:</div></th>
	<th width="465">
      <div align="center">
        <input name="carian" type="text" size="70" >
      </div></th></tr>
   <tr>
   
   <th align="center" colspan="3"><input name="cari" type="submit" value="proses">
     <input type="reset"></th>
   
   
   </tr>
</table>
</div>
<?php echo "</form>"; ?>
</p>
<p>&nbsp; </p>
</body>
</html>
<?php

if($_POST['cari'])

{
echo  $_POST['carian']; 

}
?>