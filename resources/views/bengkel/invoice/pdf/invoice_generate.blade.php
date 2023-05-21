<!DOCTYPE html>
<html>
<head>
	<title>{{ $invoice->invoice_no }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 7pt;
		},
		table tr td{
			font-size: 5pt;
		}
		
		
	</style>
	<center>
		<h4><u>INVOICE</u></h4>		
	</center>

	<hr>

	<div>Invoice Data</div>

	<table class='table table-bordered' style="font-size: 12px;">
		<thead>
			<tr>
				<th width="15%">Invoice Nomor</th>
				<th width="15%">Tanggal Invoice</th>   
				<th width="10%">Status</th> 
				<th width="10%">PPH</th>  
				<th width="10%">Jasa</th>  
				<th width="10%">Part</th>  
				<th width="10%">Total</th>  
				<th width="10%">User Request</th>    
			</tr>
		</thead>
		<tbody>
			<tr>
			<th><?php echo $invoice->invoice_no ?></th>
			<th><?php echo $invoice->created_date ?></th>
			<th><?php echo $invoice->status ?></th>
			<th><?php echo "Rp " . number_format($invoice->pph,0,',','.'); ?></th>
			<th><?php echo "Rp " . number_format($invoice->jasa_total,0,',','.'); ?></th>
			<th><?php echo "Rp " . number_format($invoice->part_total,0,',','.'); ?></th>
			<th><?php echo "Rp " . number_format(($invoice->jasa_total - $invoice->pph) + $invoice->part_total,0,',','.'); ?></th>
			<th><?php echo $invoice->create_by ?></th>
		</tr>
		
		</tbody>
		
	</table>

	<div>Invoice Detail</div>
	<br>
	{{-- <font size="2" face="Courier New" > --}}
	<table class='table table-bordered' style="font-size: 6pt;">
		<thead>
			<tr>
				
				<th width="14%">Service No</th>  
				<th width="10%">Area</th>   
				<th width="15%">Cabang</th> 
				<th width="12%">Tanggal Service</th>   
				<th width="8%">NOPOL</th>
				<th width="17%">Merk</th>
				<th width="10%">Nama barang</th>  		 
				<th width="8%">Part</th>
				<th width="8%">Jasa</th> 
				<th width="10%">Jumlah</th>   	  				 

			</tr>
		</thead>
		<tbody>
				<?php $i=1; foreach($invoice_detail as $ind) { ?>


				<tr>
					
					<td><?php echo $ind->service_no ?></td> 
					<td><?php echo $ind->area ?></td>  
					<td><?php echo $ind->branch ?></td> 
					<td><?php echo $ind->tanggal_service ?></td>
					<td><?php echo $ind->nopol ?></td> 
					<td><?php echo $ind->type ?></td>
					<td><?php echo $ind->service_name ?></td>  
					<td><?php if($ind->part == NULL) { echo "" ;} else { echo "Rp " . number_format($ind->part,0,',','.'); } ?></td>				                                            
					<td><?php if($ind->jasa == NULL) { echo "" ;} else { echo "Rp " . number_format($ind->jasa,0,',','.'); } ?></td>
					<td><?php echo "Rp " . number_format($ind->jasa+$ind->part,0,',','.'); ?></td>
				</tr>	


				<?php $i++; } ?> 
				<tr>
					<td colspan="4" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
					<th colspan="3">Total</th>
					<td ><?php echo "Rp " . number_format($invoice->part_total,0,',','.'); ?></td>
					<td ><?php echo "Rp " . number_format($invoice->jasa_total,0,',','.'); ?></td>
					<td ><?php echo "Rp " . number_format(($invoice->jasa_total - $invoice->pph) + $invoice->part_total,0,',','.'); ?></td>
				</tr>
				<tr>
					<td colspan="4" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
					<th colspan="3">PPH 2%</th>
					<td ></td>
					<td > <?php echo "- Rp " . number_format($invoice->pph,0,',','.'); ?> </td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="4" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
					<th colspan="3">Total</th>
					<td ><?php echo "Rp " . number_format($invoice->part_total,0,',','.'); ?></td>
					<td ><?php echo "Rp " . number_format($invoice->jasa_total - $invoice->pph,0,',','.'); ?></td>
					<td ><?php echo "Rp " . number_format(($invoice->jasa_total - $invoice->pph) + $invoice->part_total,0,',','.'); ?></td>
				</tr>

		
		</tbody>
		
	</table>
{{-- </font> --}}

 
</body>
</html>