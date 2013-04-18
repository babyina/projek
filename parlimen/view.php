<?php
class View{
	var $query; 
	var $query_all; //get total count 
	var $header;
	var $col;
	var $result,$resultAll;
	var $table;	
	var $ref;
	var $total;

		
	function Query($conn,$db){		
		mysql_select_db($db,$conn) or die(mysql_error());
		$this->result = mysql_query($this->query.$this->limit,$conn) or die(mysql_error());		
		$this->resultAll = mysql_query($this->query,$conn) or die(mysql_error());
		$this->total_found = mysql_num_rows($this->resultAll);
		$this->total_result = mysql_num_rows($this->result);
		$trows = mysql_fetch_array($this->resultAll);
		$this->total = $trows['total'];
	}
	function query2($conn,$db){
		mysql_select_db($db,$conn) or die(mysql_error());
		$this->result = mysql_query($this->query,$conn) or die(mysql_error());	
		$this->resultAll = mysql_query($this->query_all,$conn) or die(mysql_error());
		$this->total_found = mysql_num_rows($this->resultAll);
		$this->total_result = mysql_num_rows($this->result);
		//$this->total_found = mysql_num_rows($this->result);
		$trows = mysql_fetch_array($this->resultAll);
		$this->total = $trows['total'];
	}
	
function Out(){
		echo "<table width=100% border=1 cellspacing=1>";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$id = 0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			if($key!=$id){
				$id = $key;
				if($this->key[1]=="Tarikh")
					$key_name = Reverse($row[$this->key[1]]);
				else
					$key_name = $row[$this->key[1]];
					
				
				$tarikhjawab=Reverse($row[$this->col[0]]);
				$compareYear=substr($tarikhjawab,0,5);
				if($compareYear=="00/00")
					{
					$datebertulis='';
					}
					else
					{
					$datebertulis=$tarikhjawab;
					}
					$column="<td>$datebertulis</td>";
					
				for($a=1; $a<=3; $a++)
						{
						$data = stripslashes($row[$this->col[$a]]);
						$column .= "<td>$data</td>";
						}
				$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$key $column</tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
	}
	
	
	
function Outtarikh(){
		echo "<table width=100% border=1 cellspacing=1>";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$id = 0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			if($key!=$id){
				$id = $key;
				
				$tarikhjawab=Reverse($row['Tarikh']);
				$compareYear=substr($tarikhjawab,0,5);
				 
					 if($compareYear=="00/00")
						{
						$datebertulis='';
						$key_name = $row[$this->key[2]];
						for($a=1; $a<=3; $a++)
						{
						$data = stripslashes($row[$this->col[$a]]);
						$column .= "<td>$data</td>";
						}
						//foreach($this->col as $node){
						//$data = stripslashes($row[$node]);
						//$column .= "<td>$data</td>";
						//}
						$date="<td> $datebertulis</td>";
						$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
						$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
						echo "<tr bgcolor=$rcolor>$date $key $column</tr>";
						$i++;
						unset($column);
						}
						//{
					else
						{
						
						$datebertulis=Reverse($row[$this->key[1]]);
						$key_name = $row[$this->col[0]];
				
						$date="<td>$datebertulis</td>";
					
						for($a=1; $a<=3; $a++)
						{
						$data = stripslashes($row[$this->col[$a]]);
						$column .= "<td>$data</td>";
						}
					$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
					$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
					echo "<tr bgcolor=$rcolor>$date $key $column</tr>";
				$i++;
				unset($column);
						//echo "sss".stripslashes($row['Tarikh']);
						}
				
				
					
				
			}
		}
		echo "</table>";
	}
	

	
	
