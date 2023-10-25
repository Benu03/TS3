
<div class="modal fade" id="Tambah"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">Request Service Vehicle ?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			<div class="modal-body">
				<form action="{{ asset('pic/service/tambah-direct-service') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				{{ csrf_field() }}
				
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Nopol</label>
					<div class="col-sm-9">
						<select name="nopol" id="nopol"  onchange="loadDataVehicle()" class="form-control select2">
							<option selected disabled>Pilih</option>
							<?php foreach($nopol as $np) { ?>
							  <option value="<?php echo $np->nopol ?>"><?php echo $np->nopol ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>




				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">No Mesin</label>
					<div class="col-sm-9">
						<input type="text" name="nomesin"  id="nomesin" class="form-control" placeholder="No Mesin" value="{{ old('nomesin') }}" required readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">No Rangka</label>
					<div class="col-sm-9">
						<input type="text" name="norangka"  id="norangka" class="form-control" placeholder="No Rangka" value="{{ old('norangka') }}" required readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Type</label>
					<div class="col-sm-9">
						<input type="text" name="type"  id="type" class="form-control" placeholder="Type" value="{{ old('type') }}" required readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Cabang</label>
					<div class="col-sm-9">
						<select name="mst_branch_id" id="mst_branch_id" class="form-control select2">
							<?php foreach($branch as $br) { ?>
							  <option value="<?php echo $br->id ?>"><?php echo $br->branch ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Km</label>
					<div class="col-sm-9">
						<input type="text" name="km"  id="km" class="form-control" placeholder="KM Kendaraan" value="{{ old('km') }}" onkeypress="return isNumber(event)"  required >
					</div>
				</div>
				

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Pengerjaan</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_pengerjaan" class="form-control tanggal" placeholder="Tanggal Pengerjaan" value="<?php if(isset($_POST['tanggal_pengerjaan'])) { echo old('tanggal_pengerjaan'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Jenis Pekerjaan</label>
					<div class="col-sm-9">
						<input type="text" name="jenis_pekerjaan"  id="jenis_pekerjaan" class="form-control" placeholder="Jenis Pekerjaan" value="{{ old('jenis_pekerjaan') }}" required >
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Keluhan</label>
					<div class="col-sm-9">
						
						<textarea name="keluhan" class="form-control" id="keluhan" placeholder="Keluhan">{{ old('keluhan') }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Nama Driver</label>
					<div class="col-sm-9">
						<input type="text" name="nama_driver"  id="nama_driver" class="form-control" placeholder="Nama Driver" value="{{ old('nama_driver') }}" required >
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Kontak Driver</label>
					<div class="col-sm-9">
						<input type="text" name="kontak_driver"  id="kontak_driver" class="form-control" placeholder="Kontak Driver" value="{{ old('kontak_driver') }}" onkeypress="return isNumber(event)" required >
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



<script>
	var loadDataVehicle = function(){
	const nopol = $("#nopol").val();
	console.log(nopol);
	
	 $.ajax({    
		headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
		 type: "POST",
		 url: "{{ asset('pic/service/get-vehicle')}}", 
		 data:{nopol:nopol},      
		 dataType: "JSON",                  
		 success: function(data){   
			console.log(data);
			document.getElementById('nomesin').value = data.nomesin;
			document.getElementById('norangka').value = data.norangka;
			document.getElementById('type').value = data.type;

			
		 }
	 });
	};
	
	
	</script>


<script>
	function isNumber(evt) {
	 evt = (evt) ? evt : window.event;
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		 return false;
	 }
	 return true;
  }
  </script>
