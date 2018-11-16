<?php
	/*Database Connection*/
	include("dbconnection.php");
	
	/*include PHPExcel library*/
	require("PHPExcel/PHPExcel.php");
	require("PHPExcel/PHPExcel/Calculation.php");
	require("PHPExcel/PHPExcel/Cell.php");

    $objPHPExcel = new PHPExcel();

	//Activate work sheet
    $objPHPExcel->createSheet(0);
    $objPHPExcel->setActiveSheetIndex(0);
	//work sheet name
    $objPHPExcel->getActiveSheet()->setTitle('Protected Unprotected');	
	/*Default Font Set*/
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	/*Default Font Size Set*/
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 
	
	/*Border color*/									
    $styleThinBlackBorderOutline = array('borders' => array('outline'=> array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '5a5a5a'))));

	$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Protected and Unprotected on Cells');
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont();
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '14', 'bold' => true)), 'A2');
	$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel -> getActiveSheet() -> getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	/*merge Cell*/
	$objPHPExcel -> getActiveSheet() -> mergeCells('A2:H2');
	
	/*Fill Color Change function for Cells*/
	cellColor('A1:H3', 'd9e1ec');
	cellColor('A4:H5', '9ab1d1');
	
	/*Start of Column Merge*/
	/*Value Set for Cells*/
    $objPHPExcel->getActiveSheet()				
					->SetCellValue('A4', 'Protected Cell')	
					->SetCellValue('C4', 'Unprotected Cell')									
					->SetCellValue('E4', 'Protected Cell');	
					
	/*Font Size for Cells*/
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'A4');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'C4');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'E4');
	
	/*Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)*/
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	/*Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)*/
	$objPHPExcel -> getActiveSheet() -> getStyle('A4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel -> getActiveSheet() -> getStyle('C4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel -> getActiveSheet() -> getStyle('E4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	/*Width for Cells*/
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(40);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(40);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(40);
	
	/*Wrap text*/
	$objPHPExcel->getActiveSheet()->getDefaultStyle('A4')->getAlignment()->setWrapText(true);

	/*border color set for cells*/
	$objPHPExcel -> getActiveSheet() -> getStyle('A4:B4') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('C4:D4') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('E4:H4') -> applyFromArray($styleThinBlackBorderOutline);
	
	$objPHPExcel->getActiveSheet()-> getStyle('A4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('C4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('E4')->getFont()->setBold(true);
	
	/*merge Cell*/
	$objPHPExcel -> getActiveSheet() -> mergeCells('A4:B4');
	$objPHPExcel -> getActiveSheet() -> mergeCells('C4:D4');
	$objPHPExcel -> getActiveSheet() -> mergeCells('E4:H4');
	/*end of Column Merge*/
	
	/*Value Set for Cells*/
    $objPHPExcel->getActiveSheet()				
					->SetCellValue('A5', '#')							
					->SetCellValue('B5', 'Cell1')
					->SetCellValue('C5', 'Cell2')							
					->SetCellValue('D5', 'Cell3')							
					->SetCellValue('E5', '(Cell2*Cell3)')							
					->SetCellValue('F5', '(Cell2+Cell3)')														
					->SetCellValue('G5', '(Cell2-Cell3)')
					->SetCellValue('H5', '(Cell2/Cell3)');
					
	/*Font Size for Cells*/
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'A5');	
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'B5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'C5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'D5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'E5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'F5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'G5');
	$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'H5');
	
	/*Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)*/
	$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	/*Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)*/
	$objPHPExcel -> getActiveSheet() -> getStyle('A5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel -> getActiveSheet() -> getStyle('B5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel -> getActiveSheet() -> getStyle('C5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel -> getActiveSheet() -> getStyle('D5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel -> getActiveSheet() -> getStyle('E5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel -> getActiveSheet() -> getStyle('F5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel -> getActiveSheet() -> getStyle('G5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel -> getActiveSheet() -> getStyle('H5') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	
	/*Width for Cells*/
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(5);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(35);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(20);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(20);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(20);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(20);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(20);
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(20);
	
	/*border color set for cells*/
	$objPHPExcel -> getActiveSheet() -> getStyle('A5:A5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('B5:B5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('C5:C5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('D5:D5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('E5:E5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('F5:F5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('G5:G5') -> applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel -> getActiveSheet() -> getStyle('H5:H5') -> applyFromArray($styleThinBlackBorderOutline);
	
	$objPHPExcel->getActiveSheet()-> getStyle('A5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('B5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('C5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('D5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('E5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('F5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('G5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()-> getStyle('H5')->getFont()->setBold(true);
	
	/*sql*/
	$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
	FROM excelexport ORDER BY ItemName;";
	$result = mysqli_query($conn, $sql);

	$i=1; 
	$j=6;
	while ($aRow = mysqli_fetch_array($result)) {

			/*Value Set for Cells*/
			$objPHPExcel->getActiveSheet()
								->SetCellValue('A'.$j, $i)							
								->SetCellValue('B'.$j, $aRow['ItemName'])	
								->SetCellValue('C'.$j, $aRow['Price'])																
								->SetCellValue('D'.$j, $aRow['Quantity'])																
								->SetCellValue('E'.$j, '')															
								->SetCellValue('F'.$j, '')																
								->SetCellValue('G'.$j, '')
								->SetCellValue('H'.$j, '');
								
			/*border color set for cells*/	
			$objPHPExcel -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('D' . $j . ':D' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('E' . $j . ':E' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('F' . $j . ':F' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('G' . $j . ':G' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('H' . $j . ':H' . $j) -> applyFromArray($styleThinBlackBorderOutline);
			
			/*Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)*/
			$objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			/*Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)*/
			$objPHPExcel -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
			$objPHPExcel -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel -> getActiveSheet() -> getStyle('D' . $j . ':D' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
			$objPHPExcel -> getActiveSheet() -> getStyle('E' . $j . ':E' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
			$objPHPExcel -> getActiveSheet() -> getStyle('F' . $j . ':F' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
			$objPHPExcel -> getActiveSheet() -> getStyle('G' . $j . ':G' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel -> getActiveSheet() -> getStyle('H' . $j . ':H' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			/* Data Validation for Column C */
			$objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $j)->getDataValidation();
			$objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_WHOLE);
			$objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
			$objValidation->setAllowBlank(true);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setErrorTitle('Input error');
			$objValidation->setError('Only Number is permitted!'); 			
			
			/* Data Validation for Column D */
			$objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $j)->getDataValidation();
			$objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_WHOLE);
			$objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
			$objValidation->setAllowBlank(true);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setErrorTitle('Input error');
			$objValidation->setError('Only Number is permitted!'); 
			
			/* Calculated Multiplication */
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$j, "=C$j*D$j");
			
			/* Calculated Addition */
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$j, "=C$j+D$j");
			
			/* Calculated Subtraction */
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$j, "=C$j-D$j");
			
			/* Calculated Division */
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$j, "=C$j/D$j");
			
			/*Number format for cell C*/
			$objPHPExcel->getActiveSheet()->getStyle('C'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$j)->getNumberFormat()->setFormatCode('#,##0');			
			
			/*Number format for cell D*/
			$objPHPExcel->getActiveSheet()->getStyle('D'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$j)->getNumberFormat()->setFormatCode('#,##0');			
			
			/*Number format for cell E*/
			$objPHPExcel->getActiveSheet()->getStyle('E'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$j)->getNumberFormat()->setFormatCode('#,##0');
			
			/*Number format for cell F*/
			$objPHPExcel->getActiveSheet()->getStyle('F'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$j)->getNumberFormat()->setFormatCode('#,##0');
			
			/*Number format for cell G*/
			$objPHPExcel->getActiveSheet()->getStyle('G'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$j)->getNumberFormat()->setFormatCode('#,##0');	
			
			/*Number format for cell H*/
			$objPHPExcel->getActiveSheet()->getStyle('H'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$j)->getNumberFormat()->setFormatCode('#,##0.00');
			
			/*Protected the Cell Range*/
			$objPHPExcel->getActiveSheet()->protectCells('A1:H5', 'PHP');			
			$objPHPExcel->getActiveSheet()->protectCells('A'.$j.':B'.$j, 'PHP');
			$objPHPExcel->getActiveSheet()->protectCells('E'.$j.':H'.$j, 'PHP');
			
			/*Unprotected the Cell Range*/
			$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':D'.$j)->getProtection()
				->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
			
			if ($j % 2 == 0) {
				cellColor('A'.$j.':H'.$j, 'f4f8fb');
			}
			
		$i++; $j++;
				
	}
	
	/*Protection the Worksheet*/
	$objPHPExcel->getActiveSheet()->getProtection()->setPassword('PHPExcel');
	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
		
	if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set('UTC');
	} else {
			putenv("TZ=UTC");
	}
	
	$exportTime = date("Y-m-d-His", time()); 
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);	
	$file = 'protected-and-unprotected-on-cells-'.$exportTime. '.xlsx'; //Save file name
	$objWriter -> save(str_replace('.php', '.xlsx', 'media/' . $file)); 
	header('Location:media/' . $file); //File open location
	
	function cellColor($cells, $color) {
		global $objPHPExcel;

		$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => $color
			)
		));
	}
?>