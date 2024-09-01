@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="serviceProcessBengkel" action="{{ asset('bengkel/service-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $service->id }}">
    <input type="hidden" name="pic_branch" value="{{ $service->pic_branch }}">

    <div class="form-group row">
        <div class="col-sm-6">
            <div class="form-group row">
                <label class="col-sm-3 control-label text-right">Tanggal Service</label>
                <div class="col-sm-9">
                    <input type="text" name="tanggal_service" class="form-control tanggal" placeholder="Tanggal Service" value="{{ isset($_POST['tanggal_service']) ? old('tanggal_service') : date('Y-m-d') }}" data-date-format="yyyy-mm-dd">	
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 text-right">Nama STNK <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="nama_stnk" class="form-control" placeholder="Nama STNK" value="{{ $service->nama_stnk ?? '' }}" required>
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
                    <input type="text" name="regional" class="form-control" placeholder="Regional" value="{{ $service->regional }}" required readonly>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-md-3 text-right">AREA <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="area" class="form-control" placeholder="AREA" value="{{ $service->area }}" required readonly>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-md-3 text-right">CABANG <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="branch" class="form-control" placeholder="CABANG" value="{{ $service->branch }}" required readonly>
                </div>
            </div>

        </div>
        <div class="col-sm-6">

            <div class="row form-group">
                <label class="col-md-3 text-right">NOPOL <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="nopol" class="form-control" placeholder="NOPOL" value="{{ $service->nopol }}" required readonly>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-md-3 text-right">No Rangka <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="norangka" class="form-control" placeholder="No Rangka" value="{{ $service->norangka }}" required readonly>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-md-3 text-right">No Mesin <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="nomesin" class="form-control" placeholder="No Mesin" value="{{ $service->nomesin }}" required readonly>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 text-right">Tipe/Tahun <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="tipe_tahun" class="form-control" placeholder="Tipe/Tahun" value="{{ $service->type.'/'.$service->tahun_pembuatan }}" required readonly>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 text-right">KM Terakhir <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="last_km" class="form-control" placeholder="KM Terakhir" value="{{ $service->last_km }}" onkeypress="return isNumber(event)" required>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-md-3 text-right">Mekanik <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="mekanik" class="form-control" placeholder="Mekanik" value="{{ $service->pic_bengkel }}" required>
                </div>
            </div>

        </div>

    </div>

    <div class="clearfix"><hr></div>
    <div class="form-group row">
        <div class="col-sm-6">

                <div class="card card-light">
                <div class="card-header">
                <div class="row">
                <div class="col-md-6">
                <h3 class="card-title">Pekerjaan</h3>
                </div>
                <div class="col-md-6">
                <div class="custom-control custom-switch text-md-right">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" >
                    <label class="custom-control-label" name="gpslabel" for="customSwitch1">GPS Install</label>
                </div>

                </div>
            </div>

                  
                   

                </div>
                <div class="card-body">

                    <div class="row form-group">

                        <div class="col-sm-12">
                            <div id="show_item_jobs">
                                <div class="row form-group">
                                    <div class="col-sm-5">
                                        <select name="jobs[]" class="form-control select2">
                                            @foreach($jobs as $jb)
                                            <option value="{{ $jb->mst_price_service_id }}">{{ $jb->service_name.' ('.$jb->kode.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" name="value_jobs[]" class="form-control" placeholder="Remark" value="{{ old('value_jobs') }}" required>
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
                                            @foreach($part as $pt)
                                            <option value="{{ $pt->mst_price_service_id }}">{{ $pt->service_name.' ('.$pt->kode.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" name="value_part[]" class="form-control" placeholder="Remark" value="{{ old('value_part') }}" required>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <button class="btn btn-success add_more_part" type="button">
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
                                <input type="file" name="upload[]" class="form-control" placeholder="Upload File Service" required>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="value_upload[]" class="form-control" placeholder="Remark" value="{{ old('value_upload') }}" required>
                            </div>
                            <div class="col-sm-2 text-right">
                                <button class="btn btn-success add_more_upload" type="button">
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
                <button type="submit" name="submit" class="btn btn-primary" id="kirimBtn">Kirim</button>
                <input type="reset" name="reset" class="btn btn-success " value="Reset">
                <a href="{{ asset('bengkel/list-service') }}" class="btn btn-danger">Kembali</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>



<div class="modal fade" id="gpsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">GPS Install Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              

            <div class="row form-group">
                <label class="col-md-3 text-right">Serial Number <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="sn_gps" class="form-control" placeholder="SN GPS"  required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label text-right">Tanggal Pemasangan <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="install_date" class="form-control tanggal" placeholder="Tanggal Pemasangan" data-date-format="yyyy-mm-dd">	
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 control-label text-right">Evidance <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                <input type="file" name="uploadgps1" class="form-control" placeholder="Upload File Install GPS" required>	
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 control-label text-right"></label>
                <div class="col-sm-9">
                <input type="file" name="uploadgps2" class="form-control" placeholder="Upload File Install GPS">	
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 control-label text-right"></label>
                <div class="col-sm-9">
                <input type="file" name="uploadgps3" class="form-control" placeholder="Upload File Install GPS">	
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label text-right">Remark</label>
                <div class="col-sm-9">
                <textarea name="remarkgps" id="remarkgps" class="form-control" placeholder="Remark Gps"></textarea>
                </div>
            </div>
         

    
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="simpan_gps">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#simpan_gps').click(function(){
            // Ambil nilai input
            var nopol = $('input[name="nopol"]').val();
            var install_date = $('input[name="install_date"]').val();
            var sn_gps = $('input[name="sn_gps"]').val();
            var install_date = $('input[name="install_date"]').val();
            var uploadgps1 = $('input[name="uploadgps1"]').prop('files')[0];
            var uploadgps2 = $('input[name="uploadgps2"]').prop('files')[0];
            var uploadgps3 = $('input[name="uploadgps3"]').prop('files')[0];
            var remarkgps = $('textarea[name="remarkgps"]').val();

            // Buat FormData objek
            var formData = new FormData();
            formData.append('nopol', nopol);
            formData.append('sn_gps', sn_gps);
            formData.append('install_date', install_date);
            formData.append('uploadgps1', uploadgps1);
            formData.append('uploadgps2', uploadgps2);
            formData.append('uploadgps3', uploadgps3);
            formData.append('remarkgps', remarkgps);

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: "{{ asset('bengkel/gps-posting') }}", 
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   
                    $('#gpsmodal').modal('hide'); // Menutup modal setelah request berhasil

                    swal("Sukses", "Data GPS berhasil disimpan!", "success").then(function() {
                        $('#customSwitch1').prop('checked', true); // Mengatur switch ke posisi tercentang
                    });
                  
                 
                    
                
                },
                error: function(xhr, status, error) {
                    swal("Warning", "Terjadi kesalahan saat menyimpan data GPS: " + error, "warning").then(function() {
                        $('#customSwitch1').prop('checked', false);
                    });
                    
                  
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function(){
        $('#customSwitch1').click(function(){
            if($(this).is(":checked")) {
                $('#gpsmodal').modal('show');
            } else {
                $('#gpsmodal').modal('hide');
            }
        });

        $('#gpsmodal').on('hidden.bs.modal', function () {
            $('#customSwitch1').prop('checked', false);
        });
    });
</script>

<script>
$(document).ready(function() {
  $("#serviceProcessBengkel").on("submit", function(e) {
    e.preventDefault();

    // Cek setiap field input
    var isFormValid = true;
    $("#serviceProcessBengkel input[required]").each(function() {
      if ($(this).val().trim() === "") {
        isFormValid = false;
        return false; // Hentikan loop jika ada field yang kosong
      }
    });

    if (isFormValid) {
      // Tampilkan SweetAlert untuk konfirmasi hanya jika semua field telah diisi
      swal({
        title: "Apakah Anda yakin?",
        text: "Tindakan ini tidak dapat dibatalkan.",
        icon: "warning",
        buttons: {
          cancel: "Batal",
          confirm: "Konfirmasi"
        },
        dangerMode: true
      }).then(function(result) {
        if (result) {
          
          // Jika pengguna mengonfirmasi, submit formulir secara manual
          submitForm();
        }
      });
    } else {
      // Tampilkan notifikasi bahwa ada field yang kosong
      swal("Error", "Harap isi semua field yang diperlukan.", "error");
    }
  });

  // Jalankan submit form saat tombol "Kirim" diklik
  $("#kirimBtn").on("click", function() {
    $("#serviceProcessBengkel").submit();
  });

async function submitForm() {
    // Dapatkan data form
    var formData = new FormData($("#serviceProcessBengkel")[0]);

    try {
      // Tampilkan animasi loading menggunakan SweetAlert
      swal({
        title: "Mengirim data...",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
        position: "center"
      });

      // Kirim data form ke controller menggunakan Ajax
      await $.ajax({
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        url: "{{ asset('bengkel/service-proses') }}", 
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Handle response dari controller di sini
          swal("Sukses", "Data Berhasil Di Kirim!", "success").then(function() {
            // Redirect ke halaman lain jika diperlukan
            window.location.href = "{{ asset('bengkel/list-service') }}";
          });
        },
        error: function(error) {
          console.error("Gagal mengirimkan formulir:", error);
        }
      });
    } catch (error) {
      console.error("Gagal mengirimkan formulir:", error);
    }
  }
});



</script>




<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_part").click(function(e){ 
          e.preventDefault();
		  $("#show_item_part").prepend(`<div class="row form-group">														
															<div class="col-sm-5">
																<select name="part[]" class="form-control select2">
																<?php foreach($part as $pt) { ?>
																<option value="<?php echo $pt->mst_price_service_id ?>"><?php echo $pt->service_name.' ('.$pt->kode.')'  ?></option>
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
                 // Inisialisasi ulang Select2 pada elemen select baru
        $(".select2").select2();
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
																<option value="<?php echo $jb->mst_price_service_id ?>"><?php echo $jb->service_name.' ('.$jb->kode.')' ?></option>
																<?php } ?>													
																</select>
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_jobs[]" class="form-control" placeholder="" value="{{ old('value_jobs') }}" required>
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
																<input type="file" name="upload[]" class="form-control" placeholder="Upload File Service" required>	
															</div>
															<div class="col-sm-5">
																<input type="text" name="value_upload[]" class="form-control" placeholder="Remark" value="{{ old('value_upload') }}" required>
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


