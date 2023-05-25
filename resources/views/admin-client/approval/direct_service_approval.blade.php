@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-client/approval/direct-service-approval-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	{{ csrf_field() }}


	
	

		<div class="row mb-2">  
                                      
							<div class="col-md-4">
								<div class="card-body box-profile">
									<div class="text-center">
										@if($direct->foto_kendaraan != NULL)
									  <img class="img img-thumbnail img-fluid" src="{{ asset('admin-client/approval/get-image_direct/'.$direct->id) }}" >
									  @else
									  <img class="img img-thumbnail img-fluid" src="{{ asset('assets/upload/image/thumbs/motor.png') }}" >
									  @endif
									</div>
							
									<h3 class="profile-username text-center">{{ $direct->nopol }}</h3>


									<h3 class="profile-username text-center">{{ $direct->service_type_mvm }}</h3>

									<div class="clearfix"><hr></div>
									<p  class="text-center">
										<div class="text-center">
											<button type="button" class="btn btn-warning btn-sm" name="directspk" onClick="check();"   data-toggle="modal" data-target="#directspk" >
												<i class="fa fa-edit"> </i> Approval Proses
											</button> 
											@include('admin-client/approval/direct_service_spk') 
											<a href="{{ asset('admin-client/approval/direct') }}" class="btn btn-danger btn-sm"><i class="fas fa-hand-point-left"></i> Kembali</a>
										</div>
									
									
									</p>
							
									{{-- @if ($direct->source == 'SPK UPLOAD')
										<h3 class="profile-username text-center">{{ $direct->spk_no }}</h3>
									 @endif --}}

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
										 <td>{{ $direct->norangka }}</td>
										</tr>
										<tr>
										 <th>NO MESIN</th>
										 <td>{{ $direct->nomesin }}</td>
										
									 </tr>
									<tr>
					 
									 <tr>
									   <th>Tahun Pembuatan</th>
									   <td>{{ $direct->tahun }}</td>
									</tr>
									<tr>
									   <th>Tipe</th>
									   <td>{{ $direct->type }}</td>
										
									 </tr>
									 <tr>
									   <th>Tanggal Last Service</th>
									   <td>{{ $direct->tgl_last_service }}</td>
									</tr>
			
									 <tr>
										<th>Cabang</th>
										<td>{{ $direct->branch }}</td>
									</tr>
									<tr>
										  <th>PIC Cabang</th>
										  <td>{{ $direct->pic_branch }}</td>
									  </tr>
									  
							   <tr>
								<th>STATUS</th>
								<td>{{ $direct->status }}</td>
							   </tr>
							   <tr>
								<th>KM Kendaraan</th>
								<td>{{ $direct->km }}</td>
							   
							</tr>

							
							<tr>
							 <th>Tanggal Pengerjaan</th>
							 <td>{{ $direct->tanggal_pengerjaan }}</td>
							</tr>
							<tr>
							 <th>Jenis Pekerjaan</th>
							 <td>{{ $direct->jenis_pekerjaan }}</td>
							
							 </tr>

							 <tr>
								 <th>Nama Driver</th>
								 <td>{{ $direct->nama_driver }}</td>
								</tr>
								<tr>
								 <th>Kontak Driver</th>
								 <td>{{ $direct->kontak_driver }}</td>
								
								 </tr>

								 <tr>
									 <th>Keluhan</th>
									 <td>{{ $direct->keluhan }}</td>
									</tr>

									  
									 
								 </tbody> 
							 </table>

							 
						   </div> 
						   @if($direct->status == 'ESTIMATE')					 
						   @include('admin-client/approval/estimate_detail_proses') 
					
						   </div>
					   </div>
						 </div>           
					 </div>    



					
					
					@endif

		


</form>

