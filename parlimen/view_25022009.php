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
		$trows = mysql_fetch_array($this->resultAll);
		$this->total = $trows['total'];
	}
	function query2($conn,$db){
		mysql_select_db($db,$conn) or die(mysql_error());
		$this->result = mysql_query($this->query,$conn) or die(mysql_error());	
		$this->resultAll = mysql_query($this->query_all,$conn) or die(mysql_error());
		$this->total_found = mysql_num_rows($this->resultAll);
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
				foreach($this->col as $node){
					$data = stripslashes($row[$node]);
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

			foreach($this->col as $node){
		
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
	
	function OutCat(){
		echo "<table width=100% border=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;

		$baru=array();
		$agensi1=array();
		$agensi2=array();
		$hek=array();
		$pengurusan=array();
		$pengesahan=array();
		$akhir=array();
	
		while($row = mysql_fetch_array($this->result)){
			//$status = $row[$this->cat];
			//if($cat <> $status){
				//echo "<tr><td colspan=".(count($this->col)+2)."><strong>".$doc_status[$status]."</strong></td></tr>";
				//$cat = $status;
			//}			
		   	$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
            $i++;
			$key = $row[$this->key[0]];// $key_name = $row[$this->key[1]];
			$skip=0;
			foreach($this->col as $node){
				if($skip==1)
					$column .= "<td>".stripslashes($row[$node])."</td>";
				else{
					$skip=1;
					$key_name = Reverse($row[$node]); //tarikh 
				}				
			}
			$key = "<td><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a></td>";
			$baris = "<tr bgcolor=$rcolor>$key $column</tr>";
			unset($column);
			
			switch($row[$this->key[1]]) {
							
				case 1 :	$baru[] = $baris;  //soalan baru
							break;
				case 21 :	$agensi1[] = $baris; //belum dibaca
							break;
				case 22 :	$agensi3[] = $baris; //telah dibaca
							break;
				case 23 :	$agensi4[] = $baris; //telah dihantar kpd hek
							break;			
				case 3 :	$hek[] = $baris;
							break;
				case 4 :	$pengurusan[] = $baris;
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
			if(!empty($agensi1)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan  Bahagian /Agensi  "."</strong></td></tr>";
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
			  echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Jawapan Bahagian / Agensi"."</strong></td></tr>"; 
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
			
			if(!empty($hek)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Unit Khas"."</strong></td></tr>";
			foreach ($hek as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			
			if(!empty($hek7)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan HEK (Pindaan Semula)"."</strong></td></tr>";
			foreach ($hek7 as $value) {
   			   
       			echo "$value";
				
			}unset($value);
			}
			
			if(!empty($pengurusan)){
			 echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Pengurusan"."</strong></td></tr>";
			foreach ($pengurusan as $value) {
   			   
      			echo "$value";
				
			}unset($value);
			}
			if(!empty($pengesahan)){
			echo "<tr><td colspan=".(count($this->col)+2)."><strong>"."Tindakan Pengesahan"."</strong></td></tr>";
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
			

		
		echo "</table>";
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
				
				//$q = "SELECT parlimen_agensi.tkh_terima,parlimen_agensi.jawapan, parlimen. FROM parlimen_agensi,parlimen WHERE parlimen_agensi.id='$key' AND parlimen_agensi.agensi_id = '$agensi_id'";
				$q = "SELECT tkh_terima,jawapan FROM parlimen_agensi WHERE parlimen_id='$key' AND agensi_id = '$agensi_id'";
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

	function Paging($pgRow=20,$ref,$currentPage){
		$factor = 5;		
		$page = array();
		//$total = $this->total;
		$total = $this->total_found;
		$pg = $total/$pgRow + (($total%$pgRow >0)?1:0);
		$totalPage= floor($pg);
		for($i=1;$i<=ceil($pg);$i++){
			$page[$i] = $i;
		}		
		$start = ($currentPage%$factor==0)?floor($currentPage/$factor):floor($currentPage/$factor)+1;		
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