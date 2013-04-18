<?php
	function sendMail($subject,$sendTo,$mesej){
			$message = "Sila klik URL di bawah untuk keterangan lanjut\n\n$url";

			$a = mail($sendTo, $subject, $message);
			if($a){				
				return "berjaya";
			}else
				return "Tak berjaya";
		}		
	}


	sendMail('Test','jamlee.yanggitom@treasury.gov.my','TESTING PURPOSES: Please Ignore');
?>