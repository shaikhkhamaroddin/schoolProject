<?php ini_set('memory_limit','200M');
//============================================================+
// File name   : example_001.php

//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/tcpdf_6_2_12/examples/lang/eng.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'./tcpdf_6_2_12/tcpdf.php');
//ob_start();

function sample($g,$p,$module,$page_header,$page_footer)
{
       $PDF_DATA = $g;
$newFile  = $p;
//echo $PDF_DATA;die();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('helvetica', '', 12, '', true);

//set password to PDF
if(@$pass!="")
$pdf->SetProtection(NULL, $user_pass=$pass, $owner_pass=null, $mode=0, $pubkeys=null);
// add a page
$pdf->AddPage();

//$pdfTempArr[0]['pdfexportdesign_format'];
//$pdf->Image($LOGO_IMAGE, '', '',$LOGO_WIDTH, $LOGO_HEIGHT, $LOGO_TYPE, '', 'R', false, 300, '', false, false, 0, false, false, false);
//echo $pdfTempArr[0]['pdfexportdesign_format'];//die();
$tb1 = <<<EOD
<p>$PDF_DATA</p>
EOD;

$pdf->writeHTML($tb1, true, false, false, false, '');
$js = <<<EOD
function openw(url) {
    app.window.open(url,"PDF");
}
EOD;


$pdf->IncludeJS($js);
//for additional fields
if (ob_get_contents()) {
ob_end_clean();
}
$pdf->Output($newFile,'I');
//$pdf->Output(realpath("./uploads/application_form/")."/".$newFile,'F');


}
?>