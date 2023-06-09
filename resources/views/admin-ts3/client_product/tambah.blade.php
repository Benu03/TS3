
<div class="modal fade" id="Tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">Tambah data?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ asset('admin-ts3/client/tambah') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			{{ csrf_field() }}
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Client Name</label>
					<div class="col-sm-9">
						<input type="text" name="client_name" class="form-control" placeholder="Client Name" value="{{ old('client_name') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Legal Name</label>
					<div class="col-sm-9">
						<input type="text" name="legal_name" class="form-control" placeholder="Legal Name" value="{{ old('legal_name') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Address</label>
					<div class="col-sm-9">
						<textarea name="address" id="address" class="form-control" id="address" placeholder="Address">{{ old('address') }}</textarea>

					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Contact</label>
					<div class="col-sm-9">
						<input type="text" name="contact" class="form-control" placeholder="Contact" value="{{ old('contact') }}" required>
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Email</label>
					<div class="col-sm-9">
						<input type="text" name="email_client" class="form-control" placeholder="Email" value="{{ old('email_client') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Logo</label>
					<div class="col-sm-9">
						<input type="file" name="img_client" class="form-control" placeholder="Logo" value="{{ old('img_client') }}">
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Client Type</label>
					<div class="col-sm-9">
						<select name="client_type" id="client_type" class="form-control">
							<option hidden>Option</option>
							<option value="B2B">B2B</option>
							<option value="B2C">B2C</option>
						  </select>
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Product</label>
					<div class="col-sm-9">			
						<select name="mst_product_id[]" id="mst_product_id" class="form-control select2" multiple="multiple">
						
							<?php foreach($product as $pd) { ?>
							  <option value="<?php echo $pd->id ?>"><?php echo $pd->product_name ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right"></label>
					<div class="col-sm-9">
						<div class="form-group pull-right btn-group">
							<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
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



