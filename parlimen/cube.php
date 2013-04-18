<?php
$timezone = +8;
echo date("M d Y H:i:s T A",time()-(8*3600));
?>
<script type="text/javascript"> 
function getTime() { 
var now = new Date(); 
//var currenthour = now.getHours(); 
//var currenttime = now.getMinutes(); 
//var currentdate = now.getDate(); 
var offset = now.gettimezoneOffset(); 
document.write(now); 
//document.write(currenthour + ":" + currenttime + "-" + currentdate);
} 
</script> 
<?php 
$time_current = "<script language=javascript>getTime();</script>"; 
echo "Time:".$time_current; 

if (getenv('TZ') === false) {    
$diff = date('O') / 100;    
putenv('TZ=GMT'.($diff > 0 ? '-' : '+').abs($diff));}
?> 