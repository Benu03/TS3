@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-ts3/spk-service-edit-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $spk->id ?>">



				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Tanggal Schedule</label>
					<div class="col-sm-9">
						<input type="text" name="tanggal_schedule" class="form-control tanggal" placeholder="Tanggal Schedule" value="<?php if(isset($_POST['tanggal_schedule'])) { echo old('tanggal_schedule'); }else{ echo date('Y-m-d'); } ?>" data-date-format="yyyy-mm-dd">	
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Bengkel</label>
					<div class="col-sm-9">
						<select name="mst_bengkel_id" id="mst_bengkel_id" class="form-control select2" width="100%">
							
							<?php foreach($bengkel as $bk) { ?>
							<option value="<?php echo $bk->id ?>" <?php if($spk->mst_bengkel_id==$bk->id) { echo 'selected'; } ?>><?php echo $bk->bengkel_name ?></option>
							<?php } ?>
						</select>
					</div>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 control-label text-right">Remark</label>
					<div class="col-sm-9">
						<textarea name="remark" class="form-control" id="remark" placeholder="Remark"><?php echo $spk->remark_ts3 ?></textarea>

					</div>
				</div>


<div class="form-group row">
	<label class="col-sm-3 control-label text-right"></label>
	<div class="col-sm-9">
		<div class="form-group pull-right btn-group">
			<input type="submit" name="submit" class="btn btn-primary " value="Proses Data">
			<input type="reset" name="reset" class="btn btn-success " value="Reset">
			<a href="{{ asset('admin-ts3/spk-list') }}" class="btn btn-danger">Kembali</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</form>

