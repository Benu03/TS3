<div class="row"> 
						<div class="col-md-12 text-left">
							<div class="card">  
								<div class="card-header">
								Estimate Detail
								</div>
								<div class="card-body">  
									<table class="table table-bordered table-sm" style="font-size: 11px;">
										<thead>
											<tr class="bg-light">                                                      
										   
												<th widirecth="10%">Kode</th>   
												<th widirecth="10%">Nama barang</th>  		 
												<th widirecth="10%">Part</th>
												<th widirecth="10%">Jasa</th> 
												<th widirecth="10%">Jumlah</th>   	
										   
										</tr>
										</thead>

										 <tbody>
											<?php
											use Illuminate\Support\Facades\DB;
											$estimate  = DB::connection('ts3')->table('mvm.v_service_direct_estimate')->where('id',$direct->id)->get();
											$part  = DB::connection('ts3')->table('mvm.v_service_direct_estimate')->where('id',$direct->id)->sum('part');
											$jasa  = DB::connection('ts3')->table('mvm.v_service_direct_estimate')->where('id',$direct->id)->sum('jasa');
											$pph23 = round(($jasa * 2) / 100);
											$ppn = round((($jasa + $part) * 11) / 100);
											$finaltotal = ($part + $jasa + $ppn) - $pph23;
											?>
											<?php $i=1; foreach($estimate as $ind) { ?>
											<tr>
											<td><?php echo $ind->mst_price_service_id ?></td>                                              
											<td><?php echo $ind->service_name ?></td>  
											<td><?php if($ind->part == NULL) { echo "" ;} else { echo "Rp " . number_format($ind->part,0,',','.'); } ?></td>				                                            
											<td><?php if($ind->jasa == NULL) { echo "" ;} else { echo "Rp " . number_format($ind->jasa,0,',','.'); } ?></td>
											<td><?php echo "Rp " . number_format($ind->jasa+$ind->part,0,',','.'); ?></td>
					
											 </tr>
											<?php $i++; } ?> 
											<tr>
												<td colspan="1" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
												<th colspan="1">Jumlah</th>
												<td ><?php echo "Rp " . number_format($part,0,',','.'); ?></td>
												<td ><?php echo "Rp " . number_format($jasa,0,',','.'); ?></td>
												<td ><?php echo "Rp " . number_format($part + $jasa,0,',','.'); ?></td>

											</tr>
											<tr>
												<td colspan="1" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
												<th colspan="1">PPH 23</th>
												<td ></td>
												<td > <?php echo "- Rp " . number_format($pph23,0,',','.'); ?> </td>
												<td ></td>
											</tr>

											<tr>
												<td colspan="1" style="border-bottom-style: hidden;border-left-style: hidden;"></td>
												<th colspan="1">Total + PPN <?php echo "(Rp " . number_format($ppn,0,',','.').")"; ?></th>
												<td colspan="3" align="right"><b><?php echo "Rp " . number_format($finaltotal,0,',','.'); ?> </b></td>
											
											</tr>

									</tbody>
												
								</table>


								</div>           
								</div>   
	
						</div>           
					</div>   