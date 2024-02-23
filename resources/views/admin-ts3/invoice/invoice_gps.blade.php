@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
   
    <div class="col-md-6">      
				<div class="form-group row">
					<label class="col-sm-3 control-label text-left">Invoice No</label>
					<div class="col-sm-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-contract"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="invoice_no" name="invoice_no" value="{{ $invoice_no }}" required readonly>
                            </div> 
					</div>
                    <div class="col-sm-4">
                        <!-- <div class="form-group">
                            <button class="btn btn-success " type="button" data-toggle="modal" data-target="#addInvoice">
                                <i class="fas fa-plus-circle"></i> Add Invoice
                            </button>
                           
                        </div> -->
					</div>
				</div>
       
    </div>         
         


</div>

  
<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
<thead>
    <tr class="bg-info">
        <th width="10%">Service No</th>
        <th width="10%">Nopol</th>
        <th width="10%">GPS Serial Number</th>
        <th width="10%">Tanggal Pemasangan</th>    
        <th width="7%">Client</th>  
        <th width="10%">User Install</th>    
        <th width="10%">ACTION</th>
</tr>
</thead>
<tbody>
    <?php $i=1; foreach($invoicelist as $in) { ?>
        <tr>
        <td><?php echo $in->service_no ?></td>
        <td><?php echo $in->nopol ?></td>
        <td><?php echo $in->sn_gps ?></td>
        <td><?php echo $in->install_date ?></td>
        <td><?php echo $in->client_invoice ?></td>
        <td><?php echo $in->created_by ?></td>
        <td>
 
    
        </td>
    </tr>
    
    <?php $i++; } ?> 

</tbody>
</table>
</div>
</div>
</form>