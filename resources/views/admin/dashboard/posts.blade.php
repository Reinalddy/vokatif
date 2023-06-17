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
        <td>{{ $item->categories->name }}</td>
        <td>{{ $item->user_posts->name }}</td>
        <td>
          <button class="bi bi-trash" onclick="deletePosts({{ $item->id }})"> Delete</button>
          <button class= "bi bi-search mt-2" onclick="open_modal_detail_posts({{ $item->id }})">Detail Posts</button>
        </td>
            
      </tr>
        @endforeach        
      </tbody>
    </table>

  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="detailPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Posts</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="container">
              <div class="mb-5">
                <div class="row">
                  <div class="col-md-12">
                    <p class="h3 font-weight-bold text-center" id="title-posts"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <p id="desc-posts" class=""></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <img alt="posts" id="photo-posts" class="w-50">
                  </div>
                </div>
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

function open_modal_detail_posts(id){
      $.ajax({
        type: "POST",
        data: {'id' : id},
        dataType: 'json', 
        url: "{{ url('/dashboard/posts') }}",
        success: function (response) {
          if(response.code == 200) {
            $("#title-posts").html(response.data.title)
            $("#desc-posts").html(response.data.descriptions)
            $('#detailPostModal').modal('show');
            $('#photo-posts').attr("src","{{ url('/storage') }}/" + response.data.image_path )

          } else if (response.code == 400) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: response.messages,
            })

          } else if (response.code == 422) {
              $.each(response.data,function(field_name,error){
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
}


function deletePosts(id) {
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
          url: "{{ url('/dashboard/delete/posts') }}/" + id,
          data: {'id' : id},
          dataType: "json",
          success: function (response) {
            if(response.code == 200) {
                Swal.fire(
                    'Success!',
                    response.messages,
                    'success'
                )
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