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
				<div class="card">
					<div class="card-body">
				<div class="form-group row">
				
					<table class="table table-sm table-striped   table-sm" style="font-size: 13px;">
						<thead>
							<tr class="table-warning">
								<th class="text-left">
									JASA
								</th>
								<th colspan="2" scope="col" class="text-right">
								  <button type="button" class="btn btn-info btn-sm text-right" data-toggle="modal" data-target="#AddJasaServiceAdmin">
									<i class="fas fa-plus-circle"></i> Add Jasa
								  </button>
								  @include('admin-ts3/spk/service_add_jasa_admin')
								</th>
							  </tr>
						  <tr>
							<th width="30%">Name</th>
							<th width="30%">Value</th>
							<th class="text-center" width="10%">Action</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<?php foreach($service_jasa as $sj) { ?>
							<td>
								<?php echo  $sj->attribute.' ('.$sj->unique_data.')'   ?>
							</td>
							<td><?php echo $sj->value_data ?> </td>
							<td class="text-center"> 
								<a href="" data-id="<?php echo $sj->service_d_id ?>" class="btn btn-danger btn-sm delete-link-jasa">
								<i class="fa fa-trash"></i></a>
							</td>
						  </tr>
						     
    						<?php  } ?> 
						</tbody>
						
					  </table>
					

					
				</div>

			</div>
		</div>
				

			</div>
			<div class="col-sm-6"> 
				<div class="card">
					<div class="card-body">
				<div class="form-group row">
				
					<table class="table table-sm table-striped   table-sm " style="font-size: 13px;">
						<thead>
							<tr class="table-secondary">
								<th class="text-left">
									SPARE PART
								</th>
								<th colspan="2" scope="col" class="text-right">
								  <button type="button" class="btn btn-info btn-sm text-right" data-toggle="modal" data-target="#AddPartServiceAdmin">
									<i class="fas fa-plus-circle"></i> Add Part
								  </button>
								  @include('admin-ts3/spk/service_add_part_admin')
								</th>
							  </tr>
						  <tr>
							<th width="30%">Name</th>
							<th width="30%">Value</th>
							<th class="text-center" width="10%">Action</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<?php foreach($service_part as $pr) { ?>
							<td>
								<?php echo  $pr->attribute.' ('.$pr->unique_data.')'   ?>
							</td>
							<td><?php echo $pr->value_data ?> </td>
							<td class="text-center"> 
								<a href="" data-id="<?php echo $pr->service_d_id ?>" class="btn btn-danger btn-sm delete-link-part">
								<i class="fa fa-trash"></i></a>
							</td>
						  </tr>
						     
    						<?php  } ?> 
						</tbody>
						
					  </table>
					

					
				</div>


		
			</div>
				
			</div> 
		</div>
			
		</div>


				
		<div class="form-group row">
			<div class="col-sm-6">



				{{-- <div class="row form-group">
					<label class="col-md-3 text-right">Foto Kendaraan <span class="text-danger">*</span></label>
					<div class="col-md-9">

							<?php foreach($service_upload as $su) { ?>
								
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#DetailImage<?php echo $su->service_d_id ?>">
									<i class="fas fa-eye"></i>  <?php echo $su->attribute ?>
								</button>   
						
								@include('admin-ts3/spk/service_image_history') 
							<?php } ?>


					</div>
				</div>  --}}



				<div class="card">
					<div class="card-body">
				<div class="form-group row">
				
					<table class="table table-sm table-striped   table-sm " style="font-size: 13px;">
						<thead>
							<tr class="table-secondary">
								<th class="text-left">
									FOTO SERVICE
								</th>
								<th colspan="2" scope="col" class="text-right">
								  <button type="button" class="btn btn-info btn-sm text-right" data-toggle="modal" data-target="#AddFotoServiceAdmin">
									<i class="fas fa-plus-circle"></i> Add Foto
								  </button>
								  @include('admin-ts3/spk/service_add_foto_admin')
								</th>
							  </tr>
						  <tr>
							<th width="30%">File</th>
							<th width="30%">Value</th>
							<th class="text-center" width="10%">Action</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<?php foreach($service_upload as $su) { ?>
							<td>
								
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#DetailImage<?php echo $su->service_d_id ?>">
									<i class="fas fa-eye"></i>  <?php echo $su->attribute ?>
								</button>   
						
								@include('admin-ts3/spk/service_image_history') 

							</td>
							<td>

								<?php echo $su->value_data ?>

							</td>
							<td class="text-center"> 
								<a href="" data-id="<?php echo $su->service_d_id ?>" class="btn btn-danger btn-sm delete-link-foto">
								<i class="fa fa-trash"></i></a>
							</td>
						  </tr>
						     
    						<?php  } ?> 
						</tbody>
						
					  </table>
					

					
				</div>


		
			</div>
				
			</div> 


					
			</div>
			<div class="col-sm-6">
				<div class="form-group row">
	
					<div class="col-sm-12 text-center">
						<div class="form-group pull-right btn-group">

					
							
							<a href="{{ asset('admin-ts3/spk-service-adjustments-proses') }}" class="btn btn-success">Proses Data</a>
							{{-- <input type="reset" name="reset" class="btn btn-success " value="Reset"> --}}
							<a href="{{ asset('admin-ts3/spk-list') }}" class="btn btn-danger">Kembali</a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			
		</div>


