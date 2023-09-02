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
  @include('pic/service/tambah_direct_service')
</p> --}}
{{-- <form action="{{ asset('pic/service/proses-direct-service') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }} --}}
<div class="row">

         <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-contract"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">
                    SPK Onprogress
                </span>
                <span class="info-box-number">
                    {{ $onprogress }} 
                {{-- <small>Sudah Dipublikasikan</small> --}}
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
                    SPK Waiting
                </span>
                <span class="info-box-number">
                    {{ $waiting }} 
                {{-- <small>Sudah Dipublikasikan</small> --}}
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
        <table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr class="bg-info">
                    <th width="5%">
                      {{-- <div class="mailbox-controls">
                            <!-- Check all button -->
                           <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                            </button>
                        </div> --}}
                        No
                    </th>
                    <th width="15%">SPK Nomor</th>
                    <th width="10%">Jumlah Kendaraan</th>   
                    <th width="15%">Tanggal Pengerjaan</th> 
                    <th width="15%">Tanggal Berlaku SPK Terakhir</th>  
                    <th width="10%">Status</th>  
                    <th width="15%">User Posting</th>    
                    <th width="15%">Tanggal Posting</th> 
                    <th>ACTION</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($spk as $dt) { ?> 
            
                <td class="text-center">
                    {{-- <div class="icheck-primary">
                              <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $dt->id ?>" id="check<?php echo $i ?>">
                               <label for="check<?php echo $i ?>"></label>
                    </div> --}}
                    <?php echo $i ?>
                </td>
                <td><?php echo $dt->spk_no ?></td>
                <td><?php echo $dt->count_vehicle ?></td>
                <td><?php echo $dt->tanggal_pengerjaan ?></td>
                <td><?php echo $dt->tanggal_last_spk ?></td>
                <td><?php echo $dt->status ?></td>
                <td><?php echo $dt->user_posting ?></td>
                <td><?php echo substr($dt->posting_date,0,10) ?></td>
                <td>
                    <div class="btn-group">
                     

                    <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#Detail<?php echo $dt->spk_seq ?>">
                            <i class="fa fa-eye"></i> 
                    </button>     

        

                    @include('pic/spk/spk_detail') 
           

                              
                          


                  

   
            
                </td>
            </tr>
            
            <?php $i++; } ?>  
            
            </tbody>
            </table>
</div>
</div>
</form>