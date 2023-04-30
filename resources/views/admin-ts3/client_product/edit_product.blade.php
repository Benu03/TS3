@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/product/proses-edit-product') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $product->id ?>">
<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Product Name</label>
	<div class="col-sm-7">
		<input type="text" name="product_name" class="form-control" placeholder="Product Name" value="<?php echo $product->product_name ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right">Scheme</label>
	<div class="col-sm-7">
		<input type="text" name="scheme_db" class="form-control" placeholder="Scheme" value="<?php echo $product->scheme_db ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Simpan Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('admin-ts3/product') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

