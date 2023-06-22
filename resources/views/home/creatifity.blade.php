@extends('home.master.master')

@section('content')
<style>
  .center{
    width: 100%;
    height: 100%;
  }
</style>
<!-- Hero -->
<div class="p-5 text-center bg-image rounded-3" style="
    background-image: url('{{ url("/storage/$banner_post->image_path") }}');
    height: 400px;
  ">
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mb-3">{{ $banner_post->title }}</h1>
        <h4 class="mb-3">{{ $banner_post->descriptions }}</h4>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12">
    <input type="text" class="form-control w-25 mt-3 mb-3 ms-5" placeholder="Search" id="search_column" oninput="search(this.value)">
</div>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="content">
      </div>



    </div>
  </div>
</div>

{{-- modal --}}

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload New Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="container">
              <div class="mb-5">
                  <form action="" enctype="multipart/form-data" id="upload-form">
                    <div class="form-group mt-3">
                      <label for="Image" class="form-label">Upload Image</label>
                      <input class="form-control" type="file" id="image" name="image" onchange="preview()">
                      <img id="frame" src="" class="img-fluid" />
                    </div>
                    <div class="form-group mt-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group mt-3">
                      <label for="description" class="form-label">Description</label>
                      <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group mt-3">
                      <label for="tags" class="form-label">Tags</label>
                      <select name="tags" id="tags" class="form-control">
                        <option value="0" selected disabled>Selecet Tags</option>
                      </select>
                    </div>

                    <button class="btn btn-primary mt-5" type="submit" id="btn-upload">Upload</button>
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
  // setup csrf token for ajax request
  $(document).ready(function () {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
    });
    fetch_data();
    // request for logout
    $('.sub-menu-wrap').on('click','#logout-button', function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "{{ url('/logout') }}",
        success: function (response) {
          if(response.code == 200) {

              location.href =  '{{ url('/login') }}'
          } else if (response.code == 400) {


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
    });

    $("#upload-form").on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "{{ url('/upload') }}",
        data: new FormData(this),
        dataType: "json",
        processData: false,
        contentType: false,
        beforeSend:function() {
          $("#btn-upload").addClass( "d-none" );
          $("#btn-loading").removeClass( "d-none" );
        },
        success:function(response){
          if(response.code == 200) {
            $("#btn-loading").addClass( "d-none" );
            $("#btn-upload").addClass( "d-block" );
            Swal.fire(
              'Success!',
              response.messages,
              'success'
            )
            $('#exampleModal').modal('hide');

          } else if (response.code == 422) {
            $.each(response.data,function(field_name,error){
                $(document).find('[id='+field_name+']').after('<div class="invalid-feedback d-block">' + error + '</div>')
              })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
          }
        }, error: function(error) {
            console.log("error = " + error);
            $("#btn-loading").removeClass( "d-none" );
            $("#btn-upload").addClass( "d-block" );
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
        }
      });
    });







  });

function preview() {
  frame.src = URL.createObjectURL(event.target.files[0]);
}

function clearImage() {
  document.getElementById('formFile').value = null;
  frame.src = "";
}

function search(value) {
  var data_html = '';
  var data = {
    name: value
  }
  $.ajax({
    type: "post",
    url: "{{ url('/creatifity/search') }}",
    data:data,
    dataType: "json",
    success: function (response) {
      if(response.code == 200) {
        response.data.forEach(element => {
          console.log(element);
           data_html += `
            <div class="col">
              <div class="card shadow-sm">
                <img src="{{ url("/storage/") }}/${element.image_path}" alt="" style="width: 100%", height="450px">
                <div class="card-body">
                  <p class="card-text">${element.title}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="{{ url("/detail-posts/") }}/${element.id}" class="btn btn-outline-info">Detail</a>
                    </div>
                    <small class="text-body-secondary">Uploded By : ${element.user_posts.name}</small>
                  </div>
                </div>
              </div>
            </div>
          `;
          
        });
        $("#content").html(data_html);

      }
    }
  });
}

function fetch_data() {
   var data = '';
  $.ajax({
    type: "GET",
    url: "{{ url('/creatifity/list') }}",
    data: "data",
    dataType: "json",
    success: function (response) {
      if(response.code == 200) {
        response.data.forEach(element => {
          console.log(element);
          data += `
          
            <div class="col">
              <div class="card shadow-sm">
                <img src="{{ url("/storage/") }}/${element.image_path}" alt="" style="width: 100%", height="450px">
                <div class="card-body">
                  <p class="card-text">${element.title}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="{{ url("/detail-posts/") }}/${element.id}" class="btn btn-outline-info">Detail</a>
                    </div>
                    <small class="text-body-secondary">Uploded By : ${element.user_posts.name}</small>
                  </div>
                </div>
              </div>
            </div>
          
          `;
        });
        console.log(data);
        $("#content").html(data);
      }
    }
  });
}
</script>
@endsection