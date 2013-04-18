<?

    // images dir - relative from document root
    // this needs to be a folder that is writeable by the server
    $image_dir = '/parlimen/parlimen/lampiran/';
    
    // upload dir
    $destination = $_SERVER['DOCUMENT_ROOT'].$image_dir;
        
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
                            $GLOBALS['error'][] = ' File telah wujud - sila tukar nama file anda';
                            return false;
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
			function insert_db($jawapan_id, $parlimen_id, $file_name, $content)
			{
				if(!empty($content))
				{					
					#gantikan dgn table parlimen in future
					$result = mysql_query("insert into parlimen_lampiran values('$jawapan_id', '$parlimen_id', '$file_name', '$content')") or die (mysql_error());
					if($result)
						return true;
					else
						return false;
				}
			}
?>