</form>

<script>
	$(document).ready(function() {
	  // Tambahkan event listener klik pada tombol hapus
	  $(document).on("click", ".delete-link-jasa", function(e) {
		e.preventDefault();
	
		// Dapatkan ID item yang akan dihapus
		var itemId = $(this).attr("data-id");
	
		// Tampilkan dialog konfirmasi
		swal({
		  title: "Apakah Anda yakin?",
		  text: "Tindakan ini tidak dapat dibatalkan.",
		  icon: "warning",
		  buttons: {
			cancel: "Batal",
			confirm: "Hapus"
		  },
		  dangerMode: true
		}).then(function(result) {
		  if (result) {
			// Kirim permintaan AJAX untuk menghapus item
			$.ajax({
			  url: "{{ asset('admin-ts3/spk/service-delete-detail-jasa') }}/" + itemId,
			  method: "GET",
			  success: function(response) {
				// Tangani respon berhasil
				// Misalnya, Anda dapat menghapus baris yang dihapus dari tabel
				$("tr[data-id='" + itemId + "']").remove();
	
				swal("Dihapus", "Item telah dihapus.", "success");
				location.reload();
			  },
			  error: function(error) {
				// Tangani respon error
				console.error("Gagal menghapus item:", error);
			  }
			}).catch(function(error) {
			  // Tangani kesalahan dalam promise
			  console.error("Gagal menghapus item:", error);
			});
		  }
		});
	  });
	});





</script>
	


<script>
		$(document).ready(function() {
		  // Tambahkan event listener klik pada tombol "Add"
		  $(".add_more_jobs").on("click", function() {
			// Dapatkan nilai input
		
			var url = "{{ url('admin-ts3/spk/service-insert-detail-jasa') }}";
			var servicehid = $("#servicehid").val();
			var jobId = $("#jobs").val();
			var value = $("input[name='value_jobs']").val();
		
			// Buat objek data yang akan dikirimkan dalam permintaan
			var data = {
			  _token: '{{ csrf_token() }}',
			  servicehid: servicehid,
			  job_id: jobId,
			  value: value
			};
		
			// Kirim permintaan AJAX untuk menyisipkan data
			$.ajax({
			  url: url,
			  method: "POST",
			  data: data,
			  success: function(response) {
				// Tangani respon berhasil
				// Misalnya, Anda dapat memperbarui tampilan tabel atau melakukan tindakan lain yang diperlukan
		
				// Menutup modal "Add Jasa"
				$("#AddJasaServiceAdmin").modal("hide");
				swal("Sukses", "Data berhasil ditambahkan!", "success");
				// Memuat ulang tabel untuk menampilkan data baru
				location.reload();
			  },
			  error: function(error) {
				// Tangani respon error
				console.error("Gagal menyisipkan data:", error);
			  }
			});
		  });
		});
</script>


<script>
	$(document).ready(function() {
	  // Tambahkan event listener klik pada tombol hapus
	  $(document).on("click", ".delete-link-part", function(e) {
		e.preventDefault();
	
		// Dapatkan ID item yang akan dihapus
		var itemId = $(this).attr("data-id");
	
		// Tampilkan dialog konfirmasi
		swal({
		  title: "Apakah Anda yakin?",
		  text: "Tindakan ini tidak dapat dibatalkan.",
		  icon: "warning",
		  buttons: {
			cancel: "Batal",
			confirm: "Hapus"
		  },
		  dangerMode: true
		}).then(function(result) {
		  if (result) {
			// Kirim permintaan AJAX untuk menghapus item
			$.ajax({
			  url: "{{ asset('admin-ts3/spk/service-delete-detail-part') }}/" + itemId,
			  method: "GET",
			  success: function(response) {
				// Tangani respon berhasil
				// Misalnya, Anda dapat menghapus baris yang dihapus dari tabel
				$("tr[data-id='" + itemId + "']").remove();
	
				swal("Dihapus", "Item telah dihapus.", "success");
				location.reload();
			  },
			  error: function(error) {
				// Tangani respon error
				console.error("Gagal menghapus item:", error);
			  }
			}).catch(function(error) {
			  // Tangani kesalahan dalam promise
			  console.error("Gagal menghapus item:", error);
			});
		  }
		});
	  });
	});


