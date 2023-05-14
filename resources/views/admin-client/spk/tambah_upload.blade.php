
<div class="modal fade" id="Tambah"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title mr-4" id="myModalLabel">Tambah SPK?</h4>
				<div class="btn-group">						  
					<a href="{{ asset('admin-client/template-upload') }}"class="btn btn-secondary">
						<i class="far fa-file-excel"></i> Downlod Template File Upload
					</a>
				
			   </div>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>


			<div class="modal-body">

			
				<form action="{{ asset('admin-client/spk-upload') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8" id="fileUploadForm">
				{{ csrf_field() }}
				
				
				
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">SPK Nomor</label>
					<div class="col-sm-9">
						<input type="text" name="spk_no" class="form-control" placeholder="SPK Nomor" style="text-transform: uppercase" value="{{ old('spk_no') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Jumlah Kendaraan</label>
					<div class="col-sm-9">
						<input type="text" name="count_vehicle" class="form-control" placeholder="Jumlah Kendaraan" value="{{ old('count_vehicle') }}"  onkeypress="return isNumber(event)" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Pengerjaan</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_pengerjaan" class="form-control tanggal" placeholder="Tanggal Pengerjaan" value="<?php if(isset($_POST['tanggal_pengerjaan'])) { echo old('tanggal_pengerjaan'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Berlaku SPK Terakhir</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_last_spk" class="form-control tanggal" placeholder="Tanggal Berlaku SPK Terakhir" value="<?php if(isset($_POST['tanggal_last_spk'])) { echo old('tanggal_last_spk'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 control-label text-right">Upload File SPK</label>
					<div class="col-md-9">
					  <input type="file" name="spk_file" class="form-control" placeholder="Upload File SPK">
					 
					</div>
					
				  </div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right"></label>
					<div class="col-sm-9">
						<div class="form-group pull-right btn-group">
							<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
							<input type="reset" name="reset" class="btn btn-success " value="Reset">
							<button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				</form>

			</div>
		</div>
	</div>
</div>



