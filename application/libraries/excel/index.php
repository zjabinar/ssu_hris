<?php
	/*Database Connection*/
	include("dbconnection.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MySQL Data to Excel Export</title>
    <!-- favicon-->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap css-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">    
	<!-- style -->
    <link href="style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.min.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="header">
					<div class="logo"><img src="images/logo.png" /></div>
					<h2>MySQL Data to Excel Export</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="panel-area">
					<div class="panel-header">
						<div class="header-title">Export Functionalities</div>
					</div>
					<div class="panel-content">
						<ul class="nav nav-tabs nav-list">
							<li class="active"><a data-toggle="tab" href="#Basic">Basic</a></li>
							<li><a data-toggle="tab" href="#RowGrouping">Row Grouping</a></li>
							<li><a data-toggle="tab" href="#HeaderRowsColumnsMerge">Header (Rows and Columns Merge)</a></li>
							<li><a data-toggle="tab" href="#AutofilterRangeofCells">Autofilter Range of Cells</a></li>
							<li><a data-toggle="tab" href="#FormulaCalculations">Formula Calculations</a></li>
							<li><a data-toggle="tab" href="#ProtectedUnprotected">Protected and Unprotected on Cells</a></li>
						</ul>
					</div>
					
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel-area">
					<div class="tab-content">
						<div id="Basic" class="tab-pane fade in active">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Basic</h5>
									<a href="basic.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead> 
											<tr>
												<th class="txt-center" style="width:5%;">#</th>
												<th style="width:35%;">Item Name</th> 
												<th style="width:15%;">Item Code</th> 
												<th style="width:15%;">Date</th> 
												<th class="txt-right" style="width:15%;">Price</th> 
												<th class="txt-right" style="width:15%;">Quantity</th> 
											</tr> 
										</thead> 
										<tbody>
											<?php
												/*sql*/
												$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
												FROM excelexport ORDER BY ItemName;";
												$result = mysqli_query($conn, $sql);
												$i=1; 
												while ($aRow = mysqli_fetch_array($result)) {
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td> 
												<td><?php echo $aRow['ItemCode']; ?></td> 
												<td><?php echo $aRow['Date']; ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price'],2); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Quantity']); ?></td>
											</tr> 
											<?php }	?>
										</tbody> 
									</table>
								</div>
							</div>
						</div><!--end of Simple Excel Export-->

						<div id="RowGrouping" class="tab-pane fade">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Row Grouping</h5>
									<a href="row-grouping.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="txt-center" style="width:5%;">#</th>
												<th style="width:35%;">Item Name</th> 
												<th style="width:20%;">Item Code</th> 
												<th class="txt-right" style="width:20%;">Price</th> 
												<th class="txt-right" style="width:20%;">Quantity</th>  
											</tr>
										</thead>
										<tbody>
											<?php
											/*sql*/
											$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity FROM excelexport;";
											$result = mysqli_query($conn, $sql);
											$i=1;
											$tempDate = '';
											while ($aRow = mysqli_fetch_array($result)) {
												if($tempDate!=$aRow['Date']) {
											?>
											<tr> 
												<td style="background-color:#f3faf6;" colspan="7"><?php echo $aRow['Date']; ?></td> 
											</tr> 
											<?php 
												$tempDate=$aRow['Date'];
												}
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td> 
												<td><?php echo $aRow['ItemCode']; ?></td>  
												<td class="txt-right"><?php echo number_format($aRow['Price'],2); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Quantity']); ?></td> 
											</tr> 
											<?php }	?>
											
										</tbody>
									</table>
								</div>
							</div>
						</div><!--end of Row Grouping-->						
						
						<div id="HeaderRowsColumnsMerge" class="tab-pane fade">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Header (Rows and Columns Merge)</h5>
									<a href="header-rows-columns-merge.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th rowspan="2" class="txt-center" style="width:5%; vertical-align:middle;">#</th>
												<th rowspan="2" style="width:35%; vertical-align:middle;">Row Merge</th> 
												<th colspan="2" style="width:30%;" class="txt-center">Column Merge 1</th> 
												<th colspan="2" style="width:30%;" class="txt-center">Column Merge 2</th> 
											</tr>
											<tr> 
												<th style="width:15%;">Column 2</th> 
												<th style="width:15%;">Column 3</th> 
												<th class="txt-right" style="width:15%;">Column 4</th> 
												<th class="txt-right" style="width:15%;">Column 5</th> 
											</tr>
										</thead>
										<tbody>
											<?php
												/*sql*/
												$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
												FROM excelexport ORDER BY ItemName;";
												$result = mysqli_query($conn, $sql);
												$i=1; 
												while ($aRow = mysqli_fetch_array($result)) {
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td> 
												<td><?php echo $aRow['ItemCode']; ?></td> 
												<td><?php echo $aRow['Date']; ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price'],2); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Quantity']); ?></td> 
											</tr> 
											<?php }	?>
											
										</tbody>
									</table>
								</div>
							</div>
						</div><!--end of Header (Rows and Columns Merge)-->						
						
						<div id="AutofilterRangeofCells" class="tab-pane fade">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Autofilter Range of Cells</h5>
									<a href="autofilter-range-of-cells.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead> 
											<tr>
												<th class="txt-center" style="width:5%;">#</th>
												<th style="width:35%;">Item Name</th> 
												<th style="width:15%;">Item Code</th> 
												<th style="width:15%;">Date</th> 
												<th style="width:15%;">Price</th> 
												<th style="width:15%;">Quantity</th> 
											</tr> 
										</thead> 
										<tbody>
											<?php
												/*sql*/
												$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
												FROM excelexport ORDER BY ItemName;";
												$result = mysqli_query($conn, $sql);
												$i=1; 
												while ($aRow = mysqli_fetch_array($result)) {
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td> 
												<td><?php echo $aRow['ItemCode']; ?></td> 
												<td><?php echo $aRow['Date']; ?></td> 
												<td><?php echo number_format($aRow['Price'],2); ?></td> 
												<td><?php echo number_format($aRow['Quantity']); ?></td>
											</tr> 
											<?php }	?>
										</tbody> 
									</table>
								</div>
							</div>
						</div><!--end of Row Merge Excel Export-->
						
						<div id="FormulaCalculations" class="tab-pane fade">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Formula Calculations</h5>
									<a href="formula-calculations-excel-export.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead> 
											<tr>
												<th class="txt-center" style="width:4%;">#</th>
												<th style="width:30%;">Cell1</th> 
												<th class="txt-right" style="width:10%;">Cell2</th> 
												<th class="txt-right" style="width:8%;">Cell3</th> 
												<th class="txt-right" style="width:11%;">(Cell2*Cell3)</th> 
												<th class="txt-right" style="width:11%;">(Cell2+Cell3)</th> 
												<th class="txt-right" style="width:15%;">(Cell2-Cell3)</th> 
												<th class="txt-right" style="width:11%;">(Cell2/Cell3)</th> 
											</tr> 
										</thead> 
										<tbody>
											<?php
												/*sql*/
												$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
												FROM excelexport ORDER BY ItemName;";
												$result = mysqli_query($conn, $sql);
												$i=1; 
												while ($aRow = mysqli_fetch_array($result)) {
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td>  
												<td class="txt-right"><?php echo number_format($aRow['Price']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']*$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']+$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']-$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format(($aRow['Price']/$aRow['Quantity']),2); ?></td> 
											</tr> 
											<?php }	?>
										</tbody> 
									</table>
								</div>
							</div>
						</div><!--end of Formula Calculations-->
						
						<div id="ProtectedUnprotected" class="tab-pane fade">
							<div class="panel-header">
								<div class="inner-panel">
									<h5 class="rules-title">Protected and Unprotected on Cells</h5>
									<a href="protected-and-unprotected-on-cells.php" class="btn btn-primary pull-right">
										<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel Export
									</a>
								</div>
							</div>
							<div class="panel-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th colspan="2" class="txt-center" style="width:34%;">Protected Cell</th> 
												<th colspan="2" class="txt-center" style="width:18%;">Unprotected Cell</th> 
												<th colspan="4" class="txt-center" style="width:48%;">Protected Cell</th> 
											</tr>

											<tr>
												<th class="txt-center" style="width:4%;">#</th>
												<th style="width:30%;">Cell1</th> 
												<th class="txt-right" style="width:10%;">Cell2</th> 
												<th class="txt-right" style="width:8%;">Cell3</th> 
												<th class="txt-right" style="width:11%;">(Cell2*Cell3)</th> 
												<th class="txt-right" style="width:11%;">(Cell2+Cell3)</th> 
												<th class="txt-right" style="width:15%;">(Cell2-Cell3)</th> 
												<th class="txt-right" style="width:11%;">(Cell2/Cell3)</th> 
											</tr> 
										</thead> 
										<tbody>
											<?php
												/*sql*/
												$sql = "SELECT id, ItemName, ItemCode,`Date`, Price, Quantity 
												FROM excelexport ORDER BY ItemName;";
												$result = mysqli_query($conn, $sql);
												$i=1; 
												while ($aRow = mysqli_fetch_array($result)) {
											?>
											<tr> 
												<td class="txt-center"><?php echo $i++; ?></td> 
												<td><?php echo $aRow['ItemName']; ?></td>  
												<td class="txt-right"><?php echo number_format($aRow['Price']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']*$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']+$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format($aRow['Price']-$aRow['Quantity']); ?></td> 
												<td class="txt-right"><?php echo number_format(($aRow['Price']/$aRow['Quantity']),2); ?></td> 
											</tr> 
											<?php }	?>
										</tbody> 
									</table>
								</div>
							</div>
						</div><!--end of Protected and Unprotected on Cells-->
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
    <!-- jQuery plugins -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>