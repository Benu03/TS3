    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Info box -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Belum Dilihat</span>
                    <span class="info-box-number">{{ $count_notif }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"><hr></div>

    <div class="row">
        <div class="table-responsive mailbox-messages">
            <table id="notif4" class="display table table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-primary">
                        <th width="10%">Judul</th>
                        <th width="25%">Detail</th>
                        <th width="10%">Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Judul Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="notif-detail" class="mb-4"></div>
                    <div class="clearfix"><hr></div>
                    <div id="notif-date"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-row-spacing {
            margin-bottom: 20px;
        }

        .table-bg-light {
            background-color: #5ffccd !important;
        }
    </style>


    <script>
        $(document).ready(function() {
            var table = $('#notif4').DataTable({
                lengthChange: false,
                searching: true,
                order: [[2, 'desc']],
                ajax: {
                url: "{{  asset('admin-ts3/notification-data') }}", // Ganti dengan URL yang sesuai untuk mengambil data notifikasi
                method: 'GET',
                dataType: 'json',
                dataSrc: 'data',
            },
            columns: [
                {
                    data: 'title',
                    render: function(data, type, row) {
                        var isRead = row.is_read ? '' : 'table-bg-light';
                        return '<b>' + data + '</b>';
                    }
                },
                { data: 'detail' },
                { data: 'created_date',
                    render: function(data) {
                        var date = new Date(data);
                        var formattedDate = date.getFullYear() + "-" + 
                                            ("0" + (date.getMonth() + 1)).slice(-2) + "-" + 
                                            ("0" + date.getDate()).slice(-2) + " " +
                                            ("0" + date.getHours()).slice(-2) + ":" +
                                            ("0" + date.getMinutes()).slice(-2);
                        return formattedDate;
                    } 
            },
            ],
            createdRow: function(row, data, dataIndex) {
                var isRead = data.is_read ? '' : 'table-bg-light';
                $(row).addClass(isRead + ' table-row-spacing');
                $(row).attr({
                    'data-toggle': 'modal',
                    'data-target': '#myModal',
                    'data-notif-id': data.id,
                    'data-notif-title': data.title,
                    'data-notif-detail': data.detail,
                    'data-notif-date': data.created_date
                });
            }
        });

            $('#myModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var notifId = button.data('notif-id');
                var notiftitle = button.data('notif-title');
                var notifdetail = button.data('notif-detail');
                var notifdate = button.data('notif-date');
                var modal = $(this);
                modal.find('.modal-title').text(notiftitle);
                modal.find('#notif-detail').text(notifdetail);
                modal.find('#notif-date').text('Tanggal Dibuat: ' + notifdate);
                // Perbarui konten modal berdasarkan notifId
                // Contoh: Permintaan Ajax untuk mengambil data dan mempopulasikan modal
            });


            $('#myModal').on('hidden.bs.modal', function() {
                location.reload(); // Muat ulang halaman setelah menutup modal
            });
        });


    $(document).ready(function() {


            $('#myModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var notifId = button.data('notif-id');

            // Lakukan permintaan Ajax atau tindakan lain untuk memperbarui status "read" di sisi server
            // Misalnya:
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: "{{  asset('admin-ts3/notification-read') }}", // Ganti dengan URL yang sesuai untuk memperbarui status notifikasi
                method: 'POST',
                data: { notifId: notifId },
                success: function(response) {
                    console.log('Status notifikasi diperbarui');
                    // Lakukan tindakan lain setelah berhasil memperbarui status notifikasi
                    
                },
                error: function(xhr, status, error) {
                    table.ajax.reload(null, false);
                    console.error('Terjadi kesalahan saat memperbarui status notifikasi');
                    // Lakukan penanganan kesalahan jika diperlukan
                }
            });
        });
    });

    </script>
