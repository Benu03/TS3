@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/general/proses_edit') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $general->id ?>">

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Name</label>
	<div class="col-sm-9">
		<input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $general->name ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Value 1</label>
	<div class="col-sm-9">
		<input type="text" name="value_1" class="form-control" placeholder="Value 1" value="<?php echo $general->value_1 ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Value 2</label>
	<div class="col-sm-9">
		<input type="text" name="value_2" class="form-control" placeholder="Value 2" value="<?php echo $general->value_2 ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Description</label>
	<div class="col-sm-9">
		<textarea name="desc" id="desc" class="form-control" id="desc" placeholder="Description"><?php echo $general->desc ?></textarea>

	</div>
</div>



<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('admin-ts3/general') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

