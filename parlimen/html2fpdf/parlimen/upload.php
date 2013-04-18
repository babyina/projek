<?php
    /*
        this sample is proceedural for those not familiar with OOP. Simply include this file in your
        form processing script and it will handle the uploads. You'll definitely want to make changes to the 
        upload directory and to some of the functionality to change it to how you like to work
        
    !!    This file does no security checking - this solely handles file uploads -
    !!    this file does not handle any security functions. Heed that warning! You use this file at your 
    !!    own risk and please do not publically accept files if you don't know what you're doing with
    !!    server security.


        at the end of this script you will have two variables
        $filenames - an array that contains the names of the file uploads that succeeded
        $error - an array of errors that occured while processing files
        
        
        if the max file size in the form is more than what is set in php.ini then an addition 
        needs to be made to the htaccess file to accomodate this
         
        add this to  your .htaccess file for this diretory
        php_value post_max_size 10M
        php_value upload_max_filesize 10M
        
        replace 10M to match the value you entered above for $max_file_size
         
    */    
    
    // images dir - relative from document root
    // this needs to be a folder that is writeable by the server
    $image_dir = 'KWP/parlimen/lampiran/';
    
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
                            $GLOBALS['error'][] = $file['name'].' - Filename exists - please change your filename';
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
				echo "Extract berjaya <br><br>";

			return $outtext;
			}

			//===================================================
			//        to extract from PDF Document	
			//===================================================



			//===================================================
			//  insert file attribute and content into database	
			//===================================================
			function insert_db($file_name, $content)
			{		
				if(!empty($content))
				{					
					#gantikan dgn table parlimen in future
					$result = mysql_query("insert into word values('perkara', '$file_name', '$content')") or die (mysql_error());
					if($result)
						return true;
					else
						return false;
				}
			}

#---------------------------------------------------------- end of functions --------------------------------------------------------------

            // check to make sure files were uploaded
			//require("config.php");
            $no_files = 0;
            $uploaded = array();
			$full_content = array();
			
            foreach($_FILES as $file)
                {
                    switch($file['error'])
                        {
                            case 0:
								$ext = strrchr($file['name'],'.');	
														
                                // file found - check extension
								$type = $file['type'];
                                if($file['name'] != NULL && okFileType($type) != false)
                                    {
										//getContent
										if($ext == ".doc")
										{	
											$content = parseDoc($file['tmp_name']);
											if(!empty($content))
											{											
												$full_content[]= $content;
												$uploaded[] = $file['name'];												
											}
										}
										
										if($ext == ".pdf")
										{	
											$content = parseDoc($file['tmp_name']);
											if(!empty($content))
											{											
												$full_content[]= $content;
												$uploaded[] = $file['name'];												
											}
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
                
        if(!empty($full_content))
		{
			#$contents = array();
			#$contents = explode("CUT_HERE", $full_content);
			
			for($i=0; $i<count($full_content); $i++)
			{
				#if(insert_db($uploaded[$i], $full_content[$i]) == true)
				#{
					//upload the file
					if(processFile($file) == true)
                      echo $full_content[$i]."<br><br>";
				#}
			}
		}
			
			
?> 