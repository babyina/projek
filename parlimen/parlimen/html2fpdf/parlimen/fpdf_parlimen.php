<?php
session_cache_limiter('public');
session_start();

if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}

function findHari($mysql_date){
	if($mysql_date == "0000-00-00") return "";
	$dt = explode("-",$mysql_date);
	$weekday = date("w",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));	
	$weekname = array("AHAD","ISNIN","SELASA","RABU","KHAMIS","JUMAAT","SABTU");
	return $weekname[$weekday];
}

function findNextString($string,$pdf,$width){
	$word = array();
	$text = split(" ",$string);	
	foreach($text as $node){
		$text1 .= " ".$node;
		if($pdf->GetStringWidth($text1)>$width){
			$sentence = substr($text1,0,-strlen($node));
			return $sentence;
		}
	}
	return "";
}

require('../config.php');
require('../keyword.php');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function CellX($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
{
	$k=$this->k;
	if($this->y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak())
	{
		$x=$this->x;
		$ws=$this->ws;
		if($ws>0)
		{
			$this->ws=0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation);
		$this->x=$x;
		if($ws>0)
		{
			$this->ws=$ws;
			$this->_out(sprintf('%.3f Tw',$ws*$k));
		}
	}
	if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
	$s='';
	if($fill==1 or $border==1)
	{
		if($fill==1)
			$op=($border==1) ? 'B' : 'f';
		else
			$op='S';
		$s=sprintf('%.2f %.2f %.2f %.2f re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x=$this->x;
		$y=$this->y;
		if(is_int(strpos($border,'L')))
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(is_int(strpos($border,'T')))
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(is_int(strpos($border,'R')))
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(is_int(strpos($border,'B')))
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!='')
	{
		if($align=='R')
			$dx=$w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx=($w-$this->GetStringWidth($txt))/2;
		elseif($align=='FJ')
		{
			//Set word spacing
			$wmax=($w-2*$this->cMargin);
			$this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt,' ');
			$this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
			$dx=$this->cMargin;
		}
		else
			$dx=$this->cMargin;
		$txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		if($this->ColorFlag)
			$s.='q '.$this->TextColor.' ';
		$s.=sprintf('BT %.2f %.2f Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
		if($this->underline)
			$s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s.=' Q';
		if($link)
		{
			if($align=='FJ')
				$wlink=$wmax;
			else
				$wlink=$this->GetStringWidth($txt);
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$wlink,$this->FontSize,$link);
		}
	}
	if($s)
		$this->_out($s);
	if($align=='FJ')
	{
		//Remove word spacing
		$this->_out('0 Tw');
		$this->ws=0;
	}
	$this->lasth=$h;
	if($ln>0)
	{
		$this->y+=$h;
		if($ln==1)
			$this->x=$this->lMargin;
	}
	else
		$this->x+=$w;
}
}


//-----------------mysql ---------------
$id = $_POST['id'];
$qry = "SELECT * FROM parlimen WHERE id='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);

$pageW = 595;
$top_margin = 60;
$fontSize = 16;

$x1 = $margin_right = $margin_left = 30;
$x2 = $x1 + 154.5;
$x3 = $x2 + 154.5;
$x4 = $x3 + 103;

$txtWidth = $pageW - $margin_left - 40;

$pdf = new PDF('P','pt','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','BU',$fontSize);
//$pdf->MultiCell(0,0,"JAWAPAN PERTANYAAN",0,'C');
$pdf->MultiCell(0,0,"PEMBERITAHUAN PERTANYAAN",0,'C');
$pdf->Ln($fontSize);
$pdf->MultiCell(0,0,strtoupper($row['SesiDewan']),0,'C');
$pdf->Ln($fontSize);
$pdf->MultiCell(0,0,"MALAYSIA",0,'C');
$pdf->Ln($fontSize*2.5);
$y = $pdf->GetY();
$y += $fontSize*2;
$pdf->SetFont('Arial','B',$fontSize);

$pdf->Cell(0,$fontSize,"PERTANYAAN");
$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");
$pdf->SetX($x2 + 10); $pdf->Cell(0,$fontSize,strtoupper($row['BentukSoalan']),0,1);
$pdf->Ln($fontSize*0.5);
$nama = splitNama(strtoupper($row['AhliDewan']));

$pdf->Cell(0,$fontSize,"DARIPADA ");
$pdf->SetX($x2);
$pdf->Cell(0,$fontSize,":");
$pdf->SetX($x2 + 10);
$pdf->MultiCell(0,$fontSize,$nama[0],0,'L');
$pdf->SetX($x2 + 10);
$pdf->Cell(0,$fontSize,$nama[1],0,1);
$pdf->Ln($fontSize*0.5);

