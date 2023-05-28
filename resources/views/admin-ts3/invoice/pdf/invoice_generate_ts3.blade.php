<!DOCTYPE html>
<html>
<head>
	<title>{{ $invoice->invoice_no }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		
		.p1 {
 		 font-family: Arial, Helvetica, sans-serif;
		  color:rgb(224, 25, 3);
		  font-size: 14pt;
		},
		.p2 {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 9pt;
		}
		
	</style>
	<center class="p1">
		<b><u>INVOICE</u></b>	
	</center>

	<center class="p2" >
		No. <?php echo $invoice->invoice_no ?>	
	</center>
	
	<hr>
	
	<table class='table table-borderless table-sm' style="font-size: 8px;">
		<thead>
			<tr>
				<th>
					<table class='table table-borderless table-sm' style="font-size: 8px;">
						<thead>
							<tr>
								<th colspan="2">Kepada : PT.<?php echo $config->nama_singkat ?> INDONESIA</th>							
							</tr> 
							<tr>
								<th colspan="2"><?php echo $config->alamat ?></th>							
							</tr> 
							<tr>
								<th colspan="2"><?php echo $config->telepon ?> , <?php echo $config->email ?></th>							
							</tr> 
							<tr>
								<th colspan="2"></th>				
							</tr>

		
						
						</thead>
					</table>

				</th>

			

			</tr>
		</thead>
	</table>

      <p class="p2">
		<b>Invoice Detail</b>
	  </p>

	<table class='table table-bordered table-sm' style="font-size: 6pt;">
		<thead>
			<tr class="bg-info">                                                      
		   
				<th  width="10%">NOPOL</th> 
				<th width="15%">CABANG</th> 
				<th width="10%">INVOICE</th>  
				<th width="10%">Tanggal Service</th> 
				<th width="7%">KM</th>   
				<th width="7%">Jasa</th>  
				<th width="7%">Barang</th>  
				<th width="7%">PPN</th> 
				<th width="7%">PPH 23</th>    
				<th width="10%">Total Sebelum PPH 23</th>    
				<th width="10%">Total Sesudah PPH 23</th>    
		   
		</tr>
		</thead>

		 <tbody>
			
			<?php $i=1; foreach($invoice_detail as $ind) { ?>
			<tr>
			<td><?php echo $ind->nopol ?></td>     
			<td><?php echo $ind->branch ?></td>  
			<td><?php echo $ind->invoice_no ?></td>  
			<td><?php echo $ind->tanggal_service ?></td>  
			<td><?php echo $ind->last_km ?></td>                                             
			<td><?php echo "Rp " . number_format($ind->jasa,0,',','.'); ?></td>
			<td><?php echo "Rp " . number_format($ind->part,0,',','.'); ?></td>
			<td><?php echo "Rp " . number_format($ind->ppn,0,',','.'); ?></td>
			<td><?php echo "Rp " . number_format($ind->pph23,0,',','.'); ?></td>
			<td><?php echo "Rp " . number_format(($ind->part+$ind->jasa+$ind->ppn),0,',','.'); ?></td>
			<td><?php echo "Rp " . number_format(($ind->part+$ind->jasa+$ind->ppn)-$ind->pph23,0,',','.'); ?></td>
	
			</td>
			 </tr>
			 <?php                          
			 $sumjasa[] =$ind->jasa;
			 $sumpart[] =$ind->part;
			 $sumppn[] =$ind->ppn;
			 $sumpph23[] =$ind->pph23;
			 $sumbeforepph23[] = $ind->part+$ind->jasa+$ind->ppn;
			 $sumafterpph23[] = ($ind->part+$ind->jasa+$ind->ppn)-$ind->pph23;
			 ?> 
			<?php $i++; } ?> 
			<tr>
				<td colspan="5" class="bg-light"></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumjasa),0,',','.'); ?></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumpart),0,',','.'); ?></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumppn),0,',','.'); ?></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumpph23),0,',','.'); ?></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumbeforepph23),0,',','.'); ?></td>  
				<td><?php echo "Rp " . number_format(array_sum($sumafterpph23),0,',','.'); ?></td>  
			</tr>
	</tbody>
		
	</table>
{{-- </font> --}}

 
</body>
</html>