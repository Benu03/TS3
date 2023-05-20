@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- <p>
  @include('admin-client/spk/tambah_upload')
</p> --}}
{{-- <form action="{{ asset('bengkel/invoice-create-proses') }}" method="post" accept-charset="utf-8"> --}}
{{ csrf_field() }}
<div class="row">


    
   <div class="col-md-12">
               
				<div class="form-group row">
					<label class="col-sm-2 control-label text-left">Invoice No</label>
					<div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-contract"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="invoice_no" name="invoice_no" value={{ $invoice_no }} required readonly>
                            </div> 
					</div>
                    <div class="col-sm-3">
                        <div class="form-group pull-right btn-group">
                            <button class="btn btn-success " type="button" data-toggle="modal" data-target="#addService">
                                <i class="fas fa-plus-circle"></i> Add Service
                            </button>
                            @include('bengkel/invoice/add_service') 
                        </div>
					</div>
				</div>


</div> 

</div>

<div class="clearfix"><hr></div>

     
                        
                        <div class="row form-group">   
                             {{-- begin form	 --}} 
                            <div class="col-sm-12">	                               
                                
                                <div class="table-responsive mailbox-messages">
                                    <div class="table-responsive mailbox-messages">
                                <table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-info">
                                        <th width="5%">
                                         No
                                        </th>
                                        <th width="15%">Service No</th>
                                        <th width="15%">Jasa</th>
                                        <th width="15%">Spare part</th>    
                                        <th width="15%">Jumlah</th> 
                                        <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    <?php $i=1; foreach($invoicedtl as $ind) { ?>
                                
                                    <td class="text-center">
                                        <?php echo $i ?>
                                    </td>
                                    <td><?php echo $ind->jasa ?></td>
                                    <td><?php echo $ind->part ?></td>
                                    <td>
                                        <div class="btn-group">                       
                                          <a href="{{ asset('bengkel/invoice-detail/delete/'.$ind->invoice_no) }}" class="btn btn-danger btn-sm  delete-link">
                                            <i class="fa fa-trash"></i></a>
                                        </div>
                                
                                    </td>
                                </tr>
                                
                                <?php $i++; } ?>
                                
                                </tbody>
                                </table>
                                </div>

                                {{-- end form --}}
                            </div>

                        </div>






{{-- </form> --}}

<script>
    $('#reservation').daterangepicker()
</script>


