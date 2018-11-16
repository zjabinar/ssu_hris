<?php

/***************************
  Sample using a PHP array
****************************/

require('fpdm.php');

function PDF_Civil_Service($mployee,$file,$filename) {
    	$pdf = new FPDM($file);
	$pdf->Load($mployee, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
	$pdf->Merge();
	$pdf->Output('D',$filename);
    	return true;
}

function chk_isdbnull($val){
	try {
	    if (isset($val)){
	        if (strlen($val)>0){
	            return $val;
	        }else{
	            return " ";
	        }
	    }else{
	        return " ";
	    }
	} catch (Exception $e) {
	    return " ";
	}
}


?>
