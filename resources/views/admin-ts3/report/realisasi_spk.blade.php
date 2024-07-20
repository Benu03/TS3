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
				
					<div class="col-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                 From <i class="far fa-calendar-alt ml-2"></i>
                                </span>
                            </div>
                            <input type="text" name="from_date" id="from_date" class="form-control tanggal" placeholder="From Date" value="" data-date-format="yyyy-mm-dd">	
                            </div> 
					</div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                 To <i class="far fa-calendar-alt ml-2"></i>
                                </span>
                            </div>
                            <input type="text" name="to_date"  id="to_date" class="form-control tanggal" placeholder="To Date" value="" data-date-format="yyyy-mm-dd">	
                            </div> 
					</div>





                    <div class="col-sm-4">
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SPK No</span>
                            </div>
                            <input type="text" name="spkno" id="spkno" class="form-control" placeholder="SPK No" value="">
                        </div>
                    </div>
           
                  
                      

                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Regional</span>
                            </div>
                            <select name="regional" id="regional" class="form-control select2">
                                <option value = 'pilih' selected disabled>Pilih</option>
                                <?php foreach($regional as $rg) { ?>
                                    <option value="<?php echo $rg->regional ?>"><?php echo $rg->regional_slug ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                

                    {{-- <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Regional</span>
                            </div>
                           
                        </div>
                    </div> --}}
                </div>

               


                <div class="clearfix"></div>

               
    {{-- </div>        --}}
    </div> 

</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
<thead>
    <tr class="bg-info">
        {{-- <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th> --}}
  
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
    $('#export-pdf').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var spkno = $('#spkno').val();
        var regional = $('#regional').val();

        if (from_date !== '' || to_date !== '' || spkno !== '' || regional !== '') {
            // Tampilkan animasi pengunduhan
            var downloadButton = $('#export-pdf');
            downloadButton.text('Downloading...');
            downloadButton.attr('disabled', true);

            // Kirim permintaan AJAX ke kontroler Anda untuk mendapatkan data
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: "{{ url('admin-ts3/export-realisasi-spk') }}", // Pastikan URL ini sesuai dengan route Anda
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    spkno: spkno,
                    regional: regional
                },
                success: function(response) {
                    var data = response.data.map((item, index) => {
                        return {
                            'No': index + 1,
                            'No Polisi': item.nopol,
                            'No Rangka': item.norangka,
                            'No Mesin': item.nomesin,
                            'Regional': item.regional,
                            'Area': item.area,
                            'Cabang': item.cabang,
                            'SPK No': item.spk_no,
                            'Tanggal Service': item.tanggal_service,
                            'Keterangan': item.remark
                        };
                    });

                    // Buat dokumen PDF dengan orientasi landscape
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF({ orientation: 'landscape' });

                    // Menambahkan header
                    doc.setFontSize(16);
                    doc.setFont('Helvetica', 'bold');
                    doc.text(`REALISASI SPK PERIOD ${from_date} SAMPAI DENGAN ${to_date}`, 14, 20);
                    
                    // Menambahkan baris kosong
                    doc.text('', 14, 30);

                    // Menambahkan tabel
                    doc.autoTable({
                        startY: 40,
                        head: [ ['No', 'No Polisi', 'No Rangka', 'No Mesin', 'Regional', 'Area', 'Cabang', 'SPK No', 'Tanggal Service', 'Keterangan']],
                        body: data.map(item => [
                            item['No'],
                            item['No Polisi'],
                            item['No Rangka'],
                            item['No Mesin'],
                            item['Regional'],
                            item['Area'],
                            item['Cabang'],
                            item['SPK No'],
                            item['Tanggal Service'],
                            item['Keterangan']
                          
                        ]),
                        headStyles: { fillColor: [22, 160, 133] }, // Warna header tabel
                        margin: { top: 40 },
                        pageBreak: 'auto',
                        theme: 'striped'
                    });

                    // Simpan PDF dan unduh
                    doc.save(`Realisasi-SPK-${from_date}-${to_date}.pdf`);

                    // Kembalikan tombol ke keadaan semula
                    setTimeout(function() {
                        downloadButton.html('<i class="far fa-file-pdf"></i> Export PDF');
                        downloadButton.attr('disabled', false);
                    }, 1000); // Durasi animasi dalam milidetik
                },
                error: function() {
                    swal('Oops..', 'Terjadi kesalahan saat memuat data.', 'error');
                    // Mengembalikan tombol ke keadaan semula jika terjadi kesalahan
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
    $('#export').click(function(){
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var spkno = $('#spkno').val();
    var regional = $('#regional').val();
    console.log(regional);

    if (from_date !== '' || to_date !== '' || spkno !== '' || regional !== '') {
        // Tampilkan animasi pengunduhan
        var downloadButton = $('#export');
        downloadButton.text('Downloading...');
        downloadButton.attr('disabled', true);

        // Kirim permintaan AJAX ke kontroler Anda untuk mendapatkan data
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
            success: function(response) {
                var urutkan = 1; // Inisialisasi urutkan

                // Mengubah nama kolom
                var data = response.data.map(item => {
                    return {
                        'No': urutkan++,
                        'No Polisi': item.nopol,
                        'No Rangka': item.norangka,
                        'No Mesin': item.nomesin,
                        'Regional': item.regional,
                        'Area': item.area,
                        'Cabang': item.cabang,
                        'SPK No': item.spk_no,
                        'Tanggal Service': item.tanggal_service,
                        'Keterangan': item.remark
                    };
                });

                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.json_to_sheet(data);

                // Menambahkan header teks
                var headerText = `REALISASI SPK PERIOD ${from_date} SAMPAI DENGAN ${to_date}`;
                XLSX.utils.sheet_add_aoa(ws, [[headerText]], { origin: 'A1' });
                ws['A1'].s = { font: { bold: true } };

                // Menambahkan baris kosong setelah header teks
                XLSX.utils.sheet_add_aoa(ws, [[]], { origin: 'A2' });

                // Menambahkan header kolom
                XLSX.utils.sheet_add_aoa(ws, [
                    ['No', 'No Polisi', 'No Rangka', 'No Mesin', 'Regional', 'Area', 'Cabang', 'SPK No', 'Tanggal Service', 'Keterangan']
                ], { origin: 'A3' });

                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                var blob = new Blob([new Uint8Array(XLSX.write(wb, { bookType: 'xlsx', type: 'array' }))], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                setTimeout(function() {
                    downloadButton.html('<i class="far fa-file-excel"></i> Export');
                    downloadButton.attr('disabled', false);

                    var a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = `Realisasi-SPK-${from_date}-${to_date}.xlsx`;
                    a.click();
                }, 1000); 
            },
            error: function() {
                swal('Oops..', 'Terjadi kesalahan saat memuat data.', 'error');
                downloadButton.html('<i class="far fa-file-excel"></i> Export');
                downloadButton.attr('disabled', false);
            }
        });
    } else {
        swal('Oops..', 'Filter Belum Di input', 'warning');
    }
});

</script>