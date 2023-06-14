@extends('admin.master.master-admin')

@section('content')
<div class="row">
  <div class="col-md-12">

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Title</th>
          <th scope="col">Categories</th>
          <th scope="col">Uploaded By</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $item)
        <tr>
        <th scope="row">{{ $item->id }}</th>
        <td>{{ $item->title }}</td>
        <td>{{ $item->categories }}</td>
        <td>{{ $item->user_posts->name }}</td>
        <td>
          <form id="delete-posts">
            <input type="hidden" readonly value="{{ $item->id }}">
            <button type="submit" class="bi bi-trash"> Delete</button>
          </form>
          <button class= "bi bi-search mt-2">Detail Posts</button>
        </td>
            
      </tr>
        @endforeach        
      </tbody>
    </table>

  </div>
</div>
@push('jquery')
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>    
@endpush
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
});

$(document).ready(function () {
  
});

</script>

@endsection