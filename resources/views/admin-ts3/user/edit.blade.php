@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/user/proses_edit') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<input type="hidden" name="id_user" value="<?php echo $user->id_user ?>">
<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Nama lengkap</label>
	<div class="col-sm-9">
		<input type="text" name="nama" class="form-control" placeholder="Nama lengkap" value="<?php echo $user->nama ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Email</label>
	<div class="col-sm-9">
		<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $user->email ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Username</label>
	<div class="col-sm-9">
		<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $user->username ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Password</label>
	<div class="col-sm-9">
		<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $user->password ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Role Akses</label>
	<div class="col-sm-9">
	
		<select name="role" class="form-control">
			<option hidden>Option</option>
			<?php foreach($roledata as $roles) { ?>
			  <option value="<?php echo $roles->id ?>" <?php if($user->id_role==$roles->id) { echo 'selected'; } ?>><?php echo $roles->role_title ?></option>
			<?php } ?>
		  </select>

	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Customer Entity</label>
	<div class="col-sm-9">
	
		<select name="customer" class="form-control">
			<option hidden>Option</option>
			<?php foreach($customerdata as $cus) { ?>
			  <option value="<?php echo $cus->id ?>" <?php if($usercustomer->mst_customer_id==$cus->id) { echo 'selected'; } ?>><?php echo $cus->customer_name.'-'.$cus->customer_type ?></option>
			<?php } ?>
		  </select>

	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Upload foto profil</label>
	<div class="col-sm-9">
		<input type="file" name="gambar" class="form-control" placeholder="Upload Foto" value="{{ old('gambar') }}">
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('admin-ts3/user') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

