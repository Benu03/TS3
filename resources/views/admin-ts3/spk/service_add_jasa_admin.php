<div class="modal fade" id="AddJasaServiceAdmin"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header">
			
						<h4 class="modal-title mr-4" id="myModalLabel">Add Jasa</h4>
						
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
								<div class="modal-body">

					



								<div class="card card-info">
							<div class="card-header">
								<h3 class="card-title">Jasa</h3>
							</div>
							<div class="card-body">
							<input type="hidden" name="id" id="servicehid" value="<?php echo $service_h->id ?>">
								<div class="row form-group">

									<div class="col-sm-12">
										<div id="show_item_jobs">
											<div class="row form-group">
												<div class="col-sm-5">
											
													<select name="jobs" id="jobs" class="form-control select2">
						

															<?php foreach($jobs as $jb) { ?>
																<option value="<?php echo $jb->mst_price_service_id ?>" >
																<?php echo $jb->service_name.' ('.$jb->kode.')' ?></option>
															<?php } ?>		

													</select>

												</div>
												<div class="col-sm-5">
													<input type="text" name="value_jobs" class="form-control" placeholder="Remark" value="" required>
												</div>
												<div class="col-sm-2 text-right">
												<button class="btn btn-success add_more_jobs" type="button">
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
