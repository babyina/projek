<?php

if (ob_get_level() == 0) ob_start();

for ($i = 0; $i<10; $i++){
	session_write_close();
       echo "<br> Line to show.";
       echo str_pad('',4096)."\n";    
		 ob_start;
		 ob_end_flush();
       ob_flush();
       flush();
       sleep(2);
}

echo "Done.";

ob_end_flush();

?>