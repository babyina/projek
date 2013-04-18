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
		
	function query($conn,$db){
		mysql_select_db($db,$conn) or die(mysql_error());
		$this->result = mysql_query($this->query,$conn) or die(mysql_error());	
		$this->resultAll = mysql_query($this->query_all,$conn) or die(mysql_error());  
		$this->total_found = mysql_num_rows($this->resultAll);
		$trows = mysql_fetch_array($this->resultAll);
		$this->total = $trows['total'];
		//$this->idUser = $throws['id'];
	}
	function query2($conn,$db){
		mysql_select_db($db,$conn) or die(mysql_error());
		$this->result = mysql_query($this->query,$conn) or die(mysql_error());	
		$this->resultAll = mysql_query($this->query_all,$conn) or die(mysql_error());
		$this->total_found = mysql_num_rows($this->resultAll);
		$trows = mysql_fetch_array($this->resultAll);
		$this->total = $trows['total'];
	}	
	function out(){
		echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; 
			$key_name = $row[$this->key[1]];
			foreach($this->col as $node){
			// print_r($node);
				$data = $row[$node];
				$column .= "<td class=rec>$data&nbsp;</td>";
			}
			$key = "<td class=rec><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
			}
		
		echo "</table>";
	}
	
	function out2(){
		echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			foreach($this->col as $node){
				$data = $row[$node];
				$column .= "<td class=rec align=center>$data&nbsp;</td>";
			}
			$key = "<td class=rec><a href=\"$this->ref".$key.'">&nbsp;'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
		}
		echo "</table>";
	}
	
		function outDel($del,$sys_acl){
		
		echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$extra_header = ($sys_acl==1)?"<th>Hapus?</th>":"";
		echo $extra_header;
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			$del = ($sys_acl==1)?"<td class=rec align=center><a href='index.php?action=deleteDoc&id=$key' onClick=\"return verify()\"><img border=\"0\" src=\"../images/del.gif\"></a></td>":"";
		
		//	$del = $del.$key.$del2;
			foreach($this->col as $node){
				$data = $row[$node];
				$column .= "<td class=rec>$data&nbsp;</td>";
			}
			$column .= $del;
			$key = "<td class=rec><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
		}
		echo "</table>";
	}
	
	//function OutCat($doc_status){
	function OutCat(){
		echo "<table width=100% border=1>";
		echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$cat = "";		
		while($row = mysql_fetch_array($this->result)){
			$status = $row[$this->cat];
			if($cat <> $status){
				echo "<tr><td colspan=".(count($this->col)+2)." align=center><strong>".$doc_status[$status]."</strong>&nbsp;</td></tr>";
				//echo "<tr><td colspan=".(count($this->col)+2)."><strong>".$doc_status[$status]."</strong>&nbsp;</td></tr>";
				$cat = $status;
			}			
		
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			foreach($this->col as $node){
				//$column .= "<td class=rec>".$row[$node]."&nbsp;</td>";
				$column .= "<td>".$row[$node]."&nbsp;</td>";
			}
			//$key = "<td colspan=2 class=rec><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
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
                echo "<tr><td colspan=".(count($this->col)+2)."><strong>$status</strong>&nbsp;</td></tr>";
                $cat = $status;
            }            
        
            $key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
            foreach($this->col as $node){
                $column .= "<td>".$row[$node]."</td>";
            }
            $key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
            $rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
            echo "<tr bgcolor=$rcolor>$key $column</tr>";
            $i++;
            unset($column);
        }
        echo "</table>";
    }
	
	function OutCat3(){
		echo "<table width=100% border=1>";
		echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		$cat = "";		
		while($row = mysql_fetch_array($this->result)){
			$status = $row[$this->cat];
			if($cat <> $status){
				echo "<tr><td colspan=".(count($this->col)+2)." align=center><strong>".$doc_status[$status]."</strong>&nbsp;</td></tr>";
				//echo "<tr><td colspan=".(count($this->col)+2)."><strong>".$doc_status[$status]."</strong>&nbsp;</td></tr>";
				$cat = $status;
			}			
		
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			foreach($this->col as $node){
				//$column .= "<td class=rec>".$row[$node]."&nbsp;</td>";
				$column .= "<td>".$row[$node]."&nbsp;</td>";
			}
			//$key = "<td colspan=2 class=rec><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$key = "<td colspan=2><img src='../images/blank.gif'/><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
		}
		echo "</table>";
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
		echo "<tr valign='middle'><td align=\"left\"/>";
		echo ($mula-1>0)?$ref.($mula-1)."\"><img border=0 align='absmiddle' src='../images/previous.gif'></a>":"";
		for($i=$mula;($i<=$factor*$start);$i++){			
			echo ($i<=$pg)?$ref.$i."\">[".$i."]</a>&nbsp;":"";
		}
		echo ($i<$pg)?$ref.$i."\"><img border=0 align='absmiddle' src='../images/next.gif'></a>":"";		
		echo "</td><td align=\"right\">m.s $currentPage/$totalPage</td></tr>";
		echo "</table>";
	}

}

?>