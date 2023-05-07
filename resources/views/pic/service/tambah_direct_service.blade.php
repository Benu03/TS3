
<div class="modal fade" id="Tambah"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">Request Service Vehicle ?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ asset('pic/service/tambah-direct-service') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				{{ csrf_field() }}
				
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Nopol</label>
					<div class="col-sm-9">
						<select name="nopol" id="nopol" class="form-control select2">
							<?php foreach($nopol as $np) { ?>
							  <option value="<?php echo $np->nopol ?>"><?php echo $np->nopol ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>




				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">No Mesin</label>
					<div class="col-sm-9">
						<input type="text" name="nomesin" class="form-control" placeholder="No Mesin" value="{{ old('nomesin') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">No Rangka</label>
					<div class="col-sm-9">
						<input type="text" name="norangka" class="form-control" placeholder="No Rangka" value="{{ old('norangka') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Type</label>
					<div class="col-sm-9">
						<input type="text" name="type" class="form-control" placeholder="Type" value="{{ old('type') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Pengerjaan</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_pengerjaan" class="form-control tanggal" placeholder="Tanggal Pengerjaan" value="<?php if(isset($_POST['tanggal_pengerjaan'])) { echo old('tanggal_pengerjaan'); }else{ echo date('d-m-Y'); } ?>" data-date-format="dd-mm-yyyy">	
					</div>
				</div>


				<div class="row form-group">
					<label class="col-md-3 control-label text-right">Upload Foto Kendaraan</label>
					<div class="col-md-9">
					  <input type="file" name="foto_kendaraan" class="form-control" placeholder="Upload Foto Kendaraan">
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



