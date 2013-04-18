<?php

// function to check for accpetable file type
function okFileType($type)
{
     // if filetypes array is empty then let everything through
     if(count($GLOBALS['filetypes']) < 1)
     {
          return true;
     }
    // if no match is made to a valid file types array then kick it back
     elseif(!in_array($type,$GLOBALS['filetypes']))
     {
          $GLOBALS['error'][] = $type.' is not an acceptable file type. '.
          $type.' has been ignored.';
          return false;
     }
     // else - let the file through
     else
     {                        
          return true;
     }
}
            
// function to check and move file
function processFile($file)
{    
// set full path/name of file to be moved
      $upload_file = $GLOBALS['destination'].$file['name'];
                    
      if(file_exists($upload_file))
      {
		?>
		<script>
		//confirm("Overwrite file?");
		</script>
		<?php
        // $GLOBALS['error'][] = ' File telah wujud - sila tukar nama file anda';
		unlink($upload_file);
        //return false;
       }
                    
       if(!move_uploaded_file($file['tmp_name'], $upload_file)) 
       {
            // failed to move file
            $GLOBALS['error'][] = 'File Upload Failed on '.$file['name'].' - Please try again';
            return false;
       } 
       else 
       {
            // upload OK - change file permissions
            chmod($upload_file, 0755);
            return true;
       }
}
            
//===================================================
//        to extract from Word Document	
//===================================================

function parseDoc($userDoc)
{
	$fileHandle = fopen($userDoc, "r");
	if (!fopen($userDoc, "r")) {
		echo "Error: The file <b>($userDoc)</b> does not exist";
		return;
	}
	$line = @fread($fileHandle, filesize($userDoc));
	$lines = explode(chr(0x0D),$line);
	$outtext = "";
	foreach($lines as $thisline)
	{
		$pos = strpos($thisline, chr(0x00));
		if (($pos !== FALSE)||(strlen($thisline)==0))
		{
		
		} else {
			$outtext .= $thisline." ";
		}
	}
	$outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
	//echo "Extract berjaya <br><br>";
	return $outtext;
}

//===================================================
//        to extract from PDF Document	
//===================================================



//===================================================
//  insert file attribute and content into database	
//===================================================
function insert_db($kal_id, $jenis, $file_name)
{
		$result = mysql_query("insert into kal_lampiran(kal_id, jenis, nama_fail) values('$kal_id', '$jenis', '$file_name')") or die (mysql_error());
		if($result)
			return true;
		else
			return false;
}

//---------------------------------------------------- process files -------------------------------------------------
			
		
    // images dir - relative from document root
    // this needs to be a folder that is writeable by the server
    $image_dir = 'parlimen/kalendar/lampiran/';
    
    // upload dir
    $destination = $_SERVER['DOCUMENT_ROOT'].$image_dir;
    
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
                    

    foreach($_FILES as $file)
    {
    switch($file['error'])
 	{
  		case 0:
			$ext = strrchr($file['name'],'.');	
			$type = $file['type'];
			if($file['name'] != NULL)
            {
				$uploaded[] = $file['name'];
				if(processFile($file) == true)
				{					
					if(insert_db($id, $jenis, $file['name']) == true)
					$error[] = "Berjaya diupload";
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
	
	#-------------------------------------------------------------------------------------------------------------------------------
	
	if(!empty($uploaded))
	{			
	$lampiran = implode("+", $uploaded);//campur dgn lampiran list sebelumnya	
	}
	
	?>

