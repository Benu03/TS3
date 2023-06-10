<!DOCTYPE html>
<html>
    <head>
        <title>How to Use Laravel 8 datatables server side</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Contoh yajra datatables server side pada laravel 8 </h1>
            <table id="dataTable" class="table table-bordered">
                <thead>
                    <th width="5%">
                        <div class="mailbox-controls">
                              <!-- Check all button -->
                             <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                              </button>
                          </div>
                      </th>
                      <th width="30%">Client</th>
                      <th width="40%">Regional</th>    
                      <th>ACTION</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() { 
        fetch_data()
        function fetch_data(){                    
                $('#dataTable').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    bFilter: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
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
                        url:"{{  asset('admin-ts3/get-regional') }}",
                        type: "GET"
                             
                    },
                    columns: [
                        { 
                            name: 'id',
                            data: 'id'
                        },
                        {
                            name: 'client_name',
                            data: 'client_name'
                        },
                        {
                            name: 'regional',
                            data: 'regional'
                        },
                        {
                            name: 'id',
                            data: 'id'
                           
                        },
                    ]
                });
            }         
    });
    </script>
</html>