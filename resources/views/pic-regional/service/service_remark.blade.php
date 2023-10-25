<div class="modal fade" id="servicepic"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
				<div class="modal-header">
	
				<h4 class="modal-title mr-4" id="myModalLabel">Service Remark</h4>
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
					<div class="modal-body">
						<form action="{{ asset('pic/service/service-remark') }}" method="post" accept-charset="utf-8">
							{{ csrf_field() }}
					
							<div class="form-group row">
								<label class="col-sm-3 control-label text-right">Komentar</label>
								<div class="col-sm-9">
									 <textarea name="remark" class="form-control" id="remark" placeholder="Remark">{{ old('remark') }}</textarea>
									 
								</div>
							</div>
							
							
							<div class="form-group row">
								<label class="col-sm-3 control-label text-right"></label>
								<div class="icheck-primary d-inline">
									<input type="radio" id="radioPrimary1" name="rating" value="cukup puas" >
									<label for="radioPrimary1">Cukup Puas
									</label>
								</div>
							</div>
				
							<div class="form-group row">
								<label class="col-sm-3 control-label text-right"></label>
								<div class="icheck-primary d-inline">
									<input type="radio" id="radioPrimary2" name="rating"  value="puas" checked="">
									<label for="radioPrimary2">Puas
									</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label text-right"></label>
								<div class="icheck-primary d-inline">
									<input type="radio" id="radioPrimary3"  value="sangat puas" name="rating">
									<label for="radioPrimary3">Sangat Puas
									</label>
								</div>
							</div>
							


							<div class="form-group row">
								<label class="col-sm-3 control-label text-right"></label>
								<div class="col-sm-9">
									<div class="form-group pull-right btn-group">
										<input type="submit" name="submit" class="btn btn-primary " value="Kirim">
										<input type="reset" name="reset" class="btn btn-success " value="Reset">
										<button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

						</form>
					   
                        </div>
		</div>
	</div>
</div>