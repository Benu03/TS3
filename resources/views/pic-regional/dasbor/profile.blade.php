@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p>
  @include('pic/dasbor/change_password')
</p>
<p class="text-right">

  <button type="button" class="btn btn-warning " data-toggle="modal" data-target="#Change">
    <i class="fas fa-key"></i> Ubah Password
  </button>
  
	<a href="{{ asset('pic/dasbor') }}" class="btn btn-success">
		<i class="fa fa-backward"></i> Kembali
	</a>
</p>

<hr>

<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="img img-thumbnail img-fluid" src="{{ asset('assets/upload/user/thumbs/'.$user->gambar) }}" >
        </div>

        <h3 class="profile-username text-center">{{ $user->username }}</h3>
		{{-- <h3 class="profile-username text-center">{{ $user->username }}</h3> --}}
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <div class="col-md-9">
    	<div class="card card-primary">
    	<div class="card-header">
                <h3 class="card-title">Detail Data Profile  {{  $user->nama }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
    	<table class="table table-bordered">
    		<thead>
    			<tr>
    				<th width="25%">Nama</th>
    				<th>{{  $user->nama }}</th>
    			</tr>
    		</thead>
    		<tbody>
          <tr>
    				<td width="25%">Email</td>
    				<td>{{  $user->email }}</td>
    			</tr>
          <tr>
    				<td width="25%">Role</td>
    				<td>{{  $user->role_title }}</td>
    			</tr>
    			<tr>
    				<td>Created Date</td>
    				<td>{{ $user_m->created_at }}</td>
    			</tr>
          <tr>
    				<td>Created By</td>
    				<td>{{ $user_m->create_by }}</td>
    			</tr>

          <tr>
    				<td>Update Date</td>
    				<td>{{ $user_m->updated_at }}</td>
    			</tr>

          <tr>
    				<td>Update By</td>
    				<td>{{ $user_m->update_by }}</td>
    			</tr>

          <tr>
    				<td>Status</td>
    				<td>
              <?php if($user_m->is_active == 1 ) { 
                echo 'Active';               
              }else {
                echo 'Non Active'; 
              } ?>
            
        </td>
    			</tr>
    		
    		</tbody>
    	</table>
</div>
</div>
</div>
    </div>
</div>