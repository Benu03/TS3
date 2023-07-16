<div class="modal fade" id="AddPartServiceAdmin"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header">
			
						<h4 class="modal-title mr-4" id="myModalLabel">Add Spare Part</h4>
						
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
								<div class="modal-body">				



								<div class="card card-info">
							<div class="card-header">
								<h3 class="card-title">Spare Part</h3>
							</div>
							<div class="card-body">
							<input type="hidden" name="id" id="servicehid" value="<?php echo $service_h->id ?>">
								<div class="row form-group">

									<div class="col-sm-12">
										<div id="show_item_jobs">
											<div class="row form-group">
												<div class="col-sm-5">
											
													<select name="part" id="part" class="form-control select2">
						

															<?php foreach($part as $pa) { ?>
																<option value="<?php echo $pa->mst_price_service_id ?>" >
																<?php echo $pa->service_name.' ('.$pa->kode.')' ?></option>
															<?php } ?>		

													</select>

												</div>
												<div class="col-sm-5">
													<input type="text" name="value_part" class="form-control" placeholder="Remark" value="" required>
												</div>
												<div class="col-sm-2 text-right">
												<button class="btn btn-success add_more_part" type="button">
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
