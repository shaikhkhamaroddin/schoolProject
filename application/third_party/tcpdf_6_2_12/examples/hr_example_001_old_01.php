<?php ini_set('memory_limit','200M');
//============================================================+
// File name   : example_001.php

define ('PDF_MARGIN_LEFT', 5);
define ('PDF_MARGIN_RIGHT', 5);
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/tcpdf_6_2_12/examples/lang/eng.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/tcpdf_6_2_12/tcpdf.php');
//ob_start();
class MyTCPDF extends TCPDF
{
	 var $htmlHeader;
	 var $htmlFooter;
	 public function setHtmlHeader($htmlHeader,$htmlFooter)
	 {
	     $this->htmlHeader = $htmlHeader;
	     $this->htmlFooter = $htmlFooter;
	 }
	 public function Header()
	 {
		  $this->writeHTMLCell(
		  $w = 0, $h = 0, $x = '', $y = '',
		  $this->htmlHeader, $border = 0, $ln = 1, $fill = 0,
		  $reseth = true, $align = 'top', $autopadding = true);
		  //ob_clean();
		  //ob_end_clean();
	 }
	 public function Footer()
	 {
		  $this->SetY(-90);
		  $this->writeHTMLCell(
		  $w = 0, $h = 0, $x = '', $y = '',
		  $this->htmlFooter, $border = 0, $ln = 1, $fill = 0,
		  $reseth = true, $align = 'top', $autopadding = true);
		 // ob_clean();
		  //ob_end_clean();
	 }
	
}
function sample($g,$p,$module,$page_header,$page_footer)
{
         $PDF_DATA = $g;
         $newFile  = $p;
	 if($module=='quotation' || @$module=='quotation_product' || @$module=='converted_invoice')
	 {
		 // define ('PDF_MARGIN_BOTTOM', 0);
		  $pdf = new MyTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		  $pdf->setHtmlHeader($page_header);
		  $pdf->SetMargins(PDF_MARGIN_LEFT, '37', PDF_MARGIN_RIGHT);
		  $pdf->SetHeaderData(NULL, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $page_header);
		  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		  $pdf->SetAutoPageBreak(TRUE,'15');
		 
	 }
	 elseif($module=='lr_bill')
	 {
		  $pdf = new MyTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		  $pdf->setHtmlHeader($page_header,$page_footer);
		  $pdf->SetMargins(PDF_MARGIN_LEFT, '40', PDF_MARGIN_RIGHT);
		  $pdf->SetHeaderData(NULL, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $page_header);
		  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		  $pdf->SetAutoPageBreak(TRUE,'90');
	 }
	 else{
		  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		  $pdf->setPrintHeader(false);
	 }
	 
	//$pdf->SetAutoPageBreak(TRUE, 30);
	// $pdf->SetY(-40);
	 // set default monospaced font
         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
         
	 
	  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
         
         $pdf->AddPage();
         $pdf->writeHTML($PDF_DATA, true, false, true, false, '');
	 //ob_clean();
	 $pdf->lastPage();
	//for additional fields
         if (ob_get_contents()) {
                  ob_end_clean();
         }
	 
         $pdf->Output($newFile,'I');
	
}
?>