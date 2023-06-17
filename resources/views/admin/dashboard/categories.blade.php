@extends('admin.master.master-admin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#categories-modal">Add New Categories</button>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Categories</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($categories as $item)
        <tr>
        <th scope="row">{{ $item->id }}</th>
        <td>{{ $item->name }}</td>
        <td>
          <button class="bi bi-trash" onclick="deleteCategories({{ $item->id }})"> Delete</button>
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
                  <form action="" enctype="multipart/form-data" id="add_category_form">
                    <div class="form-group mt-3">
                      <label for="title" class="form-label">Name</label>
                      <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <button class="btn btn-primary mt-5" type="submit" id="btn-upload-categories">Submit</button>
                    <button class="btn btn-primary mt-5 d-none" type="submit" disabled id="btn-loading-upload-categories">
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

  $("#add_category_form").on("submit", function(e){
    e.preventDefault();
    let data = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "{{ url('/dashboard/categories/add') }}",
      data: data,
      dataType: "JSON",
      beforeSend: function (){  
        $("#btn-loading-upload-categories").removeClass('d-none');
        $("#btn-upload-categories").addClass('d-none');
      },
      success: function (response) {
        if(response.code == 200) {
          $("#btn-loading-upload-categories").addClass('d-none');
          $("#btn-upload-categories").removeClass('d-none');
          Swal.fire(
            'Success!',
            response.messages,
            'success'
          )

        } else if (response.code == 422) {
            $.each(response.data,function(field_name,error) {
                $(document).find('[id='+field_name+']').after('<div class="invalid-feedback d-block">' + error + '</div>')
            })
        }
        
      },error: function (err) {
            $.each(err.responseJSON.errors, function (key, value) {
                $("#" + key).next().html(value[0]);
                $("#" + key).next().removeClass('d-none');
            });
        }
    });
  })
  
});


function deleteCategories(id) {
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
          url: "{{ url('/dashboard/categories/delete/') }}/" + id,
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