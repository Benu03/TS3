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
<form action="{{ asset('bengkel/invoice-create-proses') }}" method="post" accept-charset="utf-8">
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

				</div>


</div> 

</div>

<div class="clearfix"><hr></div>

     
                        
                        <div class="row form-group">   
                             {{-- begin form	 --}} 
                            <div class="col-sm-12">	                               

                                 <ul class="list-group">
                                                  
                                    <div id="show_item_service">	
                                        <li class="list-group-item list-group-item-light">
                                            <div class="row form-group">   
                                                 <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label text-left">Service no</label>
                                                        <div class="col-sm-4">
                                                            <select name="service_no[]" class="form-control select2">
                                                                <?php foreach($serviceinvoice as $si) { ?>
                                                                <option value="<?php echo $si->service_no ?>"><?php echo $si->service_no ?></option>
                                                                <?php } ?>													
                                                                </select>
                                                        </div>
                                                    </div>
                                                 </div>  
                                            </div>      
                                            <div class="row form-group">   
                                                    <div class="col-sm-6">	   								          
                                                        <div class="card bg-light mb-3">
                                                            <div class="card-header">Jasa</div>
                                                            <div class="card-body">
                                                                <div id="show_item_jobs">	
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-3 control-label text-left">Pekerjaan</label>
                                                                        <div class="col-sm-6">
                                                                            <select name="jobs[]" class="form-control select2">
                                                                                <?php foreach($priceJobs as $pj) { ?>
                                                                                <option value="<?php echo $pj->kode ?>"><?php echo $pj->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-success  add_more_jobs" type="button">
                                                                                    <i class="fas fa-plus-circle"></i> Add
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>        
                                                                </div>
                                                            </div>
                                                          </div>
                                                              
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card bg-light mb-3">
                                                            <div class="card-header">Spare Part</div>
                                                            <div class="card-body">
                                                                <div id="show_item_part">	
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-6">
                                                                            <select name="part[]" class="form-control select2">
                                                                                <?php foreach($pricePart as $pp) { ?>
                                                                                <option value="<?php echo $pp->kode ?>"><?php echo $pp->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-success  add_more_part" type="button">
                                                                                    <i class="fas fa-plus-circle"></i> Add
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>        
                                                                </div>
                                                
                                                            </div>
                                                          </div>                                                       
                                                    </div>  
                                            </div>    
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label text-right"></label>
                                                <div class="col-sm-8 text-right">
                                                    <div class="form-group pull-right btn-group">
                                                        <button class="btn btn-success  add_more_service" type="button">
                                                            <i class="fas fa-plus-circle"></i> Add
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            
                                         </li>

                                    </div>
                                </ul>

                                {{-- end form --}}
                            </div>

                        </div>






</form>

<script>
    $('#reservation').daterangepicker()
</script>




<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_part").click(function(e){ 
          e.preventDefault();
		  $("#show_item_part").prepend(`<div class="form-group row">
                                                                     
                                                                        <div class="col-sm-6">
                                                                            <select name="jobs[]" class="form-control select2">
                                                                                <?php foreach($pricePart as $pp) { ?>
                                                                                <option value="<?php echo $pp->kode ?>"><?php echo $pp->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-danger remove_more_part" type="button">
                                                                                    <i class="fas fa-minus-circle"></i> remove
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>     `);
      });

	  $(document).on('click','.remove_more_part', function(e){
		e.preventDefault();
		let row_item_part = $(this).parent().parent().parent();
		$(row_item_part).remove();
	  });

    });
</script>



<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_jobs").click(function(e){ 
          e.preventDefault();
		  $("#show_item_jobs").prepend(`<div class="form-group row">
                                                                        <label class="col-sm-3 control-label text-left">Pekerjaan</label>
                                                                        <div class="col-sm-6">
                                                                            <select name="jobs[]" class="form-control select2">
                                                                                <?php foreach($priceJobs as $pj) { ?>
                                                                                <option value="<?php echo $pj->kode ?>"><?php echo $pj->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-danger remove_more_jobs" type="button">
                                                                                    <i class="fas fa-minus-circle"></i> remove
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>        `);
      });

	  $(document).on('click','.remove_more_jobs', function(e){
		e.preventDefault();
		let row_item_jobs = $(this).parent().parent().parent();
		$(row_item_jobs).remove();
	  });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
      $(".add_more_service").click(function(e){ 
          e.preventDefault();
		  $("#show_item_service").prepend(`  <li class="list-group-item list-group-item-light">
                                            <div class="row form-group">   
                                                 <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label text-left">Service no</label>
                                                        <div class="col-sm-4">
                                                            <select name="service_no[]" class="form-control select2">
                                                                <?php foreach($serviceinvoice as $si) { ?>
                                                                <option value="<?php echo $si->service_no ?>"><?php echo $si->service_no ?></option>
                                                                <?php } ?>													
                                                                </select>
                                                        </div>
                                                    </div>
                                                 </div>  
                                            </div>      
                                            <div class="row form-group">   
                                                    <div class="col-sm-6">	   								          
                                                        <div class="card bg-light mb-3">
                                                            <div class="card-header">Jasa</div>
                                                            <div class="card-body">
                                                                <div id="show_item_jobs">	
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-3 control-label text-left">Pekerjaan</label>
                                                                        <div class="col-sm-6">
                                                                            <select name="jobs[]" class="form-control select2">
                                                                                <?php foreach($priceJobs as $pj) { ?>
                                                                                <option value="<?php echo $pj->kode ?>"><?php echo $pj->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-success  add_more_jobs" type="button">
                                                                                    <i class="fas fa-plus-circle"></i> Add
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>        
                                                                </div>
                                                            </div>
                                                          </div>
                                                              
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card bg-light mb-3">
                                                            <div class="card-header">Spare Part</div>
                                                            <div class="card-body">
                                                                <div id="show_item_part">	
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-6">
                                                                            <select name="part[]" class="form-control select2">
                                                                                <?php foreach($pricePart as $pp) { ?>
                                                                                <option value="<?php echo $pp->kode ?>"><?php echo $pp->service_name ?></option>
                                                                                <?php } ?>													
                                                                                </select>
                                                                        </div>
                                                                        <div class="col-sm-3 text-right">
                                                                            <div class="form-group pull-right btn-group">
                                                                                <button class="btn btn-success  add_more_part" type="button">
                                                                                    <i class="fas fa-plus-circle"></i> Add
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>        
                                                                </div>
                                                
                                                            </div>
                                                          </div>                                                       
                                                    </div>  
                                            </div>    
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label text-right"></label>
                                                <div class="col-sm-8 text-right">
                                                    <div class="form-group pull-right btn-group">
                                                        <button class="btn btn-danger remove_more_service" type="button">
                                                                                    <i class="fas fa-minus-circle"></i> remove
                                                                                </button>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            
                                         </li>`);
      });

	  $(document).on('click','.remove_more_service', function(e){
		e.preventDefault();
		let row_item_service = $(this).parent().parent();
		$(row_item_service).remove();
	  });

    });
</script>