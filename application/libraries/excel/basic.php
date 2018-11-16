<?php
	/*Database Connection*/

	
	/*include PHPExcel library*/
	require("PHPExcel/PHPExcel.php");
	require("PHPExcel/PHPExcel/Calculation.php");
	require("PHPExcel/PHPExcel/Cell.php");

function PHPExcel_ipcr($employee, $filename){

$hostname = "localhost";
$username = "root";
$password = "secret";
$dbname = "excelexport_db";
$conn = mysqli_connect($hostname,$username,$password,$dbname);
if (mysqli_connect_errno()){
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}	
mysqli_set_charset($conn, "utf8");

		    $objPHPExcel = new PHPExcel();
		
			//Activate work sheet
		    $objPHPExcel->createSheet(0);
		    $objPHPExcel->setActiveSheetIndex(0);
			//work sheet name
		    $objPHPExcel->getActiveSheet()->setTitle('Basic');	
			/*Default Font Set*/
			$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
			/*Default Font Size Set*/
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 
			
			/*Border color*/									
		    $styleThinBlackBorderOutline = array('borders' => array('outline'=> array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '5a5a5a'))));
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Basic');
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont();
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '14', 'bold' => true)), 'A2');
			$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel -> getActiveSheet() -> getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			/*merge Cell*/
			$objPHPExcel -> getActiveSheet() -> mergeCells('A2:F2');
		
			/*Value Set for Cells*/
		    $objPHPExcel->getActiveSheet()				
							->SetCellValue('A4', '#')							
							->SetCellValue('B4', 'Item Name')
							->SetCellValue('C4', 'Item Code')							
							->SetCellValue('D4', 'Date')							
							->SetCellValue('E4', 'Price')							
							->SetCellValue('F4', 'Quantity');
							
			/*Font Size for Cells*/
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'A4');	
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'B4');
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'C4');
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'D4');
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'E4');
			$objPHPExcel -> getActiveSheet() -> duplicateStyleArray(array('font' => array('size' => '12', 'bold' => true)), 'F4');
			
			/*Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)*/
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			/*Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)*/
			$objPHPExcel -> getActiveSheet() -> getStyle('A4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel -> getActiveSheet() -> getStyle('B4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel -> getActiveSheet() -> getStyle('C4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel -> getActiveSheet() -> getStyle('D4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel -> getActiveSheet() -> getStyle('E4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel -> getActiveSheet() -> getStyle('F4') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			/*Width for Cells*/
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(5);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(35);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(20);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(20);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(20);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(20);
			
			/*Wrap text*/
			$objPHPExcel->getActiveSheet()->getDefaultStyle('A5')->getAlignment()->setWrapText(true);
			//$objPHPExcel->getActiveSheet()->getStyle('B4:B4') -> getAlignment()->setWrapText(true);
		
			/*border color set for cells*/
			$objPHPExcel -> getActiveSheet() -> getStyle('A4:A4') -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('B4:B4') -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('C4:C4') -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('D4:D4') -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('E4:E4') -> applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel -> getActiveSheet() -> getStyle('F4:F4') -> applyFromArray($styleThinBlackBorderOutline);
			
			$objPHPExcel->getActiveSheet()-> getStyle('A4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()-> getStyle('B4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()-> getStyle('C4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()-> getStyle('D4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()-> getStyle('E4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()-> getStyle('F4')->getFont()->setBold(true);
			
			/*sql*/
			$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
			FROM excelexport ORDER BY ItemName;";
			$result = mysqli_query($conn, $sql);
		
			$i=1; 
			$j=5;
			while ($aRow = mysqli_fetch_array($result)) {
					/*Value Set for Cells*/
					$objPHPExcel->getActiveSheet()
										->SetCellValue('A'.$j, $i)							
										->SetCellValue('B'.$j, $aRow['ItemName'])	
										->SetCellValue('C'.$j, $aRow['ItemCode'])																
										->SetCellValue('D'.$j, $aRow['Date'])																
										->SetCellValue('E'.$j, $aRow['Price'])																
										->SetCellValue('F'.$j, $aRow['Quantity']);
										
					/*border color set for cells*/	
					$objPHPExcel -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel -> getActiveSheet() -> getStyle('D' . $j . ':D' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel -> getActiveSheet() -> getStyle('E' . $j . ':E' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel -> getActiveSheet() -> getStyle('F' . $j . ':F' . $j) -> applyFromArray($styleThinBlackBorderOutline);
					
					/*Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)*/
					$objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					/*Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)*/
					$objPHPExcel -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
					$objPHPExcel -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel -> getActiveSheet() -> getStyle('D' . $j . ':D' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);							
					$objPHPExcel -> getActiveSheet() -> getStyle('E' . $j . ':E' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
					$objPHPExcel -> getActiveSheet() -> getStyle('F' . $j . ':F' . $j) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					/*Number format Cell E*/
					$objPHPExcel->getActiveSheet()->getStyle('E'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$j)->getNumberFormat()->setFormatCode('#,##0.00');
					/*Number format Cell F*/			
					$objPHPExcel->getActiveSheet()->getStyle('F'.$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$j)->getNumberFormat()->setFormatCode('#,##0');
					
					
				$i++; $j++;
						
			}
		
			if (function_exists('date_default_timezone_set')) {
					date_default_timezone_set('UTC');
			} else {
					putenv("TZ=UTC");
			}
			
			$exportTime = date("Y-m-d-His", time()); 
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);	
			$file = $filename .'.xlsx'; //Save file name
			$objWriter -> save(str_replace('.php', '.xlsx',  $file)); 
			header('Location:media/' . $file); //File open location

}
	
?>