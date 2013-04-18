<?php
   

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
    $no_files = 0;
    $uploaded = array();
	$full_content = array();
	$parlimen_id = $_POST['parlimen_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = $_POST['nama_pegawai'];
//	$no_telefon = $_POST['no_telefon'];
	$penyedia_nama = $_POST['penyedia_nama'];
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$pengesah_nama = $_POST['pengesah_nama'];
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$jawapan = $_POST['Jawapan'];
	$tambahan = $_POST['Tambahan'];
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
			
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
					$error[] = "Berjaya diupload";
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
				
	$lampiran = implode("+", $uploaded);
		
	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama',
		penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',
		no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',lampiran='$lampiran'
		WHERE id='$jawapan_id'";
		
	mysql_query($qry,$conn) or die(mysql_error());
	
	//check adakah jawapan telah diterima dr semua agensi
	$qry2 = "SELECT id, jawapan FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		
	$result = mysql_query($qry2,$conn);
	$count = mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
		if($row['jawapan']<>NULL || !empty($row['jawapan']))
			$temp[] = $row['jawapan'];
	}
	//echo $count.count($temp);
	if(count($temp)==$count) //semua jawapan sudah diterima
	{	
		//update doc status
		$qry3 = "UPDATE parlimen SET status = 3 WHERE id='$parlimen_id'";
		mysql_query($qry3,$conn) or die(mysql_error());
	}
	
	if(!empty($error)){
	echo "<table border=\"1\">";
	for($i=0; $i<count($error); $i++)
	{
		echo "<tr><td>".$uploaded[$i]."</td><td>".$error[$i]."</td></tr>";
	}
	echo "</table>";
	}
	
	echo "<br>Rekod telah dikemaskini";
	echo "<br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
?>