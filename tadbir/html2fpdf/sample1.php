<?php
require("html2fpdf.php");

$buffer = "<html><body><b>TEST</b>normal

<table border=1 width=100%>
<tr><td>xxx</td><td>opopop</td><tr>
</table>
</body></html>";
$pdf = new HTML2FPDF('L');
$pdf->AddPage();
$pdf->WriteHTML($buffer);
$pdf->Output();
?>