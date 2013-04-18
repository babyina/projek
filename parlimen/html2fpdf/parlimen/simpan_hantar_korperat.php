<?php

	function checkLampiran($parlimen_id,$conn)
	{
		$qry3 = "SELECT lampiran from parlimen WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		$result = mysql_query($qry3,$conn) or die(mysql_error());
		if($result==0)
			return "";
		else
		{
			$row = mysql_fetch_row($result);
			return $row['lampiran'];
		}
	}

    if(isset($_FILES))
        {
            // initialize error var for processing
            $error = array();     
            
            // acceptable files
            // if array is blank then all file types will be accepted
            $filetypes = array(
                        'ai' => 'application/postscript',
                        'bin' => 'application/octet-stream',
                        'bmp' => 'image/x-ms-bmp',
                        'css' => 'text/css',
                        'csv' => 'text/plain',
                        'doc' => 'application/msword',
                        'dot' => 'application/msword',
                        'eps' => 'application/postscript',
                        'gif' => 'image/gif',
                        'gz' => 'application/x-gzip',
                        'htm' => 'text/html',
                        'html' => 'text/html',
                        'ico' => 'image/x-icon',
                        'jpg' => 'image/jpeg',
                        'jpe' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'js' => 'text/javascript',
                        'mov' => 'video/quicktime',
                        'mp3' => 'audio/mpeg',
                        'mp4' => 'video/mp4',                        
                        'mpeg' => 'video/mpeg',
                        'mpg' => 'video/mpeg',
                        'pdf' => 'application/pdf',
                        'png' => 'image/x-png',
                        'pot' => 'application/vnd.ms-powerpoint',
                        'pps' => 'application/vnd.ms-powerpoint',
                        'ppt' => 'application/vnd.ms-powerpoint',
                        'qt' => 'video/quicktime',
                        'ra' => 'audio/x-pn-realaudio',
                        'ram' => 'audio/x-pn-realaudio',
                        'rtf' => 'application/rtf',
                        'swf' => 'application/x-shockwave-flash',
                        'tar' => 'application/x-tar',
                        'tgz' => 'application/x-compressed',
                        'tif' => 'image/tiff',
                        'tiff' => 'image/tiff',
                        'txt' => 'text/plain',
                        'xls' => 'application/vnd.ms-excel',
                        'zip' => 'application/zip'
                    );
                    
#-------------------------------------------------------------------------------------------------------------------------------

	require("lampiran.php");
	$pengesahan_status = $_POST['Pengesahan_Status'];
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = $_POST['Korperat_Jawapan'];
	$korperat_tambahan = $_POST['Korperat_Tambahan'];
	$korperat_catatan = $_POST['Korperat_Catatan'];
	$catatan = $korperat_catatan;
	$agensi = $_POST['Agensi'];
	$date = MysqlDate(date("d/m/Y"));

	if ($status==3)
	{
		if($pengesahan_status == "1"){ //Tidak--tiada pindaan
			$next_status = "4";
			$msg = "Rekod telah disimpan.";
		
		}else{  //Ya-- pindaan agensi terpilih
			$next_status = "10";
			$msg = "Rekod perlu dipinda semula.";
			
			//if(is_array($agensi)){
			foreach($agensi as $key)
			{
			$qry3 = "SELECT id FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id' AND agensi_id = '$key'";
			$result = mysql_query($qry3,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$id2 = $row['id'];
			
			$qry2 = "UPDATE parlimen_agensi SET catatan = '$catatan' WHERE id = $id2";
			mysql_query($qry2,$conn) or die(mysql_error());
			//letak email di sini  
			}
		//}			
	}
	
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$korperat_catatan', korperat_tarikh = '$date',
			status = '$next_status' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		
	}elseif($status==5){ // pindaan pengurusan
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 4 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			
	$msg = "Rekod telah disimpan.";
			
	}elseif($status==7){ // pindaan pengesahan
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 6 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	$msg = "Rekod telah disimpan.";
	
	}elseif($status==8){ // utk sahkan after meeting
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 9 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			
	$msg = "Rekod telah disimpan.";
	}
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	foreach($_FILES as $file)
    {
	//echo $file['name'];
    switch($file['error'])
 	{
  		case 0:
			$ext = strrchr($file['name'],'.');	
		    // file found - check extension
			$type = $file['type'];
            if($file['name'] != NULL && okFileType($type) != false)
            {//getContent
				if($ext == ".doc")
				{	
					$content = parseDoc($file['tmp_name']);
					if(!empty($content))
					{											
						//$full_content[]= $content;
						$uploaded[] = $file['name'];												
					}
				}
										
				if($ext == ".pdf")
				{	
					$content = parseDoc($file['tmp_name']);
					if(!empty($content))
					{											
						//$full_content[]= $content;
						$uploaded[] = $file['name'];												
					}
				}
				if(processFile($file) == true)
				{					
					if(insert_db($jawapan_id, $parlimen_id, $file['name'], $content) == true)
                    echo $content."<br><br>";  //buang later, ganti dgn table status upload
				}
			}				                           
                                                                            
          	break;
                                
        case (1|2):
             // upload too large
             $error[] = 'file upload is too large for '.$file['name'];
             break;                        
						      
        case 4:
             // no file uploaded
             break;
			 
        case (6|7):
              // no temp folder or failed write - server config errors
              $error[] = 'internal error - flog the webmaster on '.$file['name'];
              break;
        }
    }
	}
				
	$lampiran = implode("+", $uploaded);//campur dgn lampiran list sebelumnya	
	if(!empty($lampiran))
	{
		$lampiran = checkLampiran($parlimen_id,$conn).$lampiran;
		$qry2 = "UPDATE parlimen SET lampiran = '$lampiran' WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		mysql_query($qry2,$conn) or die(mysql_error());
	}
	
	echo $msg;
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
	
?>