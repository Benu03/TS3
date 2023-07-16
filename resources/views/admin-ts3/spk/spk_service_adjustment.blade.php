@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/spk-service-adjustments-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	{{ csrf_field() }}
		<input type="hidden" name="id" value="<?php echo $service_h->id ?>">
	
		<div class="form-group row">
			<div class="col-sm-6">
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Service No</label>
					<div class="col-sm-9">
						<input type="text" name="service_no" class="form-control" placeholder="Service No" value="<?php echo $service_h->service_no ?>"  readonly>	
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Service</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_service" class="form-control tanggal" placeholder="Tanggal Service" value="<?php echo $service_h->tanggal_service ?>" data-date-format="yyyy-mm-dd" readonly>	
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Nama STNK <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nama_stnk" class="form-control" placeholder="Nama STNK" value="<?php echo $service_h->nama_stnk ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">Nama Driver <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nama_driver" class="form-control" placeholder="Nama Driver" value="<?php echo $service_h->nama_driver ?>" required readonly>
					</div>
				</div>



				<div class="row form-group">
					<label class="col-md-3 text-right">Regional <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="regional" class="form-control" placeholder="Regional" value="<?php echo $service_h->regional ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">AREA <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="area" class="form-control" placeholder="AREA" value="<?php echo $service_h->area ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">CABANG <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="branch" class="form-control" placeholder="CABANG" value="<?php echo $service_h->branch ?>" required readonly>
					</div>
				</div>

				
			

				


			

				


			</div>
			
			<div class="col-sm-6">
				<div class="row form-group">
					<label class="col-md-3 text-right">NOPOL <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nopol" class="form-control" placeholder="NOPOL" value="<?php echo $service_h->nopol ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">No Rangka <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="norangka" class="form-control" placeholder="No Rangka" value="<?php echo $service_h->norangka ?>" required readonly>
					</div>
				</div>

				
				<div class="row form-group">
					<label class="col-md-3 text-right">No Mesin <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nomesin" class="form-control" placeholder="No Mesin" value="<?php echo $service_h->nomesin ?>" required readonly>
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-3 text-right">Tipe/Tahun <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="tipe_tahun" class="form-control" placeholder="Tipe/Tahun" value="<?php echo $service_h->type.'/'.$service_h->tahun ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">KM Terakhir <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="last_km" class="form-control" placeholder="KM Terakhir" value="<?php echo $service_h->last_km ?>"  onkeypress="return isNumber(event)" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Status <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="status_service" class="form-control" placeholder="status_service" value="<?php echo $service_h->status_service ?>"   required readonly>
					</div>
				</div>
				
					


					

				<div class="row form-group">
					<label class="col-md-3 text-right">Remark Driver<span class="text-danger">*</span></label>
					<div class="col-md-9">
						<textarea name="remark" id="remark" class="form-control" placeholder="Remark" readonly><?php echo $service_h->remark_driver ?></textarea>
					</div>
				</div>


				

			

			</div>
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Jasa</label>
					<div class="col-sm-9">			
						<select name="jasa_id[]" id="jasa_id" class="form-control select2" multiple="multiple">
						
									<?php foreach($jobs as $jb) { ?>
									<option value="<?php echo $jb->mst_price_service_id ?>" 
									  <?php     

									  foreach ($service_jasa as $sj) {
											  if($sj->unique_data == $jb->mst_price_service_id) { echo 'selected'; } 
									  }
									  ?>			
									  ><?php echo $jb->service_name.' ('.$jb->kode.')' ?></option>
								  <?php } ?>		

								



						  </select>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">Foto Kendaraan <span class="text-danger">*</span></label>
					<div class="col-md-9">

							<?php foreach($service_upload as $su) { ?>
								
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#DetailImage<?php echo $su->service_d_id ?>">
									<i class="fas fa-eye"></i>  <?php echo $su->attribute ?>
								</button>   
						
								@include('admin-ts3/spk/service_image_history') 
							<?php } ?>


					</div>
				</div> 

			</div>
			<div class="col-sm-6">


				
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Spare part</label>
					<div class="col-sm-9">			
						<select name="part_id[]" id="part_id" class="form-control select2" multiple="multiple">
						

								<?php foreach($part as $pt) { ?>
									<option value="<?php echo $pt->mst_price_service_id ?>" 
									  <?php     

									  foreach ($service_part as $sp) {
											  if($sp->unique_data == $pt->mst_price_service_id) { echo 'selected'; } 
									  }
									  ?>			
									  ><?php echo $pt->service_name.' ('.$pt->kode.')' ?></option>
								  <?php } ?>		



						  </select>
					</div>
				</div>

				<div class="form-group row">
	
					<div class="col-sm-12 text-center">
						<div class="form-group pull-right btn-group">
							<input type="submit" name="submit" class="btn btn-primary " value="Proses Data">
							<input type="reset" name="reset" class="btn btn-success " value="Reset">
							<a href="{{ asset('admin-ts3/spk-list') }}" class="btn btn-danger">Kembali</a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				
			</div>
			
		</div>


</form>



