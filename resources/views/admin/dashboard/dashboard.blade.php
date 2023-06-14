@extends('admin.master.master-admin')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
      <div class="card-header text-center h1">Postingan</div>
      <div class="card-body">
        <h5 class="card-title h2 text-center">Total Post</h5>
        <p class="card-text text-center font-weight-bold h2">{{ $posts }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-danger mb-3" style="max-width: 18rem;">
      <div class="card-header h1 text-center">Users</div>
      <div class="card-body">
        <h5 class="card-title h2 text-center">Total Users</h5>
        <p class="card-text h2 text-center">{{ $users }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-success mb-3" style="max-width: 18rem;">
      <div class="card-header text-center h1">Categories</div>
      <div class="card-body">
        <h5 class="card-title text-center h2">Total Categories</h5>
        <p class="card-text text-center h2">{{ $categories }}</p>
      </div>
    </div>
  </div>
</div>



@endsection