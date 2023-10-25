<div class="modal fade" id="DetailImage<?php echo $sd->service_d_id ?>"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
				<div class="modal-header">
	
				<h4 class="modal-title mr-4" id="myModalLabel">Image (<?php echo $sd->attribute ?>)</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
					<div class="modal-body">
		
							<div class="text-center">
							<img class="img img-thumbnail img-fluid" src="{{ asset('admin-client/report/get-image-service-detail/').'/'.$sd->attribute }}" >
						  </div>
						
						</div>           
					 </div>    
					 
                    </div>
		</div>
	</div>
</div>