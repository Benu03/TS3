    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-four-vehicle-tab" data-toggle="pill" href="#custom-tabs-four-vehicle" role="tab" aria-controls="custom-tabs-four-vehicle" aria-selected="false">Vehicle</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-vehicle_type-tab" data-toggle="pill" href="#custom-tabs-four-vehicle_type" role="tab" aria-controls="custom-tabs-four-vehicle_type" aria-selected="false">Vehicle Type</a>
        </li>

        </ul>
    </div>
        <div class="card-body">
            <div class="tab-content " id="custom-tabs-four-tabContent">
                <div class="tab-pane active" id="custom-tabs-four-vehicle" role="tabpanel" aria-labelledby="custom-tabs-four-vehicle-tab">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <p>
                    @include('admin-ts3/vehicle/tambah')
                    </p>
                    <form action="{{ asset('admin-ts3/vehicle/proses') }}" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <div class="row">
                    
                    <div class="col-md-12">
                        <div class="btn-group">
                        <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
                            <i class="fa fa-trash"></i>
                        </button> 
                            <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
                                <i class="fa fa-plus"></i> Tambah Baru
                            </button>
                    </div>
                    </div>
                    </div>
                    
                    <div class="clearfix"><hr></div>
                    <div class="table-responsive mailbox-messages">
                        <div class="table-responsive mailbox-messages">
                    <table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="bg-info">
                            <th width="5%">
                            <div class="mailbox-controls">
                                    <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                    </button>
                                </div>
                            </th>
                            <th width="10%">Nopol</th>
                            <th width="15%">No Rangka</th>
                            <th width="15%">No Mesin</th>
                            <th width="20%">Type</th>
                            <th width="10%">Last Service</th>
                            <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                <?php $i=1; foreach($vehicle as $vc) { ?>
                
                        <td class="text-center">
                        <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $vc->id ?>" id="check<?php echo $i ?>">
                                <label for="check<?php echo $i ?>"></label>
                        </div>
            
                    
                    </td>
                    <td><?php echo $vc->nopol ?></td>
                    <td><?php echo $vc->norangka ?></td>
                    <td><?php echo $vc->nomesin ?></td>
                    <td><?php echo $vc->type ?></td>
                    <td><?php echo $vc->tgl_last_service ?></td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ asset('admin-ts3/vehicle/detail/'.$vc->id) }}" 
                                class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye"></i></a>

                        <a href="{{ asset('admin-ts3/vehicle/edit/'.$vc->id) }}" 
                        class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                
                        <a href="{{ asset('admin-ts3/vehicle/delete/'.$vc->id) }}" class="btn btn-danger btn-sm  delete-link">
                            <i class="fa fa-trash"></i></a>
                        </div>
                
                    </td>
                    </tr>
                
                    <?php $i++; } ?>

                    </tbody>
                    </table>
                    </div>
                    </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-vehicle_type" role="tabpanel" aria-labelledby="custom-tabs-four-vehicle_type-tab">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <p>
                    @include('admin-ts3/vehicle/tambah_vehicle_type')
                    </p>
                    <form action="{{ asset('admin-ts3/vehicle/proses-vehicle-type') }}" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <div class="row">
                    
                    <div class="col-md-12">
                        <div class="btn-group">
                        <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
                            <i class="fa fa-trash"></i>
                        </button> 
                            <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah_vehicle_type">
                                <i class="fa fa-plus"></i> Tambah Baru
                            </button>
                    </div>
                    </div>
                    </div>
                    
                    <div class="clearfix"><hr></div>
                    <div class="table-responsive mailbox-messages">
                        <div class="table-responsive mailbox-messages">
                    <table id="example3" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="bg-info">
                            <th width="5%">
                            <div class="mailbox-controls">
                                    <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                    </button>
                                </div>
                            </th>
                            <th width="15%">Group</th>
                            <th width="45%">Type</th>
                            <th width="10%">Tahun</th>
                            <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php $i=1; foreach($vehicle_type as $vt) { ?>
                
                        <td class="text-center">
                        <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $vt->id ?>" id="check<?php echo $i ?>">
                                <label for="check<?php echo $i ?>"></label>
                        </div>
                    
                    
                    </td>
                    <td><?php echo $vt->group_vehicle ?></td>
                    <td><?php echo $vt->type ?></td>
                    <td><?php echo $vt->tahun_pembuatan ?></td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ asset('admin-ts3/vehicle/edit-vehicle-type/'.$vt->id) }}" 
                        class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                
                        <a href="{{ asset('admin-ts3/vehicle/delete-vehicle-type/'.$vt->id) }}" class="btn btn-danger btn-sm  delete-link">
                            <i class="fa fa-trash"></i></a>
                        </div>
                
                    </td>
                    </tr> 
                
                    <?php $i++; } ?>
                
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </form>
                </div>
        
            </div>
        </div>
    
    </div>

</div>



