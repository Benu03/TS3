@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    
<form action="{{ asset('admin-ts3/kontak/reply-process') }}" method="post" accept-charset="utf-8">
    {{ csrf_field() }}
    <input type="hidden" name="id_kontak" value="{{ $kontak->id }}">
    <input type="hidden" name="message" value="{{ $kontak->message }}">
    <input type="hidden" name="subject" value="{{ $kontak->subject }}">
    <input type="hidden" name="email" value="{{ $kontak->email }}">
    <div class="form-group row">
        <label class="col-md-3 text-right">Full Name</label>
        <div class="col-md-3">
            <input type="text" name="fullname" class="form-control" placeholder="Fullname" value="<?php echo $kontak->fullname ?>" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 text-right">Phone</label>
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo $kontak->phone ?>" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 text-right">Email</label>
        <div class="col-md-3">
            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $kontak->email ?>" disabled>
        </div>
    </div>


    <div class="form-group row">
        <label class="col-md-3 text-right">Subject</label>
        <div class="col-md-5">
            <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?php echo $kontak->subject ?>" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 text-right">Message</label>
        <div class="col-md-5">
            <textarea name="message" class="form-control" rows="5" placeholder="Message" disabled>{{ $kontak->message }}</textarea>
        </div>
    </div>    

    <div class="form-group row">
        <label class="col-md-3 text-right">Reply via</label>
        <div class="col-md-9">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="reply_via" id="replyPhone" value="phone" required>
                <label class="form-check-label" for="replyPhone">Phone</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="reply_via" id="replyEmail" value="email" required>
                <label class="form-check-label" for="replyEmail">Email</label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 text-right">Message Reply</label>
        <div class="col-md-5">
            <textarea name="message_reply" class="form-control" rows="5" placeholder="Message Reply" required></textarea>
        </div>
    </div>    
    
    <div class="form-group row">
        <label class="col-md-3 text-right"></label>
        <div class="col-md-9">
    <div class="btn-group">
    <input type="submit" name="submit" class="btn btn-success " value="Reply">
    <a href="{{asset('admin-ts3/kontak')}}"
    type="button" class="btn btn-info">Cancel</a>
    </div>
    </div>
    </div>
    
    <div class="clearfix"></div>
    
    </form>




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
                        url:"{{  asset('admin-ts3/get-kontak') }}",
                        type: "GET"
                             
                    },
                    columns: [
                        { 
                            data: 'check', 
                            name: 'check', 
                            className: "text-center",
                            orderable: false, 
                            searchable: false
                        },
                        {
                            name: 'fullname',
                            data: 'fullname'
                        },
                        {
                            name: 'email',
                            data: 'email'
                        },
                        {
                            name: 'phone',
                            data: 'phone'
                        },
                        {
                            name: 'subject',
                            data: 'subject'
                        },
                        {
                            data: 'action', 
                            name: 'action', 
                            className: "text-center",
                            orderable: false, 
                            searchable: false
                           
                        },
                    ]
                });
            }         
    });
    </script>