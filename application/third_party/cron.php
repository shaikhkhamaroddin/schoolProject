<?php

//$age=array(
//		   "0"=>"2016-05-31 16:04:39",
//		   "1"=>"2016-05-31 16:04:45"
//		   );
//arsort($age);
//echo '<pre>';print_r($age);die();
ini_set('memory_limit','2000M');
ob_start();

$path = realpath($_SERVER["DOCUMENT_ROOT"]).'/';

require_once ($path.'phpexcel/Classes/PHPExcel.php');
require_once ($path.'phpexcel/Classes/PHPExcel/IOFactory.php');
require_once ($path.'phpexcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php');

function createexcelreport($casearr = NULL,$flname = NULL)
{
	if(!empty($casearr))
	{
		
		$details = current($casearr);
		//echo '<pre>';print_r($details);die();
		arsort($casearr['sendclientdate']);
		arsort($casearr['caseclosedate']);
		
		$latestdate1 = current($casearr['sendclientdate']);
		$latestdate2 = current($casearr['caseclosedate']);
		
		if($latestdate1!="")
		$latestdate1 = date('d-m-Y H:i:s',strtotime($latestdate1));
		
		if($latestdate2!="")
		$latestdate2 = date('d-m-Y H:i:s',strtotime($latestdate2));
		
		$objPHPexcel = PHPExcel_IOFactory::load($path.'test_layout.xlsx');
		$objWorksheet1 = $objPHPexcel->getActiveSheet();
				
		$objPHPexcel->getSecurity()->setLockWindows(true);
		$objPHPexcel->getSecurity()->setLockStructure(true);
		$objPHPexcel->getSecurity()->setWorkbookPassword("PHPExcel");
		
		$objWorksheet1->getStyle('A1:E999')->getAlignment()->setWrapText(true); 
		$objWorksheet1->getStyle('A1:E999')->getFont()->setName('Times New Roman')->setSize(11);
		//for display text in one line
		//$styleArray = array('alignment' => array('rotation' => -165,), );
		$border=array(
			'borders' => array(),		
		);
		$border_alignment=array(
			'borders' => array(),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					),
			'font' => array('bold' => true)
		);
		$row_counter=5;
		$column_counter=0;
		$error_arr=array();
		
		$gdImage = imagecreatefromjpeg($path.'images/HBD logo.jpg');
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setHeight(50);
		//$objDrawing->setWidth(100);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPexcel->getActiveSheet());
		
		$objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "RIC REPORT FOR HDB FINANCIAL SERVICES LTD");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "DOCUMENT PICK UP DATE");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $latestdate2);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "REPORT SUBMISSION DATE");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $latestdate1);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$row_counter++;
		$objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
		
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "BRANCH & CUSTOMER DETAILS");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "LOCATION");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $details["field80"]);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "BRANCH NAME");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $details["branch_name"]);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "CUSTOMER NAME");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $details["applicants_name"]);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "LOS ID");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $details["ref_no"]);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "PRODUCT");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $details["product_id"]);
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		$row_counter++;
		
		$vt_arr = array(22,25,57);
		foreach($vt_arr as $l=>$m)
		{
		  foreach($casearr as $k=>$v)
		  {
			if($v['hbd_vt_id']==22 && $m==22)
			{
			  $objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, $k);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "AS PER DOCUMENTS PROVIDED BY HDB");
			  $objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, "AS PER BANK RECORD");
			  $objWorksheet1->getColumnDimension(chr(67+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "BANK NAME");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["issuing_bank"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["issuing_bank"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "BRANCH NAME");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field99"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field99"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "ACCOUNT HOLDER NAME");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["applicants_name"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["applicants_name"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "ACCOUNT TYPE");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "ACCOUNT NUMBER");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["card_no"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["card_no"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "TRANSACTION AMOUNT & DATE");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "BALANCE IN ACCOUNT AS ON VERIFICATION DATE");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);			  
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "STATUS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["case_result"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "REMARKS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["remarks"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $row_counter++;
			  
			  unset($casearr[$k]);
			}  
			if($v['hbd_vt_id']==25 && $m==25)
			{
			  $objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, $k);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "AS PER DOCUMENTS PROVIDED BY HDB");
			  $objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, "AS PER IT DEPARTMENT RECORD");
			  $objWorksheet1->getColumnDimension(chr(67+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NAME OF ASSESE");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["applicants_name"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["applicants_name"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "ASSESEMENT YEAR");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["1st_outcome"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["1st_outcome"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "INCOME ON ITR");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field1"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field1"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "WARD & CIRCLE NUMBER");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "DATE OF FILING");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "STATUS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["case_result"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "REMARKS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["remarks"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $row_counter++;
			  
			  unset($casearr[$k]);
			}
			if($v['hbd_vt_id']==57 && $m==57)
			{
			  $objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, $k);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "AS PER DOCUMENTS PROVIDED BY HDB");
			  $objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, "AS PER IT DEPARTMENT RECORD");
			  $objWorksheet1->getColumnDimension(chr(67+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NAME OF FIRM/COMPANY");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["name_of_the_company"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field22"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "FINANCIAL YEAR");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field13"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field21"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "GROSS PROFIT");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field12"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field24"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NET PROFIT");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field14"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field23"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "DEPRECIATION");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field15"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field25"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "SALE AMOUNT");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field17"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field26"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "SECURED LOANS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["field16"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, $v["field28"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "STATUS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["case_result"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "REMARKS");
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
			  
			  $objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, $v["remarks"]);
			  $objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
			  $objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
			  $row_counter++;
			  $row_counter++;
			  
			  unset($casearr[$k]);
			}
		  }
		}
		
		//************** Last Part in Report ********************************************************//
		$objWorksheet1->mergeCellsByColumnAndRow($column_counter,$row_counter,$column_counter+2,$row_counter);
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "OTHER DOCUMENTS VERIFICATION REPORT");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border_alignment);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "AS PER DOCUMENTS PROVIDED BY HDB");
		$objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+2, $row_counter, "AS PER DEPARTMENT RECORD");
		$objWorksheet1->getColumnDimension(chr(67+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+2, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NAME OF DOCUMENT");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "STATUS");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "POSITIVE/NEGATIVE/REFFER/FAKE/CNV");
		$objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "REMARKS");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$row_counter++;
		$row_counter++;
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "FINAL STATUS");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter+1, $row_counter, "POSITIVE/NEGATIVE/REFFER/FAKE/CNV");
		$objWorksheet1->getColumnDimension(chr(66+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter+1, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NAME OF AGENCY");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "NAME OF PROP/PART/DIR OF COMPANY");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		$row_counter++;
		$row_counter++;
		$row_counter++;
		$row_counter++;
		
		$objWorksheet1->setCellValueByColumnAndRow($column_counter, $row_counter, "SIGN & STAMP");
		$objWorksheet1->getColumnDimension(chr(65+$column_counter))->setWidth(30);
		$objWorksheet1->getStyleByColumnAndRow($column_counter, $row_counter)->applyFromArray($border);
		
		//************** End Of Last Part in Report ********************************************************//
		$dir=realpath($_SERVER["DOCUMENT_ROOT"])."/zip_files/";
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save($flname.'.xlsx');//
		$objPHPexcel->disconnectWorksheets();
		//$objWriter->close();
		unset($objWorksheet1);
	}
}
?>
