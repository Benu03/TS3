
<div class="modal fade" id="Change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">Ubah Password ?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ asset('pic/profile/ubah-password') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				{{ csrf_field() }}


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Username</label>
					<div class="col-sm-9">
						<input type="text" name="username" class="form-control" placeholder="Username" value="{{ $user->email }}" readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Masukan Password</label>
					<div class="col-sm-9">
						<input type="password" name="password1" class="form-control" placeholder="Masukan Password"   autocomplete="off"  required>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Verifikasi Password</label>
					<div class="col-sm-9">
						<input type="password" name="password2" class="form-control" placeholder="Verifikasi Password" autocomplete="off"  required>
					</div>
				</div>			


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right"></label>
					<div class="col-sm-9">
						<div class="form-group pull-right btn-group">
							<input type="submit" name="submit" class="btn btn-primary " value="Ubah Password">
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



