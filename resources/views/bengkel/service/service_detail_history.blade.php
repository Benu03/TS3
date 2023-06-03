<div class="modal fade" id="Detail<?php echo $ar->service_no ?>"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog " style="max-width:1500px; max-height:1500px;">
		<div class="modal-content">
				<div class="modal-header">
	
				<h4 class="modal-title mr-4" id="myModalLabel">Detail Service (<?php echo $ar->service_no ?>)</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
					<div class="modal-body">
		
             
						<div class="row mb-2">  
                                 
							<div class="col-md-4">
								<div class="card-body box-profile">
									<div class="text-center">
									  <img class="img img-thumbnail img-fluid" src="{{ asset('assets/upload/image/thumbs/motor.png') }}" >
									</div>
							
									<h3 class="profile-username text-center">{{ $ar->nopol }}</h3>

									<h3 class="profile-username text-center">{{ $ar->source }}</h3>

									@if ($ar->source == 'SPK UPLOAD')
										<h3 class="profile-username text-center">{{ $ar->spk_no }}</h3>
									 @endif

								  </div>
							</div>
							<div class="col-md-8">
							   <div class="card">
								   <div class="card-body">  
						 	<div class="table-responsive-md">
							 <table class="table table-bordered">
								 
								 <tbody>
								
					 
									 <tr>
										 <th>NO RANGKA</th>
										 <td>{{ $ar->norangka }}</td>
										</tr>
										<tr>
										 <th>NO MESIN</th>
										 <td>{{ $ar->nomesin }}</td>
										
									 </tr>
									<tr>
					 
									 <tr>
									   <th>Tahun Pembuatan</th>
									   <td>{{ $ar->tahun }}</td>
									</tr>
									<tr>
									   <th>Tipe</th>
									   <td>{{ $ar->type }}</td>
										
									 </tr>
									 <tr>
									   <th>Tanggal Last Service</th>
									   <td>{{ $ar->tgl_last_service }}</td>
									</tr>
									<tr>
										 <th>Status Service</th>
										 <td>{{ $ar->status_service }}</td>
									 </tr>
									 <tr>
										<th>Cabang</th>
										<td>{{ $ar->branch }}</td>
									</tr>
									<tr>
										  <th>PIC Cabang</th>
										  <td>{{ $ar->pic_branch }}</td>
									  </tr>

									  <tr>
										<th>Tanggal Schedule</th>
										<td>{{ $ar->tanggal_schedule }}</td>
									</tr>
									<tr>
										  <th>Tanggal Service</th>
										  <td>{{ $ar->tanggal_service }}</td>
									  </tr>
									  <tr>
										<th>Bengkel</th>
										<td>{{ $ar->bengkel_name }}</td>
									</tr>
									<tr>
										  <th>PIC Bengkel</th>
										  <td>{{ $ar->pic_bengkel }}</td>
									  </tr>

									  <tr>
										<th>Remark SPK</th>
										<td>{{ $ar->remark }}</td>
									</tr>
									<tr>
										  <th>Remark TS3</th>
										  <td>{{ $ar->remark_ts3 }}</td>
									  </tr>
								 </tbody>
							 </table>
						   </div> 
						   </div>
					  	 </div>
					  
					
						 

						
						</div> 
						
						


					   </div> 
					   <div class="row mb-2">  
						<div class="col-sm-12">
						<div class="card">  
							<div class="card-header">
							Service Detail
							</div>
							<div class="card-body">  
								<table class="table table-bordered table-sm" style="font-size: 12px;">
									<thead>
										<tr class="bg-light">                                                      
									   
											<th width="15%">Detail Action</th>   
											<th width="15%">Attribute</th> 
											<th width="15%">Value Attibute</th>                                                 
									</tr>
									</thead>

									 <tbody>
										<?php
										use Illuminate\Support\Facades\DB;
										$sdetail  = DB::connection('ts3')->table('mvm.v_service_detail')->where('mvm_service_vehicle_h_id',$ar->mvm_service_vehicle_h_id)->get();
										?>
										<?php $i=1; foreach($sdetail as $sd) { ?>
										<tr>
										<td><?php echo $sd->detail_type ?></td>                                              
										<td>
											@if($sd->detail_type == 'Upload')
											<a href="{{ asset('bengkel/service/get-image-service-detail/').'/'.$sd->attribute }}" target="_blank">
												<?php echo $sd->attribute ?>
											</a>
											@else
											<?php echo $sd->attribute ?>
											@endif
										</td>  
										<td><?php echo $sd->attribute_value ?></td>  
									
										 </tr>
										<?php $i++; } ?> 
								</tbody>
											
							</table>


							</div>           
							</div>   


								   
					</div>           
					 </div>    
					 
                    </div>
		</div>
	</div>
</div>