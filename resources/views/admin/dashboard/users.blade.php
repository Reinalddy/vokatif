@extends('admin.master.master-admin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $item)
        <tr>
        <th scope="row">{{ $item->id }}</th>
        <td>{{ $item->name }}</td>
        <td>{{ $item->username }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->role_id }}</td>
        <td>
          <button class="bi bi-trash" onclick="deleteUsers({{ $item->id }})"> Delete</button>
        </td>
            
      </tr>
        @endforeach        
      </tbody>
    </table>

  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categories-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="container">
              <div class="mb-5">
                  <form action="" enctype="multipart/form-data" id="upload-form">
                    <div class="form-group mt-3">
                      <label for="title" class="form-label">Name</label>
                      <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <button class="btn btn-primary mt-5" type="submit" id="btn-upload">Submit</button>
                    <button class="btn btn-primary mt-5 d-none" type="submit" disabled id="btn-loading">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Loading...
                    </button>

                  </form>
              </div>
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('jquery')
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>    
@endpush
<script>
  
  $(document).ready(function () {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
  });
  
});

function deleteUsers(id) {
    Swal.fire({
    title: 'This data will deleted permanently Are You Sure ?',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: `NO`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "{{ url('/dashboard/users/delete/') }}/" + id,
          data: {'id' : id},
          dataType: "json",
          success: function (response) {
            console.log(response);
            if(response.code == 200) {
                Swal.fire(
                    'Success!',
                    response.messages,
                    'success'
                )
              } else if (response.code == 400) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: response.message,
                })

              }
          }
        });
    } else if (result.isDenied) {
      Swal.fire('Changes are not saved', '', 'info')
    }
  })
  // $.ajax({
  //   type: "post",
  //   url: "{{ url('/dashboard/delete/posts') }}/" + id,
  //   data: {'id' : id},
  //   dataType: "json",
  //   success: function (response) {
  //     if(response.code == 200) {
  //         Swal.fire(
  //             'Success!',
  //             response.messages,
  //             'success'
  //         )
  //       }
  //   }
  // });
}

</script>

@endsection