<?php
require('../fpdf/fpdf.php');
//require('../config.php');

class PDF_FILE extends FPDF{
	function Header(){
	 if($this->PageNo() == 1)
		 $this->SetY(6.5);
	 else
		 $this->SetY(2);

		$this->SetFillColor(255,255,153);
		//$this->SetTextColor(255,51,0);
		$this->SetFont('Arial','B',12);
		$this->Cell(3,1,'HARI',1,0,'C',1);
		$this->SetX(4);
		$this->Cell(4,1,'TARIKH',1,0,'C',1);
		$this->SetX(8);
		$this->Cell(16,1,'PEGAWAI BERTUGAS',1,0,'C',1);
		$this->SetX(24);
		$this->Cell(4.5,1,'CATATAN',1,1,'C',1);
	}
	
	function Row($data){
	    //Calculate the height of the row
    	$nb=0;
	    for($i=0;$i<count($data);$i++)
    	    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	    $h=0.5*$nb;
    	//Issue a page break first if needed
	    $this->CheckPageBreak($h);
    	//Draw the cells of the row
    	for($i=0; $i<count($data); $i++){
	    	if($data[3] == ""){
				$this->SetFillColor(255,255,255);
			}else{
				$this->SetFillColor(255,255,255);
			}
		}
	    for($i=0;$i<count($data);$i++){
	        $w=$this->widths[$i];
    	    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        	//Save the current position
	        $x=$this->GetX();
    	    $y=$this->GetY();
        	//Draw the border
	        $this->Rect($x,$y,$w,$h);
    	    //Print the text
			if ($i==0){
        	$this->MultiCell($w,0.5*3,$data[$i],1,$a,1);
			}if ($i==1){
			$this->MultiCell($w,0.5*3,$data[$i],1,$a,1);
			}if ($i==2){
			$this->MultiCell($w,0.5,$data[$i],1,$a,1);
			}if ($i==3){
			$this->MultiCell($w,0.5*3,$data[$i],1,$a,1);
			}
			//$this->MultiCell($w,5,$data[$i],0,$a);
    	    //Put the position to the right of the cell
        	$this->SetXY($x+$w,$y);
    	}
    	//Go to the next line
    	$this->Ln($h);
	}

	function CheckPageBreak($h){
	    //If the height h would cause an overflow, add a new page immediately
    	if($this->GetY()+$h>$this->PageBreakTrigger)
        	$this->AddPage($this->CurOrientation);
	}
	function SetWidths($w){
    	//Set the array of column widths
    	$this->widths=$w;
	}
function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}

class PDF_TAKWIM extends FPDF{
	function Header(){
		if($this->PageNo() == 1)
			$this->SetY(5.5);
		else
			$this->SetY(2);
			
		$this->SetFillColor(255,255,153);
		$this->SetFont('Arial','B',10);
		$this->Cell(2,1,'HARI',1,0,'C',1);
		$this->Cell(4,1,'TARIKH',1,0,'C',1);
		$this->Cell(7,1,'PEGAWAI BERTUGAS',1,0,'C',1);
		$this->Cell(2,1,'SESI',1,0,'C',1);
		//$this->SetFillColor(255,255,153);
		$this->MultiCell(12.5,0.5,'PERTANYAAN LISAN/ISU YANG DIBANGKITKAN DALAM RANG UNDANG-UNDANG',1,'C',1);
	}
	
	function Row($data){
	    //Calculate the height of the row
    	$nb=0;
	    for($i=0;$i<count($data);$i++)
    	    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	    $h=0.5*$nb;
    	//Issue a page break first if needed
	    $this->CheckPageBreak($h);
    	//Draw the cells of the row
    	for($i=0; $i<count($data); $i++){
	    	if($data[3] == ""){
				$this->SetFillColor(204,204,204);
			}else{
				$this->SetFillColor(255,255,255);
			}
		}
	    for($i=0;$i<count($data);$i++){
	        $w=$this->widths[$i];
    	    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        	//Save the current position
	        $x=$this->GetX();
    	    $y=$this->GetY();
        	//Draw the border
	        $this->Rect($x,$y,$w,$h);
    	    //Print the text
        	$this->MultiCell($w,0.5,$data[$i],1,$a,1);
			//$this->MultiCell($w,5,$data[$i],0,$a);
    	    //Put the position to the right of the cell
        	$this->SetXY($x+$w,$y);
    	}
    	//Go to the next line
    	$this->Ln($h);
	}

	function CheckPageBreak($h){
	    //If the height h would cause an overflow, add a new page immediately
    	if($this->GetY()+$h>$this->PageBreakTrigger)
        	$this->AddPage($this->CurOrientation);
	}
	function SetWidths($w){
    	//Set the array of column widths
    	$this->widths=$w;
	}
function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}

class PDF_PEGAWAI extends FPDF{
	
}
?>