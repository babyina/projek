<?php
require('class_pdf.php');
include('../config.php');
require('../keyword.php');

function Hari($date){
	if($date == "0000-00-00")
		return $date = "";
	else{
		$exp = explode("-",$date);
		$get_date = date("w", mktime(0,0,0,$exp[1],$exp[2],$exp[0]));
		$hari_array = array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu");
		$date = $hari_array[$get_date];
		return $date;
	}
}

function Week($date){
 	//$date = explode("-",$date);
	//$week = date("W",mktime(0,0,0,$date[1],$date[2],$date[0]));
	$unixDate = strtotime($date);
	$week = date("W", $unixDate);
	return $week;
}

function pegawai($data,$type,$need){
	if($type == 1){
		$sql = mysql_query("SELECT namaYB, kawasan FROM kal_lapdwn_ib WHERE Kal_lapdwn_id = '$data'");
	}else{
		$sql = mysql_query("SELECT namaYB, kawasan FROM kal_lapdwn_ru WHERE Kal_lapdwn_id = '$data'");
	}
	$r = mysql_fetch_array($sql);
	
	if($need == 1)
		$data = $r[0];
	else
		$data = $r[1];
	return $data;
}

$text_array = array(
	"Jumlah soalan yang dibentangkan di dalam Dewan (Mengikut Aturan Urusan Mesyuarat.",
	"Jumlah soalan yang sempat dijawab di dalam Dewan.",
	"Adakah terdapat soalan yang ditujukan kepada Menteri Wilayah Persekutuan: Jika ada, nyatakan nombor bilangan soalan tersebut.",
	"Adakah terdapat soalan tambahan kepada soalan di (3). Jika ada, huraikan soalan dan sebutkan nama Ahli Yang Berhormat dan kawasan secara lampiran.",
	"Apakah jawapan-jawapan kepada (4) yang diberikan - huraikan secara lampiran.",
	"Adakah soalan yang ditujukan kepada Perdana Menteri atau Menteri lain tetapi ada berkaitan dengan hal ehwal Kementerian Wilayah Persekutuan. Jika ada, sebutkan nama Ahli Yang Berhormat dan kawasan. Huraikan soalan, soalan tersebut secara lampiran.",
);

$mesyuarat_id = $_GET['mesyuarat_id'];

$sql = mysql_query("SELECT SesiDewan, TarikhSidang, Hari, Sesi, PgwNama, JumSoalan, JumJawab, SahSoalanMent, BilSoalan, SahSoalanTamb, " .
		"SahSoalKaitan, SahIsuBerkaitan, sahRangUndang " . 
		"FROM kal_lapdwn WHERE Kal_lapdwn_id = '$mesyuarat_id'");
while($rows = mysql_fetch_array($sql)){
	$sesiDewan = ($rows[0] == 1)? "DEWAN NEGARA":"DEWAN RAKYAT";
	$tarikh = $rows[1];
	$hari = $rows[2];
	$sesi = $rows[3];
	$pegawai = $rows[4];
	$jumlahSoalan = $rows[5];
	$jumlahJawab = $rows[6];
	$sahSoalanMenteri = $rows[7];
	$bilSoalan = $rows[8];
	$sahSoalanTamb = $rows[9];
	$sahSoalanKaitan = $rows[10];
	$sahIsuBerkaitan = $rows[11];
	$sahRangUndang = ($rows[11] == 1)? "Ada":"Tiada";
}

//laila add here

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

$pageW = 595;
$top_margin = 60;
$fontSize = 16;

$x1 = $margin_right = $margin_left = 30;
$x2 = $x1 + 154.5;
$x3 = $x2 + 154.5;
$x4 = $x3 + 103;
//end here

