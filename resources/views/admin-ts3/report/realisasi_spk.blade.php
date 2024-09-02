@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/report/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">


  
   <div class="col-md-12">
        
            
        
            
				<div class="form-group row">
				
					<div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                 From <i class="far fa-calendar-alt ml-2"></i>
                                </span>
                            </div>
                            
                            <input type="text" name="from_date" id="from_date" class="form-control tanggal" placeholder="From Date" value="" data-date-format="yyyy-mm-dd">	
                            </div> 
					</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                 To <i class="far fa-calendar-alt ml-2"></i>
                                </span>
                            </div>
                            <input type="text" name="to_date"  id="to_date" class="form-control tanggal" placeholder="To Date" value="" data-date-format="yyyy-mm-dd">	
                            </div> 
					</div>



                    <div class="col-sm-2">
						<div class="form-group pull-right btn-group">
                            <button type="button" name="filter" id="filter" class="btn btn-primary" value="Filter Data">
                                <i class="fas fa-filter"></i> Filter Data
                              </button>
                            <button type="button" name="refresh"  id="refresh" class="btn btn-warning " value="Refresh">
                                <i class="fas fa-sync-alt"></i> Refresh
                              </button>
    
						</div>
					</div>

                    <div class="col-sm-4 text-right">

                    <button type="button" name="export-pdf" id="export-pdf" class="btn btn-danger" value="Export Data">
                            <i class="far fa-file-pdf"></i> PDF 
                          </button>
                   
                        <button type="button" name="export" id="export" class="btn btn-success" value="Export Data">
                            <i class="far fa-file-excel"></i> XLSX 
                          </button>
                 
                    </div>

                   
				</div>
                <div class="form-group row">

                    <div class="col-sm-4">
                        <label for="email" class="mr-sm-2">SPK No </label>
                        <input name="spkno" id="spkno" class="form-control mb-2 mr-sm-2" placeholder="SPK No">
                   
                    </div>

                    <div class="col-sm-4">
                        <label for="regional" class="mr-sm-2">Regional </label>
                        <select name="regional" id="regional" class="form-control select2" style="width: calc(100% + 1px); border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                <option value='pilih' selected disabled>Pilih</option>
                                <?php foreach($regional as $rg) { ?>
                                    <option value="<?php echo $rg->regional ?>"><?php echo $rg->regional_slug ?></option>
                                <?php } ?>
                            </select>
                   
                    </div>
                 
                </div>


                <div class="clearfix"></div>

               
  
    </div> 

</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
<thead>
    <tr class="bg-info">
        
        <th width="7%">Nopol</th>   
        <th width="7%">No Rangka</th>   
        <th width="7%">No Mesin</th>  
        <th width="8%">Regional</th>
        <th width="8%">Area</th>
        <th width="8%">Cabang</th> 
        <th width="7%">SPK No</th> 
        <th width="10%">Tanggal Service</th>    
        <th width="7%">Keterangan</th>    
    
</tr>
</thead>

</table>
</div>
</div>
</form>



<script type="text/javascript">
    $(document).ready(function() { 
       
        fetch_data()
        function fetch_data(from_date = '', to_date = '', spkno, regional){                    
                $('#dataTable').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    bFilter: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    order: [[3, 'desc']],
                    oLanguage: {
                        sZeroRecords: "Tidak Ada Data",
                        sSearch: "Pencarian _INPUT_",
                        sLengthMenu: "_MENU_",
                        sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        sInfoEmpty: "0 data",
                        oPaginate: {
                            sNext: "<i class='fa fa-angle-right'></i>",
                            sPrevious: "<i class='fa fa-angle-left'></i>"
                        }
                    },
                    ajax: {
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        url:"{{  url('admin-ts3/get-realisasi-spk') }}",
                        type: "POST",
                        data: function (d) {
                        d.from_date = from_date;
                        d.to_date = to_date;
                        d.spkno = spkno;
                        d.regional = regional;
                    }
                             
                    },
                    columns: [
          
                        {
                            name: 'nopol',
                            data: 'nopol'
                        },
                        {
                            name: 'norangka',
                            data: 'norangka'
                        },
                        {
                            name: 'nomesin',
                            data: 'nomesin'
                        },
                       
                        {
                            name: 'regional',
                            data: 'regional'
                        },
                        {
                            name: 'area',
                            data: 'area'
                        },
                        {
                            name: 'branch',
                            data: 'branch'
                        },
                        {
                            name: 'spk_no',
                            data: 'spk_no'
                        },
                        {
                            name: 'tanggal_service',
                            data: 'tanggal_service'
                        },
                        {
                            name: 'remark',
                            data: 'remark'
                        },
                
                      
                    ]
                });
            }  
            

            $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var spkno = $('#spkno').val();
            var regional = $('#regional').val();

            console.log(regional);

            $('#dataTable').DataTable().destroy();
                fetch_data(from_date, to_date, spkno,regional);

        });

        $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#spkno').val('');
            $('#regional').val('pilih').trigger('change');
            $('#dataTable').DataTable().destroy();
            fetch_data();
        });

    
        
    });



</script>

