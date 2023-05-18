@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('bengkel/service-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
	<input type="hidden" name="id" value="<?php echo $service->id ?>">



		


<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Simpan">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('bengkel/list-service') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

