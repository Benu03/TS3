<div class="modal fade" id="AddFotoServiceAdmin"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header">
			
						<h4 class="modal-title mr-4" id="myModalLabel">Add Foto</h4>
						
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
								<div class="modal-body">

					



								<div class="card card-info">
							<div class="card-header">
								<h3 class="card-title">Foto Service</h3>
							</div>
							<div class="card-body">
							<input type="hidden" name="id" id="servicehid" value="<?php echo $service_h->id ?>">
							<input type="hidden" name="id" id="servicehno" value="<?php echo $service_h->service_no ?>">
								<div class="row form-group">

									<div class="col-sm-12">
										<div id="show_item_jobs">
											<div class="row form-group">
												<div class="col-sm-5">
											
												<input type="file" name="upload_foto" id="upload_foto" class="form-control" placeholder="Upload File Service" required>

												</div>
												<div class="col-sm-5">
													<input type="text" name="value_foto" class="form-control" placeholder="Remark" value="" required>
												</div>
												<div class="col-sm-2 text-right">
												<button class="btn btn-success add_more_foto" type="button">
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
					 </div>    
					 
                    </div>
		
	</div>
