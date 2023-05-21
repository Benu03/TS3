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
<form action="{{ asset('admin-client/spk/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">


    {{-- <div class="btn-group">
      {{-- <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
          <i class="fa fa-trash"></i>
      </button>  --}}
        {{-- <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Tambah SPK Baru
        </button>
   </div>  --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-contract"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                         Invoice Bengkel Request
                        </span>
                        <span class="info-box-number">
                       {{ $countinvoicebengkel }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-check"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                        Invoice TS3 Proses
                        </span>
                        <span class="info-box-number">
                        {{ $countinvoicets3 }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


        

</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
<thead>
    <tr class="bg-info">        
        <th width="15%">Invoice Nomor</th>
        <th width="12%">Invoice Type</th>
        <th width="15%">Tanggal Invoice</th>   
        <th width="10%">Status</th> 
        <th width="10%">PPH</th>  
        <th width="10%">Jasa</th>  
        <th width="10%">Part</th>  
        <th width="10%">Total</th>  
        <th width="10%">User Request</th>    
        <th>ACTION</th>
</tr>
</thead>
<tbody>
    <?php $i=1; foreach($invoice as $in) { ?>
        <tr>
        <td><?php echo $in->invoice_no ?></td>
        <td><?php echo $in->invoice_type ?></td>
        <td><?php echo $in->created_date ?></td>
        <td><?php echo $in->status ?></td>
        <td><?php echo "Rp " . number_format($in->pph,0,',','.'); ?></td>
        <td><?php echo "Rp " . number_format($in->jasa_total,0,',','.'); ?></td>
        <td><?php echo "Rp " . number_format($in->part_total,0,',','.'); ?></td>
        <td><?php echo "Rp " . number_format(($in->jasa_total - $in->pph) + $in->part_total,0,',','.'); ?></td>
        <td><?php echo $in->create_by ?></td>
        <td>
            <div class="btn-group">
                @if($in->status == 'REQUEST')
                <a href="{{ asset('admin-ts3/invoice-prose-page/'.$in->invoice_no ) }}" 
                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
    
                    @endif
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#invoice<?php echo $in->invoice_no ?>">
                    <i class="fa fa-eye"></i> 
                 </button>     
            
                 @include('admin-ts3/invoice/invoice_view') 
    
                 
    
            </div>
    
        </td>
    </tr>
    
    <?php $i++; } ?> 

</tbody>
</table>
</div>
</div>
</form>