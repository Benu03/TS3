<div class="modal fade" id="directspk"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
				<div class="modal-header">
	
				<h4 class="modal-title mr-2" id="myModalLabel">Direct Service SPK </h4>  <h4 class="text-danger modal-title">{{ $direct->nopol }}</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
					<div class="modal-body">
														
						<input type="hidden" name="id" value="{{$direct->id }}">
						<input type="hidden" name="nopol" value="{{$direct->nopol }}">
						<input type="hidden" name="mst_branch_id" value="{{$direct->mst_branch_id }}">
								
						<div class="form-group row">
							<label class="col-sm-3 control-label text-right">SPK NO</label>
							<div class="col-sm-9">
								<input type="text" name="spk_no" class="form-control" placeholder="SPK NO" required>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label text-right">Tanggal Pengerjaan</label>
							<div class="col-sm-9">
								<input type="text" name="tanggal_pengerjaan" class="form-control" placeholder="SPK NO" value="{{ $direct->tanggal_pengerjaan }}" required readonly>
							</div>
						</div>
		
						<div class="form-group row">
							<label class="col-sm-3 control-label text-right">Tanggal Berlaku SPK Terakhir</label>
							<div class="col-sm-9">
								<input type="text" name="tanggal_last_spk" class="form-control tanggal" placeholder="Tanggal Berlaku SPK Terakhir" value="<?php if(isset($_POST['tanggal_last_spk'])) { echo old('tanggal_last_spk'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
							</div>
						</div>

						
						
							<div class="form-group row">
								<label class="col-sm-3 control-label text-right">Remark</label>
								<div class="col-sm-9">
									<textarea name="remark" class="form-control" id="remark" placeholder="Remark"></textarea>
			
								</div>
							</div>
							


							<div class="form-group row">
								<label class="col-sm-3 control-label text-right"></label>
								<div class="col-sm-9">
									<div class="form-group pull-right btn-group">
										<input type="submit" name="submit" class="btn btn-primary " value="Approve">
										<input type="reset" name="reset" class="btn btn-success " value="Reset">
										<button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>


					   
                        </div>
		</div>
	</div>
</div>