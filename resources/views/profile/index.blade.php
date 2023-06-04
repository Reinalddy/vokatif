@extends('home.master.master')

@section('content')
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="{{ url("storage/$user->profile_path") }}" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <form id="update-profil-picture">
                        <div class="form-group mt-3">
                        <input class="form-control" type="file" id="image" name="image" onchange="preview()">
                        <img id="frame" src="" class="img-fluid rounded w-50" />
                        </div>
                        <button class="btn btn-primary mt-3" type="submit" id="btn-upload">Upload Image</button>
                        <button class="btn btn-primary mt-5 d-none" type="submit" disabled id="btn-loading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form id="update-profile-data">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="username">Username</label>
                            <input class="form-control" id="username" type="text" placeholder="Enter your username" name="username" value="{{ $user->username }}">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group ( name)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="inputLastName">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter your last name" name="name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control" id="email" type="email" placeholder="Enter your email address" name="email" value="{{ $user->email }}">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (old password)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="old-password">Old password</label>
                                <input class="form-control" id="old-password" type="tel" placeholder="Enter your old password" name="old_password">
                            </div>
                            <!-- Form Group (new password)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="new-password">New passowrd</label>
                                <input class="form-control" id="new-password" type="text" name="password" placeholder="Enter your new password">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit" id="btn-upload-data">Save changes</button>
                        <button class="btn btn-primary mt-5 d-none" type="submit" disabled id="btn-loading-data">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </form>
                </div>
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

    $("#update-profil-picture").on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "{{ url('/profile') }}",
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
            location.reload();

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

    $("#update-profile-data").on('submit', function(e){
      e.preventDefault();
      let formData = $( this ).serialize();
      console.log(formData);
      $.ajax({
        type: "POST",
        url: "{{ url('/profile/data') }}",
        data: formData,
        dataType: "json",
        beforeSend:function() {
            $("#btn-upload-data").addClass( "d-none" );
            $("#btn-loading-data").removeClass( "d-none" );

        },
        success:function(response){
          if(response.code == 200) {
            $("#btn-loading-data").addClass( "d-none" );
            $("#btn-upload-data").addClass( "d-block" );
            Swal.fire(
              'Success!',
              response.messages,
              'success'
            )
            location.reload();

          } else if (response.code == 422) {
            $.each(response.data,function(field_name,error){
                $(document).find('[id='+field_name+']').after('<div class="invalid-feedback d-block">' + error + '</div>')
              })
            $("#btn-loading-data").addClass( "d-none" );
            $("#btn-upload-data").removeClass( "d-none");
          } else if(response.code == 400) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: response.messages,
            })
            $("#btn-loading-data").addClass( "d-none" );
            $("#btn-upload-data").addClass( "d-block" );
          }
          
          else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
            $("#btn-loading-data").addClass( "d-none" );
            $("#btn-upload-data").addClass( "d-block" );
          }
        }, error: function(error) {
            $("#btn-loading-data").addClass( "d-none" );
            $("#btn-upload-data").addClass( "d-block" );
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
</script>
@endsection