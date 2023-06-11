@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('bengkel/service-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
		<input type="hidden" name="id" value="<?php echo $service->id ?>">
		<input type="hidden" name="pic_branch" value="<?php echo $service->pic_branch ?>">
	
			<div class="form-group row">
				<div class="col-sm-6">
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right">Tanggal Service</label>
						<div class="col-sm-9">
							<input type="text" name="tanggal_service" class="form-control tanggal" placeholder="Tanggal Service" value="<?php if(isset($_POST['tanggal_service'])) { echo old('tanggal_service'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
						</div>
					</div>

					<div class="row form-group">
						<label class="col-md-3 text-right">Nama STNK <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="nama_stnk" class="form-control" placeholder="Nama STNK" value="<?php if($service->nama_stnk != null) echo $service->nama_stnk ?>" required>
						</div>
					</div>


					<div class="row form-group">
						<label class="col-md-3 text-right">Nama Driver <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="nama_driver" class="form-control" placeholder="Nama Driver" value="{{ old('nama_driver') }}" required>
						</div>
					</div>

					<div class="row form-group">
						<label class="col-md-3 text-right">Regional <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="regional" class="form-control" placeholder="Regional" value="<?php echo $service->regional ?>" required readonly>
						</div>
					</div>


					<div class="row form-group">
						<label class="col-md-3 text-right">AREA <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="area" class="form-control" placeholder="AREA" value="<?php echo $service->area ?>" required readonly>
						</div>
					</div>


					<div class="row form-group">
						<label class="col-md-3 text-right">CABANG <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="branch" class="form-control" placeholder="CABANG" value="<?php echo $service->branch ?>" required readonly>
						</div>
					</div>

				</div>
				<div class="col-sm-6">

					<div class="row form-group">
						<label class="col-md-3 text-right">NOPOL <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="nopol" class="form-control" placeholder="NOPOL" value="<?php echo $service->nopol ?>" required readonly>
						</div>
					</div>

					
					<div class="row form-group">
						<label class="col-md-3 text-right">No Rangka <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="norangka" class="form-control" placeholder="No Rangka" value="<?php echo $service->norangka ?>" required readonly>
						</div>
					</div>

					
					<div class="row form-group">
						<label class="col-md-3 text-right">No Mesin <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="nomesin" class="form-control" placeholder="No Mesin" value="<?php echo $service->nomesin ?>" required readonly>
						</div>
					</div>

					<div class="row form-group">
						<label class="col-md-3 text-right">Tipe/Tahun <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="tipe_tahun" class="form-control" placeholder="Tipe/Tahun" value="<?php echo $service->type.'/'.$service->tahun_pembuatan ?>" required readonly>
						</div>
					</div>

					<div class="row form-group">
						<label class="col-md-3 text-right">KM Terakhir <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="last_km" class="form-control" placeholder="KM Terakhir" value="<?php echo $service->last_km ?>"  onkeypress="return isNumber(event)" required >
						</div>
					</div>


					<div class="row form-group">
						<label class="col-md-3 text-right">Mekanik <span class="text-danger">*</span></label>
						<div class="col-md-9">
						<input type="text" name="mekanik" class="form-control" placeholder="Mekanik" value="<?php echo $service->pic_bengkel ?>" required >
						</div>
					</div>

					
				</div>
				
			</div>
		
			<div class="clearfix"><hr></div>
			<div class="form-group row">
						<div class="col-sm-6">

							<div class="card card-info">
								<div class="card-header">
								<h3 class="card-title">Pekerjaan</h3>
								</div>
								<div class="card-body">
									
									<div class="row form-group">
										
										<div class="col-sm-12">	
											<div id="show_item_jobs">											
													<div class="row form-group">													
															<div class="col-sm-5">
																<select name="jobs[]" class="form-control select2">
																<?php foreach($jobs as $jb) { ?>
																<option value="<?php echo $jb->id ?>"><?php echo $jb->name ?></option>
																<?php } ?>													
																</select>
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_jobs[]" class="form-control" placeholder="Remark" value="{{ old('value_jobs') }}">
															</div>
															<div class="col-sm-2 text-right">
																<button class="btn btn-success add_more_jobs" type="button">
																	<i class="fas fa-plus-circle"></i>
																</button>
															</div>
													</div>
												</div>		
										</div>

									</div>

								</div>

							</div>
						</div>	
						<div class="col-sm-6">

							<div class="card card-warning">
								<div class="card-header">
								<h3 class="card-title">Spare Part</h3>
								</div>
								<div class="card-body">
									
									<div class="row form-group">
										
										<div class="col-sm-12">		
												<div id="show_item_part">									
														<div class="row form-group">														
															<div class="col-sm-5">
																<select name="part[]" class="form-control select2">
																<?php foreach($part as $pt) { ?>
																<option value="<?php echo $pt->id ?>"><?php echo $pt->name ?></option>
																<?php } ?>													
																</select>
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_part[]" class="form-control" placeholder="Remark" value="{{ old('value_part') }}" required>
															</div>
															<div class="col-sm-2 text-right">
																<button class="btn btn-success  add_more_part" type="button">
																	<i class="fas fa-plus-circle"></i>
																</button>
															</div>
														</div>	
												</div>
										</div>

									</div>

								</div>

							</div>

						</div>
			</div>

			<div class="clearfix"><hr></div>

			<div class="form-group row">
					<div class="col-sm-8">

							<div class="card card-secondary">
								<div class="card-header">
								<h3 class="card-title">Upload Service</h3>
								</div>
								<div class="card-body">
									<div id="show_item_upload">									
										<div class="row form-group">														
											<div class="col-sm-5">
												<input type="file" name="upload[]" class="form-control" placeholder="Upload File Service">	
											</div>
											<div class="col-sm-5">
												<input type="text" name="value_upload[]" class="form-control" placeholder="Remark" value="{{ old('value_upload') }}" required>
											</div>
											<div class="col-sm-2 text-right">
												<button class="btn btn-success  add_more_upload" type="button">
													<i class="fas fa-plus-circle"></i>
												</button>
											</div>
										</div>	
									</div>
									
								</div>	
							</div>	
					</div>
					<div class="col-sm-4">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Remark Driver</h3>
								</div>
							<div class="card-body">
						<div class="row form-group">
							
							<div class="col-md-12">
								<textarea name="remark_driver" id="remark_driver" class="form-control" placeholder="Remark Driver">{{ old('remark_driver') }}</textarea>
						
							</div>
						</div>
						</div>
					</div>

					</div>


			</div>

		<div class="clearfix"><hr></div>
		<div class="form-group row ">
			<div class="col-sm-9 text-center">
				<div class="form-group pull-center btn-group">
					<input type="submit" name="submit" class="btn btn-primary " value="Kirim">
					<input type="reset" name="reset" class="btn btn-success " value="Reset">
					<a href="{{ asset('bengkel/list-service') }}" class="btn btn-danger">Kembali</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
</form>


<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_part").click(function(e){ 
          e.preventDefault();
		  $("#show_item_part").prepend(`<div class="row form-group">														
															<div class="col-sm-5">
																<select name="part[]" class="form-control select2">
																<?php foreach($part as $pt) { ?>
																<option value="<?php echo $pt->id ?>"><?php echo $pt->name ?></option>
																<?php } ?>													
																</select>
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_part[]" class="form-control" placeholder="" value="{{ old('value_part') }}" required>
															</div>
															<div class="col-sm-2 text-right">
																<button class="btn btn-danger remove_more_part" type="button">
																	<i class="fas fa-minus-circle"></i>
																</button>
															</div>
													</div>`);
      });

	  $(document).on('click','.remove_more_part', function(e){
		e.preventDefault();
		let row_item_part = $(this).parent().parent();
		$(row_item_part).remove();
	  });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_jobs").click(function(e){ 
          e.preventDefault();
		  $("#show_item_jobs").prepend(`<div class="row form-group">													
															<div class="col-sm-5">
																<select name="jobs[]" class="form-control select2">
																<?php foreach($jobs as $jb) { ?>
																<option value="<?php echo $jb->id ?>"><?php echo $jb->name ?></option>
																<?php } ?>													
																</select>
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_jobs[]" class="form-control" placeholder="" value="{{ old('value_jobs') }}">
															</div>
															<div class="col-sm-2 text-right">
																<button class="btn btn-danger remove_more_jobs" type="button">
																	<i class="fas fa-minus-circle"></i>
																</button>
															</div>`);
      });

	  $(document).on('click','.remove_more_jobs', function(e){
		e.preventDefault();
		let row_item_jobs = $(this).parent().parent();
		$(row_item_jobs).remove();
	  });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_upload").click(function(e){ 
          e.preventDefault();
		  $("#show_item_upload").prepend(`<div class="row form-group">													
															<div class="col-sm-5">
																<input type="file" name="upload[]" class="form-control" placeholder="Upload File Service">	
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_upload[]" class="form-control" placeholder="Remark" value="{{ old('value_upload') }}">
															</div>
															<div class="col-sm-2 text-right">
																<button class="btn btn-danger remove_more_upload" type="button">
																	<i class="fas fa-minus-circle"></i>
																</button>
															</div>`);
      });

	  $(document).on('click','.remove_more_upload', function(e){
		e.preventDefault();
		let row_item_upload = $(this).parent().parent();
		$(row_item_upload).remove();
	  });

    });
</script>