<script>
$('#export-pdf').click(function() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var spkno = $('#spkno').val();
    var regional = $('#regional').val();

    if (from_date !== '' || to_date !== '' || spkno !== '' || regional !== null) {
        var downloadButton = $('#export-pdf');
        downloadButton.text('Downloading...');
        downloadButton.attr('disabled', true);

        $.ajax({
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            url: "{{ url('admin-ts3/export-realisasi-spk') }}",
            type: "POST",
            data: {
                from_date: from_date,
                to_date: to_date,
                spkno: spkno,
                regional: regional
            },
            xhrFields: {
                responseType: 'blob' // Respons dalam bentuk blob untuk mendownload file
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                var url = window.URL.createObjectURL(blob);
                link.href = url;
                link.download = 'Realisasi-SPK-' + new Date().toISOString().slice(0, 10) + '.pdf';
                document.body.appendChild(link);
                link.click();
                setTimeout(function() {
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                }, 0);

                setTimeout(function() {
                    downloadButton.html('<i class="far fa-file-pdf"></i> Export PDF');
                    downloadButton.attr('disabled', false);
                }, 1000); // Durasi animasi dalam milidetik
            },
            error: function(xhr, status, error) {
                var reader = new FileReader();
                reader.onload = function() {
                    var errorMessage = reader.result;
                    swal('Oops..', 'Terjadi kesalahan saat memuat data: ' + errorMessage, 'error');
                };
                reader.onerror = function() {
                    swal('Oops..', 'Terjadi kesalahan saat membaca respons error.', 'error');
                };
                
                // Cek apakah respons adalah Blob atau bukan
                if (xhr.response instanceof Blob) {
                    reader.readAsText(xhr.response);
                } else {
                    swal('Oops..', 'Terjadi kesalahan saat memuat data.', 'error');
                }
                
                downloadButton.html('<i class="far fa-file-pdf"></i> Export PDF');
                downloadButton.attr('disabled', false);
            }
        });
    } else {
        swal('Oops..', 'Filter Belum Di input', 'warning');
    }
});



</script>






<script>
    $('#export').click(async function() {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var spkno = $('#spkno').val();
        var regional = $('#regional').val();

        if (from_date !== '' || to_date !== '' || spkno !== '' || regional !== '') {
            var downloadButton = $('#export');
            downloadButton.text('Downloading...');
            downloadButton.attr('disabled', true);

            try {
                const response = await $.ajax({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    url: "{{ url('admin-ts3/export-realisasi-spk') }}",
                    type: "POST",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        spkno: spkno,
                        regional: regional
                    }
                });

                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Sheet1');

                // Menentukan header text
                let headerText = 'REALISASI SPK';
                if (from_date && to_date) {
                    headerText = `REALISASI SPK PERIOD ${from_date} SAMPAI ${to_date}`;
                }
                if (from_date && to_date && spkno) {
                    headerText = `REALISASI SPK PERIOD ${from_date} SAMPAI ${to_date}\n${spkno}`;
                }
                if (from_date && to_date && regional) {
                    headerText = `REALISASI SPK PERIOD ${from_date} SAMPAI ${to_date}\n${regional}`;
                }
                if (regional && !from_date && !to_date) {
                    headerText = `REALISASI SPK ${regional}`;
                }

                // Menambahkan header text
                worksheet.addRow([headerText]).font = { bold: true, size: 14 };
                worksheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle' };

                // Menggabungkan sel A1 hingga J1 (10 kolom)
                worksheet.mergeCells('A1:J1');

                // Menambahkan baris kosong setelah header teks
                worksheet.addRow([]);

                // Menambahkan header kolom di A3
                worksheet.addRow(['No', 'No Polisi', 'No Rangka', 'No Mesin', 'Regional', 'Area', 'Cabang', 'SPK No', 'Tanggal Service', 'Keterangan'])
                          .font = { bold: true };
                worksheet.getRow(3).alignment = { horizontal: 'center', vertical: 'middle' };

                // Menambahkan data di baris ke-4
                response.data.forEach((item, index) => {
                    worksheet.addRow([
                        index + 1,
                        item.nopol,
                        item.norangka,
                        item.nomesin,
                        item.regional,
                        item.area,
                        item.cabang,
                        item.spk_no,
                        item.tanggal_service,
                        item.remark
                    ]);
                });

                // Mengatur lebar kolom otomatis
                worksheet.columns.forEach(column => {
                    const maxLength = column.values.reduce((max, val) => Math.max(max, String(val).length), 0);
                    column.width = maxLength + 2; // Adding extra space for padding
                });

                // Menyimpan file
                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                saveAs(blob, `Realisasi-SPK-${new Date().toISOString().slice(0, 19).replace(/[-T:]/g, '')}.xlsx`);

                // Mengembalikan tombol ke kondisi semula
                downloadButton.html('<i class="far fa-file-excel"></i> Export');
                downloadButton.attr('disabled', false);
            } catch (error) {
                swal('Oops..', 'Terjadi kesalahan saat memuat data.', 'error');
                downloadButton.html('<i class="far fa-file-excel"></i> Export');
                downloadButton.attr('disabled', false);
            }
        } else {
            swal('Oops..', 'Filter harus diisi.', 'warning');
        }
    });
</script>

