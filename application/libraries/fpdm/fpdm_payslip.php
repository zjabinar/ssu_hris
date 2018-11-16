<?php

/***************************
  Sample using a PHP array
****************************/

require('fpdm.php');

function PDF_Payslip($mployee,$file,$filename) {

    	$pdf = new FPDM($file);
	$pdf->Load($mployee, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
	$pdf->Merge();
	$pdf->Output('D',$filename);
    	return true;
}

function chk_isdbnull_double($val){
        try {
            $tmp = floatval($val);
            if ($tmp>0){
                return number_format($val,2);
            }else{
                return "";
            }
        
        } catch (Exception $e) {
           return "";
        }
    }

?>