</script>



<script>
	$(document).ready(function() {
	  // Tambahkan event listener klik pada tombol "Add"
	  $(".add_more_part").on("click", function() {
		// Dapatkan nilai input
	
		var url = "{{ url('admin-ts3/spk/service-insert-detail-part') }}";
		var servicehid = $("#servicehid").val();
		var partId = $("#part").val();
		var value_part = $("input[name='value_part']").val();
	
		// Buat objek data yang akan dikirimkan dalam permintaan
		var data = {
		  _token: '{{ csrf_token() }}',
		  servicehid: servicehid,
		  partId: partId,
		  value_part: value_part
		};
	
		// Kirim permintaan AJAX untuk menyisipkan data
		$.ajax({
		  url: url,
		  method: "POST",
		  data: data,
		  success: function(response) {
			// Tangani respon berhasil
			// Misalnya, Anda dapat memperbarui tampilan tabel atau melakukan tindakan lain yang diperlukan
	
			// Menutup modal "Add Jasa"
			$("#AddPartServiceAdmin").modal("hide");
			swal("Sukses", "Data berhasil ditambahkan!", "success");
			// Memuat ulang tabel untuk menampilkan data baru
			location.reload();
		  },
		  error: function(error) {
			// Tangani respon error
			console.error("Gagal menyisipkan data:", error);
		  }
		});
	  });
	});
</script>


<script>
	$(document).ready(function() {
	  // Tambahkan event listener klik pada tombol hapus
	  $(document).on("click", ".delete-link-foto", function(e) {
		e.preventDefault();
	
		// Dapatkan ID item yang akan dihapus
		var itemId = $(this).attr("data-id");
	
		// Tampilkan dialog konfirmasi
		swal({
		  title: "Apakah Anda yakin?",
		  text: "Tindakan ini tidak dapat dibatalkan.",
		  icon: "warning",
		  buttons: {
			cancel: "Batal",
			confirm: "Hapus"
		  },
		  dangerMode: true
		}).then(function(result) {
		  if (result) {
			// Kirim permintaan AJAX untuk menghapus item
			$.ajax({
			  url: "{{ asset('admin-ts3/spk/service-delete-detail-foto') }}/" + itemId,
			  method: "GET",
			  success: function(response) {
				// Tangani respon berhasil
				// Misalnya, Anda dapat menghapus baris yang dihapus dari tabel
				$("tr[data-id='" + itemId + "']").remove();
	
				swal("Dihapus", "Item telah dihapus.", "success");
				location.reload();
			  },
			  error: function(error) {
				// Tangani respon error
				console.error("Gagal menghapus item:", error);
			  }
			}).catch(function(error) {
			  // Tangani kesalahan dalam promise
			  console.error("Gagal menghapus item:", error);
			});
		  }
		});
	  });
	});





</script>



<script>
$(document).ready(function() {
  // Tambahkan event listener klik pada tombol "Add"
  $(".add_more_foto").on("click", function() {
    // Dapatkan nilai input
    var servicehid = $("#servicehid").val();
    var servicehno = $("#servicehno").val();
    var value_foto = $("input[name='value_foto']").val();
    var fileInput = $("input[name='upload_foto']").get(0).files[0]; // Dapatkan file gambar yang diunggah

    // Buat objek FormData
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('servicehid', servicehid);
    formData.append('servicehno', servicehno);
    formData.append('value_foto', value_foto);
    formData.append('upload_foto', fileInput);

    // Kirim permintaan AJAX untuk menyisipkan data
    $.ajax({
      url: "{{ url('admin-ts3/spk/service-insert-detail-foto') }}",
      method: "POST",
      data: formData,
      contentType: false, // Set contentType ke false untuk menghindari default "application/x-www-form-urlencoded"
      processData: false, // Set processData ke false agar jQuery tidak memproses data FormData
      success: function(response) {
        // Tangani respon berhasil
        // Misalnya, Anda dapat memperbarui tampilan tabel atau melakukan tindakan lain yang diperlukan

        // Menutup modal "Add Jasa"
        $("#AddFotoServiceAdmin").modal("hide");
        swal("Sukses", "Data berhasil ditambahkan!", "success");
        // Memuat ulang tabel untuk menampilkan data baru
        location.reload();
      },
      error: function(error) {
        // Tangani respon error
        console.error("Gagal menyisipkan data:", error);
      }
    });
  });
});
</script>