$hari = findHari($row['TkhBentang']);
$pdf->Cell(0,$fontSize,"TARIKH");
$pdf->SetX($x2); $pdf->Cell(0,$fontSize,":");
$pdf->SetX($x2 + 10); $pdf->Cell(0,$fontSize,formatDate($row['TkhBentang'])." ($hari)",0,1);


$pdf->Ln($fontSize*2);

$string = $row['Soalan'];

$find[0] = " minta ";
$find[1] = " meminta ";

$pos1 = stripos($string,$find[0]); $pos2 = stripos($string,$find[1]);
if($pos1 <> 0 && $pos2 <> 0){
	$pos = min($pos1,$pos2);
}elseif($pos1 <>0) $pos = $pos1;
elseif($pos2 <>0) $pos = $pos2;
else $pos = 0;

if($pos == 0){
	$pdf->SetFont('Arial','B',$fontSize);
	$pdf->MultiCell(0,$fontSize*2,$string);
}else{
	$yb = strtoupper(substr($string,0,$pos));
	$ayat = substr($string,$pos);
	
	$pw = 530;
	$pdf->SetFont('Arial','BU',$fontSize);
	$yb_width = $pdf->GetStringWidth($yb);
	$balance_width = $pw - $yb_width;
	
	$pdf->Cell($yb_width,$fontSize,$yb);
	$pdf->SetFont('Arial','B',$fontSize);
	$sentence = findNextString($ayat,$pdf,$balance_width);
	$pdf->SetX($pdf->GetX() + 10);
	$pdf->CellX($balance_width,$fontSize,trim($sentence),0,0,'FJ');
	$next_para = str_ireplace(trim($sentence),"",$ayat);
	$pdf->Ln($fontSize*1.5);
	$pdf->MultiCell(0,$fontSize*2,trim($next_para));
	$pdf->AddPage();
	$pdf->SetFont('Arial','BU',$fontSize);
	$pdf->Cell(0,$fontSize*1.5, "JAWAPAN",0,1);
	$pdf->SetFont('Arial','B',$fontSize);
	$pdf->MultiCell(0,$fontSize*2,strip_tags($row['Jawapan']));
}

$pengesah = $row['PegPengesah'];
$qry = "SELECT * FROM pengguna WHERE Nama='$pengesah'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);

$pdf->AddPage();
$pdf->Cell(0,$fontSize,"Disediakan oleh,",0,1);
$qry = "SELECT DISTINCT
pengguna.nama,pengguna.jawatan,pengguna.telefon,pengguna.emel,parlimen_agensi.agensi_id
FROM
parlimen_agensi
INNER JOIN pengguna ON parlimen_agensi.agensi_id = pengguna.agensi_id
WHERE
parlimen_agensi.parlimen_id = '$id';
$result = mysql_query($qry,$conn) or die(mysql_error());
while($rowk = mysql_fetch_array($result)){
	$pdf->Ln($fontSize*2);
	$pdf->Cell(0,$fontSize,"Nama");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$rowk['nama'],0,1);
	$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"Jawatan");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$rowk['jawatan'],0,1);
	$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$rowk['Jabatan'],0,1);
	$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"No. Telefon");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$rowk['telefon'],0,1);
	$pdf->SetX($x2);$pdf->Cell(0,$fontSize,chr(32));$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$rowk['handphone'],0,1);
}

$qry = "SELECT pengguna.nama,pengguna.jawatan,pengguna.telefon,pengguna.handphone from parlimen_agensi
LEFT JOIN konfigurasi ON konfigurasi.butiran = parlimen_agensi.Jabatan
LEFT JOIN pengguna ON konfigurasi.butiran2 = pengguna.Jawatan
WHERE parlimen_agensi.PId = '$id'";

$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$pdf->Ln($fontSize*3);
$pdf->Cell(0,$fontSize,"Disemak oleh,",0,1);
$pdf->Ln($fontSize*2);
$pdf->Cell(0,$fontSize,"Nama");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$row['Nama'],0,1);
$jawatan = $row['Jawatan']=='TKSU(W)'?"Timbalan Ketua Setiausaha (Warisan)":"Timbalan Ketua Setiausaha (Kebudayaan)";
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"Jawatan");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$jawatan,0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"No. Telefon");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+5);$pdf->Cell(0,$fontSize,$row['Telefon']."\n".$row['Handphone'],0,1);

$qry = "SELECT * FROM pengguna WHERE Jawatan='KSP'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$pdf->Ln($fontSize*3);
$pdf->Cell(0,$fontSize,"Dipersetujui oleh,",0,1);
$pdf->Ln($fontSize*5);
$pdf->Cell(0,$fontSize,$row['Nama'],0,1);
$pdf->Cell(0,$fontSize,"Ketua Setiausaha",0,1);
$pdf->Cell(0,$fontSize,"Kementerian Kebudayaan Kesenian Dan Warisan");

$pdf->Output();
?>