	function OutSearch($conn){
		echo "<table width=100% border=1 cellspacing=1>";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			$key2 = $this->key[1];
			$key_name= $row[$this->key[1]];
			$key_name = getName($key2,$key_name,$conn);
			//echo $this->key[1];

			foreach(	$this->col as $node){
		
				$data = $row[$node];
				$data = getName($node,$data,$conn);
			
			$column .= "<td>$data</td>";
			
			}
			
			$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
		}
		echo "</table>";
	}
	
	function out3(){
		echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			foreach($this->col as $node){
				$data = ($row[$node]=="")? "&nbsp;":$row[$node];
				$column .= "<td class=rec>$data</td>";
			}
			$key = "<td class=rec><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
		}
		//echo "</table>";
	}
	
		function out2($views){
		//echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];$key_attach = $row[$this->key[2]];
		
			if($views=="tarikh"){
				$key = "<td class=rec><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$file = "<td colspan=\"4\" class=rec><a href=\"$this->ref2".$key_attach.'">'.$key_attach."</a></td>";
			}elseif($views=="yb"){
				$key = " ";
				$file = "<td colspan=\"5\" class=rec><a href=\"$this->ref2".$key_attach.'">'.$key_attach."</a></td>";
			}elseif($views=="status"){
				$key = " ";
				$file = "<td colspan=\"7\" class=rec><a href=\"$this->ref2".$key_attach.'">'.$key_attach."</a></td>";
			}
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $file</tr>";
			$i++;
			unset($column);
		}
		echo "</table>";
	}
	
	function Out_lisan(){
		echo "<table width=100% border=1 cellspacing=1>";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$id = 0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			if($key!=$id){
				$id = $key;
				if($this->key[1]=="Tarikh")
					$key_name = Reverse($row[$this->key[1]]);
				else
					$key_name = $row[$this->key[1]];
					
				
				$tarikhjawab=Reverse($row[$this->col[0]]);
				$compareYear=substr($tarikhjawab,0,5);
				if($compareYear=="00/00")
					{
					$datebertulis='';
					}
					else
					{
					$datebertulis=$tarikhjawab;
					}
					$column="<td>$datebertulis</td>";
					
				for($a=1; $a<=4; $a++)
						{
						if ($a==4)
						{
						$data=($row[$this->col[$a]]==1)?"Dewan Rakyat":"Dewan Negara";
						  
						}
						else
						{
						
						$data = stripslashes($row[$this->col[$a]]);
						}
						$column .= "<td>$data</td>";
						}
				$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$key $column</tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
	}
	
	
	function Out_bertulis(){
		echo "<table width=100% border=1 cellspacing=1>";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$id = 0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			if($key!=$id){
				$id = $key;
				if($this->key[1]=="Tarikh")
					$key_name = Reverse($row[$this->key[1]]);
				else
					$key_name = $row[$this->key[1]];
					
				
				$tarikhjawab=Reverse($row[$this->col[0]]);
				$compareYear=substr($tarikhjawab,0,5);
				if($compareYear=="00/00")
					{
					$datebertulis='';
					}
					else
					{
					$datebertulis=$tarikhjawab;
					}
					$column="<td>$datebertulis</td>";
					
				for($a=1; $a<=3; $a++)
						{
						if ($a==3)
						{
						$data=($row[$this->col[$a]]==1)?"Dewan Rakyat":"Dewan Negara"; 
						  
						}
						else
						{
						//($row['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara";
						$data = stripslashes($row[$this->col[$a]]);
						}
						$column .= "<td>$data</td>";
						}
				$key = "<td><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$key $column</tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
	}
	
	
	
	
	function OutCat(){
	
		echo "<table width=100% border=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;

		$baru=array();
		$kembali=array();
		$pintksp=array();
		$pinksp=array();
		$pinkmk=array();
		$agensi1=array();
		$agensi2=array();
		$tndkksp=array();
		$tndkmk=array();
		$hek=array();
		$pengurusan=array();
		$pengesahan=array();
		$akhir=array();
		$siaptksp=array();
		$siapksp=array();
		$siapmk=array();
		//$namatest[]=array();
	
		while($row = mysql_fetch_array($this->result)){
			$nama_p1 = $row[$this->catp1];
			//$namatest[] = $row[$this->catp1];
			foreach($this->catarray as $node2){
			$namatest[]=$row[$node2];
			}
			
			//if($cat <> $status){
				//echo "<tr><td colspan=".(count($this->col)+2)."><strong>".$doc_status[$status]."</strong></td></tr>";
				//$cat = $status;
			//}			
		   	$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
            $i++;
			$key = $row[$this->key[0]];// $key_name = $row[$this->key[1]];
			$skip=0;
			
			$tarikhjawab=Reverse($row[$this->col[0]]);
			$compareYear=substr($tarikhjawab,0,5);
				 if($compareYear=="00/00")
					{
					$datebertulis='';					
					}				
					else
					{						
					$datebertulis=Reverse($row[$this->col[0]]);		
					}
			
			
			for($a=2;$a<=5;$a++)
			{	
			 if($a==3)
			  
			 $column .= "<td >".displaybutiran($row[$this->col[$a]],$this->conn)."</td>";
			else
			$column .= "<td>".stripslashes($row[$this->col[$a]])."</td>";
			}
						
			
			$key_name = Reverse($row[$this->col[1]]);
			$colbertulis= "<td>".$datebertulis."</td>";
			$key = "<td><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
			$baris = "<tr bgcolor=$rcolor> $colbertulis $key  $column</tr>";
			$keypenyemak = $row[$this->key[2]];
			unset($column);
			unset($colbertulis);
			switch($row[$this->key[1]]) {
							
				case 1 :	$baru[] = $baris;  //soalan baru
							break;
				case 21 :	$agensi1[] = $baris; //belum dibaca
							break;
				case 22 :	$agensi3[] = $baris; //telah dibaca
							break;
				case 23 :	$agensi4[] = $baris; //telah dihantar kpd hek
							break;	
				case 25 :	$kembali[] = $baris; //telah dihantar kpd hek kembali soalan
							break;			
				case 12 :	//$pintksp[] = $baris; //pindaan dari tksp
				            $findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pintksp[]  = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pintksp2[]  = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pintksp3[]  = $baris;
				            }
							
							
							 
				
				             break;
				case 15 :	$pinksp[] = $baris; //pindaan dari ksp
				             break;
							 
				case 18 :	$pinkmk[] = $baris; //pindaan dari mk
				             break;  
							  
				 case 16 :	$tndkmk[] = $baris; //tindakan mkll/susk mkll
				             break; 
				 case 13 :	$tndkksp[] = $baris; //tindakan ksp
				             break;
				//25012011
				case 43 :	$tndkksp_akhir[] = $baris; //tindakan ksp
				             break;
				//end 25012011
				case 44 :	$kementerian_lain[] = $baris; //tindakan ksp
				             break;
				case 14 :	//$siaptksp[] = $baris; //pindaan dah siap ke tksp
				             $findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$siaptksp[]  = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$siaptksp2[]  = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$siaptksp3[]  = $baris;
				            }					
																														
							 break;				
																	 
				 case 17 :	$siapksp[] = $baris; //pindaan dah siap ke ksp
				             break;
				
				 case 19 :	$siapmk[] = $baris; //pindaan dah siap ke mkll/susk mkll
				             break;			 
				case 3 :	$hek[] = $baris;
							break;
							
				case 4 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 41 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2_akhir[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3_akhir[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan_akhir[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 42 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2_sedia_akhir[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3_sedia_akhir[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan_sedia_akhir[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 5 :	$hek[] = $baris;
							break;
				case 6 :	$pengesahan[] = $baris;		
							break;
				case 7 :	$hek7[] = $baris;// HEK pindaan semula
							break;
				case 8 :	$hek[] = $baris;
							break;
				case 9 :	$akhir[] = $baris;
							break;
				case 10 :	$agensi2[] = $baris; //telah dibaca
							break;
			
				case 0 :	$akhir[] = $baris;
							break;
							
				//default : echo "error";
			}

		}
			if(!empty($baru)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Baru"."</strong></td></tr>";
			foreach ($baru as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($kembali)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Dihantar Semula"."</strong></td></tr>";
			foreach ($kembali as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (P))"."</strong></td></tr>";
			foreach ($pintksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp2)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (S&K))"."</strong></td></tr>";
			foreach ($pintksp2 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp3)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (D))"."</strong></td></tr>";
			foreach ($pintksp3 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
				if(!empty($pinksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula -KSP) "."</strong></td></tr>";
			foreach ($pinksp as $value) {			 	
          		echo "$value";
			} 
			unset($value); 
			}
			
			
			if(!empty($pinkmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula -MKll/PTTK MK) "."</strong></td></tr>";
			foreach ($pinkmk as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			if(!empty($siaptksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (P)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siaptksp2)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (S & K)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp2 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siaptksp3)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (D)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp3 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			if(!empty($siapksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."(Pindaan Dari KSP Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siapksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siapmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."(Pindaan Dari MKll/PTTK MK Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siapmk as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			
			if(!empty($tndkksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan  KSP "."</strong></td></tr>";
			foreach ($tndkksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($tndkmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir "."</strong></td></tr>";
			foreach ($tndkmk as $value) {			 	
          		echo "$value"; 
			}
			unset($value);
			}
			
			
			if(!empty($agensi1)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi (Belum Diambil)  "."</strong></td></tr>";
			foreach ($agensi1 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi3)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Bahagian / Agensi(Telah Dibaca)"."</strong></td></tr>";
			foreach ($agensi3 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi4)){
			 //echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Agensi(Telah Hantar)"."</strong></td></tr>"; asal pasa 6 feb 2009
			  echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Jawapan Dari Bahagian / Agensi"."</strong></td></tr>"; 
			foreach ($agensi4 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi2)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Agensi (Pindaan Semula)"."</strong></td></tr>";
			foreach ($agensi2 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			
			/*if(!empty($hek)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Unit Khas"."</strong></td></tr>";
			foreach ($hek as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			*/
			if(!empty($hek7)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan HEK (Pindaan Semula)"."</strong></td></tr>";
			foreach ($hek7 as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			
			if(!empty($pengurusan)){
			// $findme='tksp (p)';// start
			
			/*//foreach($this->catarray as $node2){
			///foreach($namatest as $node3){ start
			      // if($node2=="TKSP (D)")
				// $pos1 = stristr($node3,$findme);
				// if ($pos1 != false) {
				   echo "<tr><td>"."find".$node3."</td></tr>";; 
				// }
				   
			}
			//end*/
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan  Peringkat TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan as $value) {
   			   
      			echo "$value";
				
			}unset($value);
			//echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Test TKSP -".$nama_p1."</strong></td></tr>";
			
			}
			
			if(!empty($pengurusan2)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Peringkat TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2 as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			if(!empty($pengurusan3)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Peringkat TKSP (S&K)"."</strong></td></tr>"; 
			foreach ($pengurusan3 as $value) {
   				
           		echo "$value"; 
				
			}unset($value);
			}
			
			
			if(!empty($pengesahan)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Pengurusan Kedua"."</strong></td></tr>";
			foreach ($pengesahan as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			
			
			if(!empty($akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Jawapan Akhir"."</strong></td></tr>";
			foreach ($akhir as $value) {
   			    
          		echo "$value";
				
			}unset($value);
			}
/*start edit by mas for TKSP jawapan akhir*/		
	if(!empty($pengurusan2_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan3_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (S&K)"."</strong></td></tr>";
			foreach ($pengurusan3_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			
			
		if(!empty($pengurusan2_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan3_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (S&K)"."</strong></td></tr>";
			foreach ($pengurusan3_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//25012011
if(!empty($tndkksp_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-KSP"."</strong></td></tr>";
			foreach ($tndkksp_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//end 25012011
			//25012011
if(!empty($kementerian_lain)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Di Luar Bidang Tugas MOF"."</strong></td></tr>";
			foreach ($kementerian_lain as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//end 25012011
		echo "</table>";
	}
	
	function OutStatus(){
	if(mysql_num_rows($this->result)>0)
		{
		echo "<table width=100% border=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;

		$baru=array();
		$kembali=array();
		$pintksp=array();
		$pinksp=array();
		$pinkmk=array();
		$agensi1=array();
		$agensi2=array();
		$tndkksp=array();
		$tndkmk=array();
		$hek=array();
		$pengurusan=array();
		$pengesahan=array();
		$akhir=array();
		$siaptksp=array();
		$siapksp=array();
		$siapmk=array();
		//$namatest[]=array();
	
		while($row = mysql_fetch_array($this->result)){
			$nama_p1 = $row[$this->catp1];
			//$namatest[] = $row[$this->catp1];
			foreach($this->catarray as $node2){
			$namatest[]=$row[$node2];
			}
			
			//if($cat <> $status){
				//echo "<tr><td colspan=".(count($this->col)+2)."><strong>".$doc_status[$status]."</strong></td></tr>";
				//$cat = $status;
			//}			
		   	$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
            $i++;
			$key = $row[$this->key[0]];// $key_name = $row[$this->key[1]];
			$skip=0;
			
			$tarikhjawab=Reverse($row[$this->col[0]]);
			$compareYear=substr($tarikhjawab,0,5);
				 if($compareYear=="00/00")
					{
					$datebertulis='';					
					}				
					else
					{						
					$datebertulis=Reverse($row[$this->col[0]]);		
					}
			
			
			for($a=2;$a<=4;$a++)
			{	
			 
			 if ($a==2)
			 $column .= "<td width=25%>";
			 else if($a==3)
			 $column .= "<td width=45%>";
			 else if($a==4)
			 $column .= "<td width=10%>";
			
			$column .=stripslashes($row[$this->col[$a]])."</td>";
			
			
			}
						
			
			$key_name = Reverse($row[$this->col[1]]);
			$colbertulis= "<td width=10%>".$datebertulis."</td>";
			$key = "<td width=10%><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
			$baris = "<tr bgcolor=$rcolor > $colbertulis $key  $column</tr>";
			//echo "x".$i ;
			$keypenyemak = $row[$this->key[2]];
			unset($column);
			unset($colbertulis);
			//unset($rcolor);
			switch($row[$this->key[1]]) {
							
				case 1 :	$baru[] = $baris;  //soalan baru
							break;
				case 21 :	$agensi1[] = $baris; //belum dibaca
							break;
				case 22 :	$agensi3[] = $baris; //telah dibaca
							break;
				case 23 :	$agensi4[] = $baris; //telah dihantar kpd hek
							break;	
				case 25 :	$kembali[] = $baris; //telah dihantar kpd hek kembali soalan
							break;			
				case 12 :	//$pintksp[] = $baris; //pindaan dari tksp
				            $findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pintksp[]  = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pintksp2[]  = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pintksp3[]  = $baris;
				            }
							
							
							 
				
				             break;
				case 15 :	$pinksp[] = $baris; //pindaan dari ksp
				             break;
							 
				case 18 :	$pinkmk[] = $baris; //pindaan dari mk
				             break;  
							  
				 case 16 :	$tndkmk[] = $baris; //tindakan mkll/susk mkll
				             break; 
				 case 13 :	$tndkksp[] = $baris; //tindakan ksp
				             break;
				//25012011
				case 43 :	$tndkksp_akhir[] = $baris; //tindakan ksp
				             break;
				//end 25012011
				case 44 :	$kementerian_lain[] = $baris; //tindakan ksp
				             break;
				case 14 :	//$siaptksp[] = $baris; //pindaan dah siap ke tksp
				             $findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$siaptksp[]  = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$siaptksp2[]  = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$siaptksp3[]  = $baris;
				            }					
																														
							 break;				
																	 
				 case 17 :	$siapksp[] = $baris; //pindaan dah siap ke ksp
				             break;
				
				 case 19 :	$siapmk[] = $baris; //pindaan dah siap ke mkll/susk mkll
				             break;			 
				case 3 :	$hek[] = $baris;
							break;
							
				case 4 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 41 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2_akhir[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3_akhir[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan_akhir[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 42 :	$findme='tksp (p)';
				             $possemak = stristr($keypenyemak,$findme);
				           if ($possemak != false) {
							$pengurusan2_sedia_akhir[] = $baris;
				            }
							$findme2='TKSP (S&K)';
							  $possemak2 = stristr($keypenyemak,$findme2);
							if ($possemak2 != false) {
							$pengurusan3_sedia_akhir[] = $baris;
				            }
							
							$findme3='TKSP (D)';
				             $possemak3 = stristr($keypenyemak,$findme3);
				           if ($possemak3 != false) {
							$pengurusan_sedia_akhir[] = $baris;
				            }
				            //$keypenyemak = $row[$this->key[2]];
							break;
				case 5 :	$hek[] = $baris;
							break;
				case 6 :	$pengesahan[] = $baris;		
							break;
				case 7 :	$hek7[] = $baris;// HEK pindaan semula
							break;
				case 8 :	$hek[] = $baris;
							break;
				case 9 :	$akhir[] = $baris;
							break;
				case 10 :	$agensi2[] = $baris; //telah dibaca
							break;
			
				case 0 :	$akhir[] = $baris;
							break;
							
				//default : echo "error";
			}

		}
			if(!empty($baru)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Baru"."</strong></td></tr>";
			foreach ($baru as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($kembali)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Dihantar Semula"."</strong></td></tr>";
			foreach ($kembali as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (P))"."</strong></td></tr>";
			foreach ($pintksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp2)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (S&K))"."</strong></td></tr>";
			foreach ($pintksp2 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($pintksp3)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula - TKSP (D))"."</strong></td></tr>";
			foreach ($pintksp3 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
				if(!empty($pinksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula -KSP) "."</strong></td></tr>";
			foreach ($pinksp as $value) {			 	
          		echo "$value";
			} 
			unset($value); 
			}
			
			
			if(!empty($pinkmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi(Pindaan Semula -MKll/PTTK MK) "."</strong></td></tr>";
			foreach ($pinkmk as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			if(!empty($siaptksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (P)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siaptksp2)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (S & K)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp2 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siaptksp3)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."( Pindaan Dari  TKSP (D)  Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siaptksp3 as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			if(!empty($siapksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."(Pindaan Dari KSP Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siapksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($siapmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."(Pindaan Dari MKll/PTTK MK Telah Siap -PPPB) "."</strong></td></tr>";
			foreach ($siapmk as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			
			
			if(!empty($tndkksp)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan  KSP "."</strong></td></tr>";
			foreach ($tndkksp as $value) {			 	
          		echo "$value";
			}
			unset($value);
			}
			
			if(!empty($tndkmk)){
			
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir "."</strong></td></tr>";
			foreach ($tndkmk as $value) {			 	
          		echo "$value"; 
			}
			unset($value);
			}
			
			
			if(!empty($agensi1)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi (Belum Diambil)  "."</strong></td></tr>";
			foreach ($agensi1 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi3)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Bahagian / Agensi(Telah Dibaca)"."</strong></td></tr>";
			foreach ($agensi3 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi4)){
			 //echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Agensi(Telah Hantar)"."</strong></td></tr>"; asal pasa 6 feb 2009
			  echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Jawapan Dari Bahagian / Agensi"."</strong></td></tr>"; 
			foreach ($agensi4 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			if(!empty($agensi2)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Agensi (Pindaan Semula)"."</strong></td></tr>";
			foreach ($agensi2 as $value) {
   			   
          		echo "$value";
				
			}unset($value);
			}
			
			/*if(!empty($hek)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Unit Khas"."</strong></td></tr>";
			foreach ($hek as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			*/
			if(!empty($hek7)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan HEK (Pindaan Semula)"."</strong></td></tr>";
			foreach ($hek7 as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			
			if(!empty($pengurusan)){
			// $findme='tksp (p)';// start
			
			/*//foreach($this->catarray as $node2){
			///foreach($namatest as $node3){ start
			      // if($node2=="TKSP (D)")
				// $pos1 = stristr($node3,$findme);
				// if ($pos1 != false) {
				   echo "<tr><td>"."find".$node3."</td></tr>";; 
				// }
				   
			}
			//end*/
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan  Peringkat TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan as $value) {
   			   
      			echo "$value";
				
			}unset($value);
			//echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Test TKSP -".$nama_p1."</strong></td></tr>";
			
			}
			
			if(!empty($pengurusan2)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Peringkat TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2 as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			if(!empty($pengurusan3)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Peringkat TKSP (S&K)"."</strong></td></tr>"; 
			foreach ($pengurusan3 as $value) {
   				
           		echo "$value"; 
				
			}unset($value);
			}
			
			
			if(!empty($pengesahan)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan Pengurusan Kedua"."</strong></td></tr>";
			foreach ($pengesahan as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			
			
			if(!empty($akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Jawapan Akhir"."</strong></td></tr>";
			foreach ($akhir as $value) {
   			    
          		echo "$value";
				
			}unset($value);
			}
/*start edit by mas for TKSP jawapan akhir*/		
	if(!empty($pengurusan2_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan3_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (S&K)"."</strong></td></tr>";
			foreach ($pengurusan3_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
			
			
			
		if(!empty($pengurusan2_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (P)"."</strong></td></tr>";
			foreach ($pengurusan2_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan3_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (S&K)"."</strong></td></tr>";
			foreach ($pengurusan3_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
	if(!empty($pengurusan_sedia_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Semakan/Penyediaan Jawapan Akhir-TKSP (D)"."</strong></td></tr>";
			foreach ($pengurusan_sedia_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//25012011
if(!empty($tndkksp_akhir)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Penyediaan Jawapan Akhir-KSP"."</strong></td></tr>";
			foreach ($tndkksp_akhir as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//end 25012011
			//25012011
if(!empty($kementerian_lain)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Soalan Di Luar Bidang Tugas MOF"."</strong></td></tr>";
			foreach ($kementerian_lain as $value) {
   				
           		echo "$value";
				
			}unset($value);
			}
//end 25012011
		echo "</table>";
	}
	}
	
	function OutCat2(){
        echo "<table width=100% border=1>";
        echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
        $i=0;
        $cat = "";        
        while($row = mysql_fetch_array($this->result)){
            $status = $row[$this->cat];
            if($cat <> $status){
                echo "<tr><td colspan=".(count($this->col)+2)."><strong>$status</strong></td></tr>";
                $cat = $status;
            }            
        
            $key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
            foreach($this->col as $node){
                $column .= "<td>".$row[$node]."</td>";
            }
            $key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
            $rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
            echo "<tr bgcolor=$rcolor>$key $column</tr>";
            $i++;
            unset($column);
        }
        echo "</table>";
    }
	
	function testabc($agensi_id){
			if(mysql_num_rows($this->result)>0)
		{
		echo "<table width=100% border=1>";
		$i=0;
		$cat = "";	
		$agen = "";	
		$limit = 1;
		$w = array(5,15,10); 
		while($row = mysql_fetch_array($this->result)){
			$kategori = $this->cat;
			if($cat <> $kategori){
				echo "<tr><td colspan=".(count($this->col)+3)."><strong>".$kategori."</strong></td></tr>";
				$cat = $kategori;
			}	
			if(!empty($this->header) && $limit==1){
				//echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
				echo " </tr><tr><th colspan=2>Tarikh</th><th width=\"55%\">Perkara</th><th>Status</th>";
				$limit = 0;
			}
			//}else
			//	echo "<table width=100% border=1>";		
		
			$key = $row[$this->key[0]]; $key_name = Reverse($row[$this->key[1]]);
			if($agen <> $key){
				$agen = $key;
				foreach($this->col as $node){
					$column .= "<td>".$row[$node]."</td>";
				}
				
				//$q = "SELECT parlimen_agensi.tkh_terima,parlimen_agensi.jawapan FROM parlimen_agensi WHERE parlimen_agensi.id='$key' AND parlimen_agensi.agensi_id = '$agensi_id'"; 
				//AND parlimen.id='$key'";
				$q = "SELECT tkh_terima,parlimen.penyemak,jawapan,parlimen.status FROM parlimen_agensi,parlimen WHERE parlimen_id='$key' AND agensi_id = '$agensi_id' AND parlimen.id='$key'"; 
				//$q = "SELECT tkh_terima,jawapan FROM parlimen_agensi WHERE agensi_id = '56'";
				$r = mysql_query($q) or die (mysql_error());
			
				if((mysql_num_rows($r))<>0)
				{
					while($rows = mysql_fetch_array($r))
					{
						$tkh_terima = $rows['tkh_terima'];
						$jwpn  = $rows['jawapan'];
						$status2=$rows['status'];
						$semak=$rows['penyemak'];
						
						//switch($status2) {
						//case 12 : $status="Pindaan dari TKSP".$status2;
						         //  break;
					 
						
						//}
						
						//if (!($tkh_terima) || $tkh_terima<>'0000-00-00')
						if($status2==12)
						$status = "Pindaan Peringkat TKSP - : ".$semak;						
						elseif($status2==13)
						$status = "Draf Jawapan SSJP ke KSP";	
						elseif($status2==14)
						  $status = "Pindaan telah dihantar ke TKSP - : ".$semak;	
						 elseif($status2==15)
						  $status = "Pindaan dari KSP ";	
						  elseif($status2==16)
						 $status = "Draf Jawapan SSJP ke MK ll / PTTK MK";	
						  elseif($status2==17)
						   $status = "Pindaan telah dihantar ke KSP ";	
						    elseif($status2==18)
						   $status = "Pindaan dari MKII/PTTK MK ";	
						    elseif($status2==19)
						   $status = "Pindaan telah dihantar ke MK II/PTTK MK  ";	
						      elseif($status2==9)
						   $status = "Jawapan Akhir Diluluskan ";	
						     elseif($status2==21)
						   $status = "Soalan Baru";	
						      elseif($status2==22)
						   $status = "Tindakan Bahagian/Agensi (Telah Baca)";	
						      elseif($status2==23) 
						   $status = "Jawapan Bahagian/Agensi (Telah hantar)";	
						//if(!empty($jwpn) || $jwpn<>NULL)
							//$status = $status." dan maklumbalas diterima pada ".Reverse($tkh_hantar);	
											
					}
				}
				$column .= "<td>".$status."</td>";
				
				$key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$key $column</tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
		
		}
	}

	function OutAgensi($agensi_id){
		if(mysql_num_rows($this->result)>0)
		{
		echo "<table width=100% border=1>";
		$i=0;
		$cat = "";	
		$agen = "";	
		$limit = 1;
		$w = array(5,15,10); 
		while($row = mysql_fetch_array($this->result)){
			$kategori = $this->cat;
			if($cat <> $kategori){
				echo "<tr><td colspan=".(count($this->col)+3)."><strong>".$kategori."</strong></td></tr>";
				$cat = $kategori;
			}	
			if(!empty($this->header) && $limit==1){
				//echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
				echo " </tr><tr><th colspan=2  width=\"10%\">Tarikh</th><th  width=\"10%\" >No Soalan</th><th width=\"55%\">Perkara</th><th  width=\"25%\">Status</th>";
				$limit = 0;
			}
			//}else
			//	echo "<table width=100% border=1>";		
		
				$tarikhjawab=Reverse($row[$this->key[1]]);
				$compareYear=substr($tarikhjawab,0,5);
				if($compareYear=="00/00")
					{
					$datebertulis='';
					}
					else
					{
					$datebertulis=$tarikhjawab;
					}
		
			$key = $row[$this->key[0]];
		   $key_name = Reverse($row[$this->key[2]]);
			if($agen <> $key){
				$agen = $key;
				
				$date="<td>$datebertulis</td>";
				
				
					$column .= "<td>".$row[$this->col[1]]."</td>";
				
				
				//$q = "SELECT parlimen_agensi.tkh_terima,parlimen_agensi.jawapan FROM parlimen_agensi WHERE parlimen_agensi.id='$key' AND parlimen_agensi.agensi_id = '$agensi_id'"; 
				//AND parlimen.id='$key'";
				//$q = "SELECT tkh_terima,jawapan FROM parlimen_agensi WHERE parlimen_id='$key' AND agensi_id = '$agensi_id'";  asal pada 18 jan 2010
				$q = "SELECT tkh_terima,jawapan,parlimen.status,parlimen.penyemak,korperat_jawatan FROM parlimen_agensi,parlimen WHERE parlimen_id='$key' AND agensi_id = '$agensi_id' AND parlimen.id='$key'"; 

				//$q = "SELECT tkh_terima,jawapan FROM parlimen_agensi WHERE agensi_id = '56'";
				$r = mysql_query($q) or die (mysql_error());
			
				if((mysql_num_rows($r))<>0)
				{
					while($rows = mysql_fetch_array($r))
					{
						$tkh_terima = $rows['tkh_terima'];
						$jwpn  = $rows['jawapan'];
						$status2=$rows['status'];
						$semak=$rows['penyemak'];
						$korperat_jawatan=$rows['korperat_jawatan'];
						//$status2=$rows['abc'];
						
						if (($status2==4)&&((!($tkh_terima) || $tkh_terima<>'0000-00-00')))
						$status = "Jawapan PPPB telah dihantar pada - : ".$semak.Reverse($tkh_terima);						
						elseif($status2==12)
						$status = "Pindaan dari - : ".$semak.")";
						elseif($status2==41)
						$status = "Jawapan PPPB telah hantar pada  - : ".$semak;
						elseif($status2==42)
						$status = "Jawapan PPPB telah hantar pada - : ".$semak;
						elseif($status2==14)
						   $status = "Pindaan Telah Siap Dari -: ".$semak;	
						 elseif($status2==43)
						 $status = "Jawapan telah hantar pada KSP ";	
						    elseif($status2==15)
						  $status = "Pindaan dari KSP ";	
						elseif(($status2==21)||($status2==22))
						 // $status = "Jawapan PPPB Belum dihantar  -: ".$semak;	
						  $status = "Jawapan PPPB Belum dihantar  ";	
						     elseif($status2==9)
						   $status = "Jawapan Akhir Diluluskan -:".$korperat_jawatan;	
						        elseif($status2==25)
						   $status = "Soalan Dihantar Semula";	
						   
						     elseif($status2==18)
							   $status = "Pindaan dari MKII/ PTTK MK";	
							   elseif($status2==19)
							   $status = "Pindaan telah dihantar ke MK II/PTTK MK";	
						     elseif($status2==13)
						  $status = "Draf Jawapan SSJP ke KSP";	
						     elseif($status2==16)
						 $status = "Draf Jawapan SSJP ke MK ll / PTTK MK";	
						  elseif($status2==17)
						   $status = "Pindaan telah dihantar ke KSP ";	
						      elseif($status2==23) 
						   $status = "Jawapan Bahagian/Agensi (Telah hantar)";	
						    elseif($status2==19)
						   $status = "Pindaan telah dihantar ke MK II/PTTK MK ";	
						//$status = "Jawapan Belum Dihantar";
						//if(!empty($jwpn) || $jwpn<>NULL)
							//$status = $status." dan maklumbalas diterima pada ".Reverse($tkh_hantar);	
											
					}
				}
				$column .= "<td>".$status."</td>";
				
				$key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$date $key $column</tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
		}
	}


  function OutAgensijwp($agensi_id){
		if(mysql_num_rows($this->result)>0)
		{
		echo "<table width=100% border=1>";
		$i=0;
		$cat = "";	
		$agen = "";	
		$limit = 1;
		$w = array(5,15,10); 
		while($row = mysql_fetch_array($this->result)){
			$kategori = $this->cat;
			if($cat <> $kategori){
				echo "<tr><td colspan=".(count($this->col)+4)."><strong>".$kategori."</strong></td></tr>";
				echo"$cat";
				$cat = $kategori;
			}	
			if(!empty($this->header) && $limit==1){
				//echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
				echo " </tr><tr><th colspan=2>Tarikh</th><th >No Soalan</th><th>Nama Y.b</th><th>Perkara</th><th>Bentuk Soalan</th>";
				$limit = 0;
			}
			//}else
			//	echo "<table width=100% border=1>";		
		
			$key = $row[$this->key[0]]; $key_name = Reverse($row[$this->key[1]]);
			if($agen <> $key){
				$agen = $key;
				foreach($this->col as $node){
					$column .= "<td>".$row[$node]."</td>";
				}
				
				//$q = "SELECT parlimen_agensi.tkh_terima,parlimen_agensi.jawapan, parlimen. FROM parlimen_agensi,parlimen WHERE parlimen_agensi.id='$key' AND parlimen_agensi.agensi_id = '$agensi_id'";
				/*$q = "SELECT tkh_terima,jawapan FROM parlimen_agensi WHERE parlimen_id='$key' AND agensi_id = '$agensi_id'";
				$r = mysql_query($q) or die (mysql_error());
			
				if((mysql_num_rows($r))<>0)
				{
					while($rows = mysql_fetch_array($r))
					{
						$tkh_terima = $rows['tkh_terima'];
						$jwpn  = $rows['jawapan'];
						
						
						if (!($tkh_terima) || $tkh_terima<>'0000-00-00')
						$status = "Jawapan telah dihantar pada : ".Reverse($tkh_terima);						
						else
						$status = "Jawapan Belum Dihantar";
						//if(!empty($jwpn) || $jwpn<>NULL)
							//$status = $status." dan maklumbalas diterima pada ".Reverse($tkh_hantar);	
											
					}
				}*/
				//$column .= "<td>"."</td>";
				/*********************/
				/*if($kategori==$kategori)
				{
				$bil=$bil+1;
				$nilai="<td align=center>$bil</td>";
				
				}
			  	else{
				$bil=1;
				$nilai="<td align=center>$bil</td>";
				}*/
				/******edit by mas**********/
				
				$key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				echo "<tr bgcolor=$rcolor>$key $column </tr>";
				$i++;
				unset($column);
			}
		}
		echo "</table>";
		}
	}


	function Paging($pgRow=20,$ref,$currentPage){
		$factor = 5;		
		$page = array();
		//$total = $this->total;
		$total2=$this->total_result;
		//echo "xx".$total2;
		$total = $this->total_found;
		//echo "jum".$total;
		//echo "jumcurrentpage".$currentPage;
		$pgRow=30;
		//echo "pagerow".$pgRow;
		$pg = $total/$pgRow + (($total%$pgRow >0)?1:0);
		$totalPage= floor($pg);
		//echo "jumlah muka".$totalPage;
		
		for($i=1;$i<=ceil($pg);$i++){
			$page[$i] = $i;
			
		}		
		$start = ($currentPage%$factor==0)?floor($currentPage/$factor):floor($currentPage/$factor)+1;		
		//echo "sss".$start; 
		$mula = $factor*($start-1) + 1;
		echo "<table width=\"98%\" border=\"0\">";
		echo "<tr><td align=\"left\"/>";
		echo ($mula-1>0)?$ref.($mula-1)."\"><img src='../images/previous.gif'></a>":"";
		for($i=$mula;($i<=$factor*$start);$i++){			
			echo ($i<=$pg)?$ref.$i."\">[".$i."]</a>&nbsp;":"";
			
		}
		echo ($i<$pg)?$ref.$i."\"><img src='../images/next.gif'></a>":"";		
		echo "</td><td align=\"right\">Muka $currentPage/$totalPage</td></tr>";
		echo "</table>";
	}

}


?>