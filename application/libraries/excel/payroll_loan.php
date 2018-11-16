<?php
	/*Database Connection*/

	
	/*include PHPExcel library*/
	require("PHPExcel/PHPExcel.php");
	require("PHPExcel/PHPExcel/Calculation.php");
	require("PHPExcel/PHPExcel/Cell.php");

function PHPExcel_LoanLedger($loans, $payrolls){


	$filePath = base_path() .'/libraries/excel/loan_ledger.xls';
	$objPHPExcel = PHPExcel_IOFactory::load($filePath);
	// fill with data
	$template = PHPExcel_IOFactory::load($filePath);
	//$objPHPExcel->addExternalSheet($newSheet);

		
	if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set('UTC');
	} else {
			putenv("TZ=UTC");
	}
	
	$loan_id = 0;
	
	foreach ($loans as $loan){
		try {
			$loan_id = $loan->loan_id;
			$objPHPExcel->getActiveSheet()->SetCellValue('B6', $loan->employee_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('H6', $loan->loan_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B7', number_format($loan->loan_amount,2) );
			$objPHPExcel->getActiveSheet()->SetCellValue('H7',  number_format($loan->amortization,2) );
			$objPHPExcel->getActiveSheet()->SetCellValue('B8', $loan->date_deduct_start);
			$objPHPExcel->getActiveSheet()->SetCellValue('H8',  number_format($loan->loan_balance,2) );
			$objPHPExcel->getActiveSheet()->SetCellValue('B9', $loan->date_deduct_end);
		} catch (\Exception $e) {
				die("Error saving new excel : " . $e->getMessage());
		}
	}
	$num = 1;
	$row = 13;
	$total_row = count($payrolls);
	$total_deduction = 0;

	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,$total_row); 

	foreach ($payrolls as $p){
		try {
			$row_col_num = "A".$row;
			$row_col_descriptin = "B".$row;
			$row_col_deduction = "F".$row;
			$row_col_year = "H".$row;
			$row_col_month = "I".$row;

			$merge_description = $row_col_descriptin . ":E".$row;
			$objPHPExcel -> getActiveSheet() -> mergeCells($merge_description);

			$merge_deduction = $row_col_deduction . ":G".$row;
			$objPHPExcel -> getActiveSheet() -> mergeCells($merge_deduction);

			$objPHPExcel->getActiveSheet()->SetCellValue($row_col_num, $num);
			$objPHPExcel->getActiveSheet()->SetCellValue($row_col_descriptin, DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('description') );
			
			$objPHPExcel->getActiveSheet()->SetCellValue($row_col_year, $p->fsyear );
			$objPHPExcel->getActiveSheet()->SetCellValue($row_col_month, $p->fsmonth );

			if ($loan_id ==1) { 
				$deduction = number_format( $p->loan_1,2)  ;
				$total_deduction = $total_deduction + $p->loan_1;
			}elseif ($loan_id ==2)  {
				$deduction = number_format($p->loan_2,2)  ;
				$total_deduction = $total_deduction + $p->loan_2;
			}elseif ($loan_id ==3)  {
				$deduction = number_format($p->loan_3,2)  ;
				$total_deduction = $total_deduction + $p->loan_3;
			}elseif ($loan_id ==4)  {
				$deduction = number_format($p->loan_4,2)  ;
				$total_deduction = $total_deduction + $p->loan_4;
			}elseif ($loan_id ==5)  {
				$deduction = number_format($p->loan_5,2)  ;
				$total_deduction = $total_deduction + $p->loan_5;
			}elseif ($loan_id ==6)  {
				$deduction = number_format($p->loan_6,2)  ;
				$total_deduction = $total_deduction + $p->loan_6;
			}elseif ($loan_id ==7)  {
				$deduction = number_format($p->loan_7,2)  ;
				$total_deduction = $total_deduction + $p->loan_7;
			}elseif ($loan_id ==8)  {
				$deduction = number_format($p->loan_8,2)  ;
				$total_deduction = $total_deduction + $p->loan_8;
			}elseif ($loan_id ==9)  {
				$deduction = number_format($p->loan_9,2)  ;
				$total_deduction = $total_deduction + $p->loan_9;
			}elseif ($loan_id ==10)  {
				$deduction = number_format($p->loan_10,2)  ;
				$total_deduction = $total_deduction + $p->loan_10;
			}elseif ($loan_id ==11)  {
				$deduction = number_format($p->loan_11,2)  ;
				$total_deduction = $total_deduction + $p->loan_11;
			}elseif ($loan_id ==12)  {
				$deduction = number_format($p->loan_12,2)  ;
				$total_deduction = $total_deduction + $p->loan_12;
			}elseif ($loan_id ==13)  {
				$deduction = number_format($p->loan_13,2)  ;
				$total_deduction = $total_deduction + $p->loan_13;
			}elseif ($loan_id ==14)  {
				$deduction = number_format($p->loan_14,2)  ;
				$total_deduction = $total_deduction + $p->loan_14;
			}elseif ($loan_id ==15)  {
				$deduction = number_format($p->loan_15,2)  ;
				$total_deduction = $total_deduction + $p->loan_15;
			}elseif ($loan_id ==16)  {
				$deduction = number_format($p->loan_16,2)  ;
				$total_deduction = $total_deduction + $p->loan_16;
			}elseif ($loan_id ==17)  {
				$deduction = number_format($p->loan_17,2)  ;
				$total_deduction = $total_deduction + $p->loan_17;
			}elseif ($loan_id ==18)  {
				$deduction = number_format($p->loan_18,2)  ;
				$total_deduction = $total_deduction + $p->loan_18;
			}elseif ($loan_id ==19)  {
				$deduction = number_format($p->loan_19,2)  ;
				$total_deduction = $total_deduction + $p->loan_19;
			}elseif ($loan_id ==20)  {
				$deduction = number_format($p->loan_20,2) ;
				$total_deduction = $total_deduction + $p->loan_20;
			}else{
				$deduction = "";
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($row_col_deduction, $deduction  );

			
		} catch (\Exception $e) {
				die("Error saving new excel : " . $e->getMessage());
		}
	$row++;
	$num++;
	}

	$last_row = 13 + $total_row;
	$merge_description = "B".$last_row  . ":E".$last_row;
	$objPHPExcel -> getActiveSheet() -> mergeCells($merge_description);

	$merge_deduction = "F" .$last_row . ":G". $last_row ;
	$objPHPExcel -> getActiveSheet() -> mergeCells($merge_deduction);

	$end_row = 14 + $total_row;
	$row_col_total_label = "B". $end_row;
	$objPHPExcel->getActiveSheet()->SetCellValue($row_col_total_label, "Total Deduction: (".$total_row.")"  );
	$row_col_total_value = "F". $end_row;
	$objPHPExcel->getActiveSheet()->SetCellValue($row_col_total_value, number_format($total_deduction,2)  );

	$filename = $loan->employee_name . " - " . $loan->loan_name . " - " . date("Y-m-d-H-i-s").".xlsx";
	header('Content-Type: application/vnd.ms-excel'); 
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0'); 
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
	
	
}
	
?>