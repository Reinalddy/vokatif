@extends('home.master.master')

@section('content')
{{-- crausel --}}
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Example headline.</h1>
            <p>Some representative placeholder content for the first slide of the carousel.</p>
            <p><a class="btn btn-outline-info" href="register">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
        <div class="container">
          <div class="carousel-caption">
            <h1>Another example headline.</h1>
            <p>Some representative placeholder content for the second slide of the carousel.</p>
            <p><a class="btn btn-outline-info" href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>One more for good measure.</h1>
            <p>Some representative placeholder content for the third slide of this carousel.</p>
            <p><a class="btn btn-outline-info" href="#">Browse Creativity</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>
{{-- end crausel --}}
<div class="row">
  <div class="col-md-12">
    <!-- Button trigger modal -->
    <div class="btn-group mx-5 mb-5" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-primary">Left</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload</button>
      <button type="button" class="btn btn-primary">Right</button>
    </div>
  </div>
</div>


  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          @foreach ($post as $item)
          <div class="col">
            <div class="card shadow-sm">
              <img src="{{ url("/storage/$item->image_path") }}" alt="" style="width: 100%", height="225px">
              <div class="card-body">
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-info">View</button>
                  </div>
                  <small class="text-body-secondary">9 mins</small>
                </div>
              </div>
            </div>
          </div>
          @endforeach
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
        dataType: "dataType",
        processData: false,
        contentType: false,
        beforeSend: function() {
          $("#btn-upload").addClass( "d-none" );
          $("#btn-loading").removeClass( "d-none" );
        },
        success: function (response) {

          if(response.code == 200) {
            $("#btn-loading").removeClass( "d-none" );
            $("#btn-upload").addClass( "d-none" );
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
            $("#btn-loading").removeClass( "d-none" );
            $("#btn-upload").addClass( "d-none" );
            Swal.fire(
              'Success!',
              error.messages,
              'success'
            )
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
</script>
@endsection