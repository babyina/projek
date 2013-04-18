function out(){
		echo "<table width=100% border=1 cellspacing=1 style=\"border-collapse:collapse\">";
		echo "<tr><th>".implode('</th><th>',$this->header)."</th>";
		$i=0;
		while($row = mysql_fetch_array($this->result)){
			$key = $row[$this->key[0]]; $key_name = $row[$this->key[1]];
			foreach($this->col as $node){
				$data = $row[$node];
				$column .= "<td>$data;</td>";
			}
			$key = "<td class=rec><a href=\"$this->ref".$key.'">'.$key_name."</a>&nbsp;</td>";
			$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
			echo "<tr bgcolor=$rcolor>$key $column</tr>";
			$i++;
			unset($column);
			}
		
		echo "</table>";
	}
