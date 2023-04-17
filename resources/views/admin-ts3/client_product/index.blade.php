    <div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item">
    <a class="nav-link active" id="custom-tabs-four-client-tab" data-toggle="pill" href="#custom-tabs-four-client" role="tab" aria-controls="custom-tabs-four-client" aria-selected="false">Client</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" id="custom-tabs-four-product-tab" data-toggle="pill" href="#custom-tabs-four-product" role="tab" aria-controls="custom-tabs-four-product" aria-selected="false">Product</a>
    </li>

    </ul>
    </div>
    <div class="card-body">
    <div class="tab-content " id="custom-tabs-four-tabContent">
    <div class="tab-pane active" id="custom-tabs-four-client" role="tabpanel" aria-labelledby="custom-tabs-four-client-tab">
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
        @include('admin-ts3/client_product/tambah')
        </p>
        <form action="{{ asset('admin-ts3/client-product/proses') }}" method="post" accept-charset="utf-8">
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
                <th width="45%">Client Name</th>
                <th width="20%">Type</th>
                <th width="20%">Create Date</th>
                <th>ACTION</th>
        </tr>
        </thead>
        <tbody>
        
        <?php $i=1; foreach($clientdata as $cl) { ?>
    
            <td class="text-center">
            <div class="icheck-primary">
                      <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $cl->id ?>" id="check<?php echo $i ?>">
                       <label for="check<?php echo $i ?>"></label>
            </div>
            {{-- <small class="text-center"><?php echo $i ?></small> --}}
        
        </td>
        <td><?php echo $cl->client_name ?></td>
        <td><?php echo $cl->client_type ?></td>
        <td><?php echo $cl->created_date ?></td>
        <td>
            <div class="btn-group">
            <a href="{{ asset('admin-ts3/client-product/edit/'.$cl->id) }}" 
              class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
    
              <a href="{{ asset('admin-ts3/client-product/delete/'.$cl->id) }}" class="btn btn-danger btn-sm  delete-link">
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
    <div class="tab-pane fade" id="custom-tabs-four-product" role="tabpanel" aria-labelledby="custom-tabs-four-product-tab">
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
        @include('admin-ts3/client_product/tambah_product')
        </p>
        <form action="{{ asset('admin-ts3/client-product/proses_product') }}" method="post" accept-charset="utf-8">
        {{ csrf_field() }}
        <div class="row">
        
        <div class="col-md-12">
            <div class="btn-group">
            <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
                <i class="fa fa-trash"></i>
            </button> 
                <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah_product">
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
                <th width="45%">Product Name</th>
                <th width="20%">Scheme</th>
                <th width="20%">Create Date</th>
                <th>ACTION</th>
        </tr>
        </thead>
        <tbody>
        
        <?php $i=1; foreach($product as $pd) { ?>
    
            <td class="text-center">
            <div class="icheck-primary">
                      <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $pd->id ?>" id="check<?php echo $i ?>">
                       <label for="check<?php echo $i ?>"></label>
            </div>
            {{-- <small class="text-center"><?php echo $i ?></small> --}}
        
        </td>
        <td><?php echo $pd->product_name ?></td>
        <td><?php echo $pd->scheme_db ?></td>
        <td><?php echo $pd->created_date ?></td>
        <td>
            <div class="btn-group">
            <a href="{{ asset('admin-ts3/client-product/edit_product/'.$pd->id) }}" 
              class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
    
              <a href="{{ asset('admin-ts3/client-product/delete_product/'.$pd->id) }}" class="btn btn-danger btn-sm  delete-link">
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



