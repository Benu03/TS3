
<div class="modal fade" id="Tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">Tambah data?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ asset('admin-ts3/general/tambah') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				{{ csrf_field() }}
				
				
				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Name</label>
					<div class="col-sm-9">
						<input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Value 1</label>
					<div class="col-sm-9">
						<input type="text" name="value_1" class="form-control" placeholder="Value 1" value="{{ old('value_1') }}" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Value 2</label>
					<div class="col-sm-9">
						<input type="text" name="value_2" class="form-control" placeholder="Value 2" value="{{ old('value_2') }}" >
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Description</label>
					<div class="col-sm-9">
						<textarea name="desc" id="desc" class="form-control" id="desc" placeholder="Description">{{ old('desc') }}</textarea>

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



