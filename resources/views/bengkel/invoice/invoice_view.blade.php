<div class="modal fade" id="invoice<?php echo $in->invoice_no ?>"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
				<div class="modal-header">
	
				<h4 class="modal-title mr-4" id="myModalLabel">Detail Invoice (<?php echo $in->invoice_no ?>)</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
					<div class="modal-body">
		
                        <div class="row mb-2">  
                                      
                                 <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">  
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                  

                                        </table>
                                </div> 
                                </div>
                            </div>
                              </div>           
                          </div>    
                          
                          <div class="row"> 
                            <div class="col-md-12 text-right">
                         
                                        <a href="{{ asset('bengkel/invoice-generate/')}}/<?php echo $in->invoice_no ?>"class="btn btn-secondary">
                                            <i class="far fa-file-excel"></i> Generate Invoice
                                        </a>
                                 
                                  </div>  
                            
                          </div>
				
		
					</div>
		</div>
	</div>
</div>