$pdf = new PDF_PEGAWAI('P','cm','A4');
$pdf->AddPage();
$pdf->Cell(19,1,'',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(19,1,'LAPORAN ' . $sesiDewan,0,1,'C',0);
$pdf->SetY(3.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(1,1,'',0,0);$pdf->Cell(5,1,'TARIKH',0,0,'',0);$pdf->Cell(0.5,1,':',0,0,'C',0);$pdf->Cell(15,1,Reverse($tarikh),0,1,'',0);
$pdf->Cell(1,1,'',0,0);$pdf->Cell(5,1,'HARI',0,0,'',0);$pdf->Cell(0.5,1,':',0,0,'C',0);$pdf->Cell(15,1,$hari,0,1,'',0);
$pdf->Cell(1,1,'',0,0);$pdf->Cell(5,1,'SESI',0,0,'',0);$pdf->Cell(0.5,1,':',0,0,'C',0);$pdf->Cell(15,1,$sesi,0,1,'',0);
$pdf->Cell(1,1,'',0,0);$pdf->Cell(5,1,'PEGAWAI BERTUGAS',0,0,'',0);$pdf->Cell(0.5,1,':',0,0,'C',0);$pdf->Cell(15,1,$pegawai,0,1,'',0);
$pdf->SetY(8);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(1,1,'',0,0);
$pdf->Cell(15,1,'A. SESI JAWAPAN MULUT',0,1,'',0);
$pdf->SetFont('Arial','',10);

$i = 1;
foreach($text_array as $id=>$text){
	$pdf->Cell(1,1);
	$pdf->SetX($x+15);
	$pdf->Ln();
	$pdf->Cell(1,0.5);
	$pdf->Cell(1,0.5,$i,0,0);
	$pdf->SetX($x+3);
	$pdf->MultiCell(12,0.5,$text,0,'','L');
	$pdf->SetX($x+16);
	//if($id == 0){ $data = $jumlahSoalan; }
	//if($id == 1){ $data = $jumlahJawab; }
	//if($id == 2){ $data = $sahSoalanMenteri; }
	//if($id == 3){ $data = $bilSoalan; }
	//if($id == 4){ $data = $sahSoalanTamb; }
	//if($id == 5){ $data = $sahSoalanKaitan; }
	//if($data == 0){ $data = "Tiada"; }
	//if($data == 1){ $data = "Ada"; }
	
	if($i == 1){ $pdf->Cell(3,-1.5,$jumlahSoalan,0,'',1); }
	if($i == 2){ $pdf->Cell(3,-1.5,$jumlahJawab,0,'',1); }
	if($i == 3){
		$data = ($sahSoalanMenteri == 0)? "Tiada":"Ada , " . $bilSoalan;
		$pdf->Cell(3,-1.5,$data,0,'',1);
	}
	if($i == 4){
		$data = ($sahSoalanTamb == 0)? "Tiada":"Ada";
		$pdf->Cell(3,-1.5,$data,0,'',1);
	}
	if($i == 5){
		$data = ($sahSoalanKaitan == 0)? "Tiada":"Ada";
		$pdf->Cell(3,-1.5,$data,0,'',1);
	}
	if($i == 6){
		$data = ($sahIsuBerkaitan == 0)? "Tiada":"Ada";
		$pdf->Cell(3,-1.5,$data,0,'',1);
	}
	$i++;
}

/******* new page *********/
$pdf->AddPage();
$pdf->SetY(2);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(1,1,'',0,0);
$pdf->Cell(15,1,'B. PERBAHASAN TITAH UCAPAN / RANG UNDANG-UNDANG',0,1,'',0);
$pdf->Ln();
$pdf->SetFont('Arial','',10);

// no 1
$pdf->SetX(2);
$pdf->Cell(1,1,'1',0,0);
$pdf->SetX(3);
$pdf->MultiCell(17,0.5,'Siapakah Ahli-ahli Yang Berhormat yang membahaskan Titah Ucapan/Rang Undang-Undang dan nyatakan isu yang dibangkitkan sekirannya berkaitan dengan Kementerian Wilayah Persekutuan',0,'','L');
$pdf->Cell(15,0.5,$sahIsuBerkaitan,0,1,'C');
$pdf->SetX(2);
$pdf->Cell(1,1,'',0,0);
$pdf->Cell(10,1,'Jika ada, huraikan isu-isu tersebut secara lampiran',0,1);

// no 2
$pdf->SetX(2);
$pdf->Cell(1,1,'2',0,0);
$pdf->Cell(10,1,'Apakah Rang Undang-undang yang dibahaskan',0,1);
$sql = mysql_query("SELECT Kal_lapdwn_id,Rang1,Rang2,Rang3,Rang4 FROM kal_lapdwn WHERE Kal_lapdwn_id = '$mesyuarat_id'");
$num = mysql_num_fields($sql);
while($row = mysql_fetch_array($sql)){
	for($i = 1; $i < $num; $i++){
		$pdf->Cell(1,0.5,'',0,1);
		$pdf->Cell(2,0.5,'',0,0);
		$pdf->Cell(1,0.5,'2.'.$i,0,0);
		$pdf->Cell(5,0.5,'Rang Undang-undang',0,0);
		$pdf->MultiCell(10,0.5,$row[$i],0);
	}
}

//no 3
$pdf->SetX(2);
$pdf->Cell(1,1,'3',0,0);
$pdf->Cell(17,1,'Apakah Rang Undang-undang yang berkaitan dengan Kementerian Wilayah Persekutuan dibahaskan',0,1);
$pdf->Cell(15,0.5,$sahRangUndang,0,1,'C');
$pdf->SetX(2);
$pdf->Cell(1,1,'',0,0);
$pdf->Cell(10,1,'Jika ada, sebutkan nama Ahli Yang Berhormat dan Kawasan serta isu yang dibangkitkan',0,1);
$pdf->Cell(15,0.5,pegawai($mesyuarat_id,1,1),0,1,'C');

// no 4
$pdf->SetX(2);
$pdf->Cell(1,1,'4',0,0);
$pdf->Cell(17,1,'Keputusan perbahasan Rang Undang-undang di para 2',0,1);
$sql = mysql_query("SELECT Kal_lapdwn_id,Rang1,Rang2,Rang3,Rang4,StatusRang1,StatusRang2,StatusRang3,StatusRang4 FROM kal_lapdwn WHERE Kal_lapdwn_id = '$mesyuarat_id'");
while($row = mysql_fetch_array($sql)){
	for($i = 1; $i < 5; $i++){
		$a = $i + 4;
		$pdf->Cell(1,0.5,'',0,1);
		$pdf->Cell(2,0.5,'',0,0);
		$pdf->Cell(1,0.5,'4.'.$i,0,0);
		//$pdf->Cell(5,0.5,'Rang Undang-undang',0,0);
		//$pdf->Ln();
		//$pdf->Cell(3,0.5,'',0,0);
		//$pdf->Cell(5,0.5,$row[$a],0,0);
		//$pdf->SetX(10,8);
		//$pdf->MultiCell(10,-0.5,$row[$i],1,'L');
		$pdf->MultiCell(5,0.5,'Rang Undang-undang ' . $row[$a],0,'L');
		$pdf->SetX(10);
		$pdf->MultiCell(10,-0.5,$row[$i],0,'L');
		$pdf->Cell(3,0.5,'',0,0);
		$pdf->Cell(5,0.5,$rows[$a],0,1);
	}
}

/******** page 3 *********/
// no 5
$pdf->AddPage();
$pdf->SetY(2);
$pdf->SetX(2);
$pdf->Cell(1,1,'5',0,0);
$pdf->Cell(17,1,'Apakah Rang Undang-undang yang ditangguhkan',0,1);
$sql = mysql_query("SELECT Kal_lapdwn_id,Rang1,Rang2,Rang3,Rang4 FROM kal_lapdwn WHERE Kal_lapdwn_id = '$mesyuarat_id' AND " . 
		"(StatusRang1='Ditangguhkan' OR StatusRang2='Ditangguhkan' OR StatusRang3='Ditangguhkan' OR StatusRang4='Ditangguhkan')");
$num = mysql_num_fields($sql);
while($row = mysql_fetch_array($sql)){
	for($i = 1; $i < $num; $i++){
		$pdf->Cell(1,0.5,'',0,1);
		$pdf->Cell(2,0.5,'',0,0);
		$pdf->Cell(1,0.5,'5.'.$i,0,0);
		$pdf->Cell(5,0.5,'Rang Undang-undang',0,0);
		$pdf->MultiCell(10,0.5,$row[$i],0);
	}
}

//$pdf->SetY(4);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(1,1,'',0,0);
$pdf->Cell(2.5,1,'C. PENUTUP',0,0,'',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,1,'(Untuk diisi pegawai bertugas sesi petang)',0,1);
$pdf->SetFont('Arial','',10);

// no 1
$pdf->SetX(2);
$pdf->Cell(1,1,'1',0,0);
$pdf->Cell(8,1,'Dewan ditangguhkan pada pukul',0,1);
// no 2
$pdf->SetX(2);
$pdf->Cell(1,1,'2',0,0);
$pdf->Cell(8,1,'Persidangan akan disambung pada',0,1);
$pdf->Ln();
$pdf->SetX(2);
$pdf->Cell(7,0.5,'..................................................',0,0);
$pdf->Cell(2,0.5);
$pdf->Cell(7,0.5,'..................................................',0,1);
$pdf->SetX(2);
$pdf->Cell(7,0.5,'(                                                 )',0,0);
$pdf->Cell(2,0.5);
$pdf->Cell(7,0.5,'(                                                 )',0,1);
$pdf->SetX(2);
$pdf->Cell(7,1,'Bahagian:',0,0);
$pdf->Cell(2,1);
$pdf->Cell(7,1,'Bahagian:',0,1);
$pdf->SetX(2);
$pdf->Cell(7,1,'Tel/Sambungan:',0,0);
$pdf->Cell(2,1);
$pdf->Cell(7,1,'Tel/Sambungan:',0,1);
$pdf->SetX(2);
$pdf->Cell(7,1,'Tarikh:',0,0);
$pdf->Cell(2,1);
$pdf->Cell(7,1,'Tarikh:',0,1);
$pdf->SetX(2);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(5,1,'Peringatan',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(2);
$pdf->Cell(1,0.5,'1',0,0);
$pdf->MultiCell(15,0.5,'Pastikan kedua-dua Pegawai Bertugas Harian menurunkan tandatangan di ruangan yang disediakan',0);
$pdf->SetX(2);
$pdf->Cell(1,0.5,'2',0,0);
$pdf->MultiCell(15,0.5,'Laporan ini hendaklah dikemukakan ke Cawangan Khidmat Pengurusan Kementerian selewat-lewatnya jam 9.00 pagi keesokan harinya',0);

$pdf->Output();

?>