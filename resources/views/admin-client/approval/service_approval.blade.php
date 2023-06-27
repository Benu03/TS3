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
<form action="{{ asset('admin-client/approval/service-approval-proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}

    <div class="row mb-2">  
                                      
        <div class="col-md-4">
            <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img img-thumbnail img-fluid" src="{{ asset('assets/upload/image/thumbs/motor.png') }}" >
                </div>
        
                <h3 class="profile-username text-center">{{ $service->nopol }}</h3>


                <h3 class="profile-username text-center">{{ $service->source }}</h3>

                @if ($service->source == 'SPK UPLOAD')
                    <h3 class="profile-username text-center">{{ $service->spk_no }}</h3>
                 @endif

              </div>
              <div class="card">  
                <div class="card-header">
                Remark Detail
                </div>
                    <div class="card-body">  
                        <input type="hidden" name="id" value="<?php echo $service->id ?>">
              <div class="form-group row">
                <label class="col-sm-3 control-label text-right">Remark</label>
                <div class="col-sm-9">
                    <textarea name="remark" class="form-control" id="remark" placeholder="Remark">{{ old('remark') }}</textarea>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label text-right"></label>
                <div class="col-sm-9">
                    <div class="form-group pull-right btn-group">
                        <input type="submit" name="submit" class="btn btn-primary " value="Approve">
                        <input type="reset" name="reset" class="btn btn-success " value="Reset">
                        <a href="{{ asset('admin-client/approval') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


        </div>
    </div>
        </div>
        <div class="col-md-8">
           <div class="card">
               <div class="card-body">  
                <div class="table-responsive-md">
                        <table class="table table-bordered">
                    
                         <tbody>
            
 
                                <tr>
                                    <th>NO RANGKA</th>
                                    <td>{{ $service->norangka }}</td>
                                    </tr>
                                    <tr>
                                    <th>NO MESIN</th>
                                    <td>{{ $service->nomesin }}</td>
                                    
                                </tr>
                                <tr>
                
                                <tr>
                                <th>Tahun Pembuatan</th>
                                <td>{{ $service->tahun }}</td>
                                </tr>
                                <tr>
                                <th>Tipe</th>
                                <td>{{ $service->type }}</td>
                                    
                                </tr>
                                <tr>
                                <th>Tanggal Last Service</th>
                                <td>{{ $service->tgl_last_service }}</td>
                                </tr>
                                <tr>
                                    <th>Status Service</th>
                                    <td>{{ $service->status_service }}</td>
                                </tr>
                                <tr>
                                    <th>Cabang</th>
                                    <td>{{ $service->branch }}</td>
                                </tr>
                                <tr>
                                    <th>PIC Cabang</th>
                                    <td>{{ $service->pic_branch }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Schedule</th>
                                    <td>{{ $service->tanggal_schedule }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Service</th>
                                    <td>{{ $service->tanggal_service }}</td>
                                </tr>
                                <tr>
                                    <th>Bengkel</th>
                                    <td>{{ $service->bengkel_name }}</td>
                                </tr>
                                <tr>
                                    <th>PIC Bengkel</th>
                                    <td>{{ $service->pic_bengkel }}</td>
                                </tr>

                                <tr>
                                    <th>Remark SPK</th>
                                    <td>{{ $service->remark }}</td>
                                </tr>
                                <tr>
                                    <th>Remark TS3</th>
                                    <td>{{ $service->remark_ts3 }}</td>
                                </tr>
                            </tbody>
                        </table>
                 </div> 
                </div>
            </div>
            <div class="card">  
                <div class="card-header">
                Service Detail
                </div>
                    <div class="card-body">  
                        <table class="table table-bordered table-sm" style="font-size: 12px;">
                            <thead>
                                <tr class="bg-light">                                                      
                            
                                    <th width="15%">detail_type</th>   
                                    <th width="15%">Attribute</th> 
                                    <th width="15%">Value Attibute</th>                                                 
                            </tr>
                            </thead>

                                <tbody>
                                    
                                    <?php $i=1; foreach($sdetail as $sd) { ?>
                                    <tr>
                                    <td><?php echo $sd->detail_type ?></td>                                              
                                    <td>
                                        @if($sd->detail_type == 'Upload')
                                        <a href="{{ asset('pic/service/get-image-service-detail/').'/'.$sd->attribute }}" target="_blank">
                                            <?php echo $sd->attribute ?>
                                        </a>
                                        @else
                                        <?php echo $sd->attribute ?>
                                        @endif
                                    </td>  
                                    <td><?php echo $sd->value_data ?></td>  
                                
                                    </tr>
                                    <?php $i++; } ?> 
                            </tbody>
                        
                        </table>

                    </div>           
        </div>  
        </div> 
   </div> 

  
 


    


</form>