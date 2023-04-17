@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/client-product/proses_edit') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $clientdata->id ?>">
<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Client Name</label>
	<div class="col-sm-7">
		<input type="text" name="client_name" class="form-control" placeholder="]Client Name" value="<?php echo $clientdata->client_name ?>" required>
	</div>
</div>


<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Client Type</label>
	<div class="col-sm-7">
	
		<select name="client_type" class="form-control">
			<option hidden>Option</option>
			  <option value="<?php echo $clientdata->client_type ?>" <?php if($clientdata->client_type=='B2B') { echo 'selected'; } ?>>B2B</option>
			  <option value="<?php echo $clientdata->client_type ?>" <?php if($clientdata->client_type=='B2C') { echo 'selected'; } ?>>B2C</option>
			
		  </select>

	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('admin-ts3/client-product') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

