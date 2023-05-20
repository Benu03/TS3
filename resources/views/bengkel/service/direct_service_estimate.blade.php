@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('bengkel/direct-service-estimate-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<input type="hidden" name="id" value="<?php echo $direct->id ?>">
	

		<div class="form-group row">
			<div class="col-sm-6">
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Pengerjaan</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_pengerjaan" class="form-control tanggal" placeholder="Tanggal Pengerjaan" value="<?php echo $direct->tanggal_pengerjaan ?>" data-date-format="yyyy-mm-dd" readonly>	
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Nama STNK <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nama_stnk" class="form-control" placeholder="Nama STNK" value="<?php echo $direct->nama_stnk ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">Nama Driver <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nama_driver" class="form-control" placeholder="Nama Driver" value="<?php echo $direct->nama_driver ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Kontak Driver <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="kontak_driver" class="form-control" placeholder="Kontak Driver" value="<?php echo $direct->kontak_driver ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Regional <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="regional" class="form-control" placeholder="Regional" value="<?php echo $direct->regional ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">AREA <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="area" class="form-control" placeholder="AREA" value="<?php echo $direct->area ?>" required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">CABANG <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="branch" class="form-control" placeholder="CABANG" value="<?php echo $direct->branch ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Keluhan <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="keluhan" class="form-control" placeholder="Keluhan" value="<?php echo $direct->keluhan ?>" required readonly>
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-3 text-right">NOPOL <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nopol" class="form-control" placeholder="NOPOL" value="<?php echo $direct->nopol ?>" required readonly>
					</div>
				</div>

				
				<div class="row form-group">
					<label class="col-md-3 text-right">No Rangka <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="norangka" class="form-control" placeholder="No Rangka" value="<?php echo $direct->norangka ?>" required readonly>
					</div>
				</div>

				
				<div class="row form-group">
					<label class="col-md-3 text-right">No Mesin <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="nomesin" class="form-control" placeholder="No Mesin" value="<?php echo $direct->nomesin ?>" required readonly>
					</div>
				</div>


			</div>
			<div class="col-sm-6">

				
				<div class="row form-group">
					<label class="col-md-3 text-right">Tipe/Tahun <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="tipe_tahun" class="form-control" placeholder="Tipe/Tahun" value="<?php echo $direct->type.'/'.$direct->tahun ?>" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">KM Terakhir <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="last_km" class="form-control" placeholder="KM Terakhir" value="<?php echo $direct->last_km ?>"  onkeypress="return isNumber(event)" required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Status <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="status" class="form-control" placeholder="Status" value="<?php echo $direct->status ?>"   required readonly>
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 text-right">KM Kendaraan <span class="text-danger">*</span></label>
					<div class="col-md-9">
					<input type="text" name="km" class="form-control" placeholder="KM Kendaraan" value="<?php echo $direct->km ?>"   required readonly>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Foto Kendaraan <span class="text-danger">*</span></label>
					<div class="col-md-9">
						@if($direct->foto_kendaraan != NULL)
						<img class="img img-fluid img-thumbnail img-fluid" src="{{ asset('bengkel/service/get-image_direct/'.$direct->id) }}" style="width: auto; height: 255px;" >
						@else
						<img class="img img-thumbnail img-fluid" src="{{ asset('assets/upload/image/thumbs/motor.png') }}" >
						@endif
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 text-right">Remark Bengkel <span class="text-danger">*</span></label>
					<div class="col-md-9">
						<textarea name="remark_bengkel" id="remark_bengkel" class="form-control" placeholder="Remark Bengkel">{{ old('remark_bengkel') }}</textarea>
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
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Proses Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('bengkel/direct-service') }}" class="btn btn-danger">Kembali</a>
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
