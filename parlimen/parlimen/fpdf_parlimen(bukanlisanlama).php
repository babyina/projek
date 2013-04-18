<?php
session_cache_limiter('public');
session_start();

if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}
	
function findHari($mysql_date){
	if($mysql_date == "0000-00-00") return "";
	$mysql_date = 2005-05-05;
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

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////

class PDF extends FPDF
{
//variables of html parser
var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;


 function RoundedRect($x, $y, $w, $h,$r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

function PDF($orientation='P',$unit='mm',$format='A4')
{
    //Call parent constructor
    $this->FPDF($orientation,$unit,$format);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';

    $this->tableborder=0;
    $this->tdbegin=false;
    $this->tdwidth=0;
    $this->tdheight=0;
    $this->tdalign="L";
    $this->tdbgcolor=false;

    $this->oldx=0;
    $this->oldy=0;

    $this->fontlist=array("arial","times","courier","helvetica","symbol");
    $this->issetfont=false;
    $this->issetcolor=false;
}

//////////////////////////////////////
//html parser

function WriteHTML($html)
{
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
    $html=str_replace("\n",'',$html); //replace carriage returns by spaces
    $html=str_replace("\t",'',$html); //replace carriage returns by spaces
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explodes the string
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            elseif($this->tdbegin) {
                if(trim($e)!='' and $e!="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
                elseif($e=="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
            }
            else
                $this->Write(22,stripslashes(txtentities($e)));
        }
        else
        {
            //Tag

            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{
    //Opening tag
    switch($tag){

        case 'SUP':
            if($attr['SUP'] != '') {    
                //Set current font to: Bold, 6pt     
                $this->SetFont('','',6);
                //Start 125cm plus width of cell to the right of left margin         
                //Superscript "1"
                $this->Cell(2,2,$attr['SUP'],0,0,'L');
            }
            break;

        case 'TABLE': // TABLE-BEGIN
            if( $attr['BORDER'] != '' ) $this->tableborder=$attr['BORDER'];
            else $this->tableborder=0;
            break;
        case 'TR': //TR-BEGIN
            break;
        case 'TD': // TD-BEGIN
            if( $attr['WIDTH'] != '' ) $this->tdwidth=($attr['WIDTH']/4);
            else $this->tdwidth=40; // SET to your own width if you need bigger fixed cells
            if( $attr['HEIGHT'] != '') $this->tdheight=($attr['HEIGHT']/6);
            else $this->tdheight=6; // SET to your own height if you need bigger fixed cells
            if( $attr['ALIGN'] != '' ) {
                $align=$attr['ALIGN'];        
                if($align=="LEFT") $this->tdalign="L";
                if($align=="CENTER") $this->tdalign="C";
                if($align=="RIGHT") $this->tdalign="R";
            }
            else $this->tdalign="L"; // SET to your own
            if( $attr['BGCOLOR'] != '' ) {
                $coul=hex2dec($attr['BGCOLOR']);
                    $this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
                    $this->tdbgcolor=true;
                }
            $this->tdbegin=true;
            break;

        case 'HR':
            if( $attr['WIDTH'] != '' )
                $Width = $attr['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.2);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            break;
        case 'STRONG':
            $this->SetStyle('B',true);
            break;
        case 'EM':
            $this->SetStyle('I',true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        //case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) and $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist) and isset($attr['SIZE']) and $attr['SIZE']!='') {
                $this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='SUP') {
    }

    if($tag=='TD') { // TD-END
        $this->tdbegin=false;
        $this->tdwidth=0;
        $this->tdheight=0;
        $this->tdalign="L";
        $this->tdbgcolor=false;
    }
    if($tag=='TR') { // TR-END
        $this->Ln();
    }
    if($tag=='TABLE') { // TABLE-END
        //$this->Ln();
        $this->tableborder=0;
    }

    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag,$enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

//Page header
function Header()
{
    //Logo
   // $this->Image('../../images/logo_kementerian.png',95,25,25,25,PNG);
	//$this->Image('../../images/frame_keputusan_1.png',10,60,230,250,PNG);
	//$this->Image('../../images/frame_keputusan1.png',20,80,168,100	,PNG);
	//$this->Image('../../images/frame_keputusan3.png',22,170,168,100	,PNG);
}

// multicell with maxline

function MultiCell($w,$h,$txt,$border=0,$align='J',$fill=0,$maxline=0)
    {
        //Output text with automatic or explicit line breaks, maximum of $maxlines
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border and $nl==2)
                    $b=$b2;
                if ( $maxline  && $nl > $maxline ) 
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
                    }
                    $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border and $nl==2)
                    $b=$b2;
                if ( $maxline  && $nl > $maxline ) 
                    return substr($s,$i);
            }
            else
                $i++;
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        if($border and is_int(strpos($border,'B')))
            $b.='B';
        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        $this->x=$this->lMargin;
        return '';
    }

}//end of class


//-----------------mysql ---------------
$id = $_POST['id'];
$qry = "SELECT * FROM parlimen WHERE id='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
$rows = mysql_fetch_array($result);
$ahli_parlimen = $rows['ahli_dewan_id'];
$sesi_dewan = strtoupper(($row['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara");
$parlimen = strtoupper($rows['parlimen']);
$penggal = strtoupper($rows['penggal']);
$mesyuarat = strtoupper($rows['mesyuarat']);
$created_by = $rows['created_by'];
$created_on = $rows['created_on'];
$no_soalan = $rows['no_soalan'];

$qry2 = "SELECT nama FROM ahli_parlimen WHERE id='$ahli_parlimen'";
$result2 = mysql_query($qry2,$conn) or die(mysql_error());
$row2 = mysql_fetch_array($result2);
$ahli_parlimen = $row2['nama'];
$korperat_jawapan = $rows['korperat_jawapan'];

//$korperat_jawapan = strip_tags($rows['korperat_jawapan']);
//$korperat_jawapan = str_replace("<strong>"," ",$korperat_jawapan);
//echo $korperat_jawapan;
//str_replace("\r",'',$txt);

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
$pdf->SetFont('Arial','B',$fontSize);
$pdf->MultiCell(0,0,$sesi_dewan." YANG ".$parlimen.", PENGGAL ".$penggal,0,'C');
$pdf->Ln($fontSize);
$pdf->MultiCell(0,0,"MESYUARAT ".$mesyuarat,0,'C');
$pdf->Ln($fontSize*3);
$pdf->MultiCell(0,0," ",0,'C');
$pdf->SetFont('Arial','BU',$fontSize);
$pdf->MultiCell(0,0,"PERTANYAAAN BUKAN JAWAB LISAN",0,'C');
$pdf->Ln($fontSize*3);
$pdf->SetFont('Arial','B',$fontSize);

$pdf->Ln($fontSize*2);
$pdf->Cell(0,$fontSize,"SOALAN");
$pdf->SetX($x2); $pdf->Cell(0,$fontSize,":");
$pdf->Ln($fontSize*2.5);
//$pdf->Ln($fontSize*0.5);
$soalan = $rows['soalan'];
$jawapan = $rows['korperat_jawapan'];
$pdf->WriteHTML($soalan);
	
$pdf->AddPage();
$pdf->SetFont('Arial','B',$fontSize);
$pdf->Ln($fontSize*2);
$pdf->Cell(0,$fontSize*1.5, "JAWAPAN :",0,1);
	
$pdf->WriteHTML($jawapan);

$pdf->SetFont('Arial','B',$fontSize);

$pdf->AddPage();
$pdf->Ln($fontSize*5);
//$korperat_nama = $rows['korperat_nama'];
$qry = "SELECT * FROM pengguna WHERE Nama='$created_by'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);

$temp = ((empty($row['telefon']))?" ":", ");

$pdf->Cell(0,$fontSize,"DISEDIAKAN OLEH");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$created_by,0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"JAWATAN");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['jawatan'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"NO. TELEFON");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['telefon'].$temp." ".$row['handphone'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"TARIKH");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,DisplayDateTime($created_on),0,1);

$pdf->Ln($fontSize*5);
$pengurusan_nama = $rows['pengurusan_nama'];
$qry = "SELECT * FROM pengguna WHERE Nama='$pengurusan_nama'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$temp = ((empty($row['telefon']))?" ":", ");

$pdf->Cell(0,$fontSize,"DIPERAKUKAN OLEH");$pdf->SetX($x2+15);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+25);$pdf->Cell(0,$fontSize,$pengurusan_nama,0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"JAWATAN");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['jawatan'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"NO. TELEFON");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['telefon'].$temp." ".$row['handphone'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"TARIKH");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,Reverse($rows['pengurusan_tarikh']),0,1);

$pdf->Ln($fontSize*5);
$pengesahan_nama = $rows['pengesahan_nama'];
$qry = "SELECT * FROM pengguna WHERE Nama='$pengesahan_nama'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);
$temp = ((empty($row['telefon']))?" ":", ");

$pdf->Cell(0,$fontSize,"DILULUSKAN OLEH");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$pengesahan_nama,0,1);
$jawatan = $rows['pengesahan_jawatan'];
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"JAWATAN");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['jawatan'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"NO. TELEFON");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,$row['telefon'].$temp." ".$row['handphone'],0,1);
$pdf->Ln($fontSize);$pdf->Cell(0,$fontSize,"TARIKH");$pdf->SetX($x2);$pdf->Cell(0,$fontSize,":");$pdf->SetX($x2+10);$pdf->Cell(0,$fontSize,Reverse($rows['pengesahan_tarikh']),0,1);

$pdf->Output();
?>