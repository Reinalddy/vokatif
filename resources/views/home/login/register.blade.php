@extends('home.login.master_login.main')

@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src= {{ asset('img/logo.png') }}
            class="img-fluid" alt="Sample image">
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form id="register-form" enctype="multipart/form-data">
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mt-4">
              <p class="lead fw-normal mb-0 me-3">Register to Vokatif</p>
              <button type="button" class="btn btn-info btn-floating mx-1">
                <i class="bi bi-google"></i>
              </button>

              <button type="button" class="btn btn-info btn-floating mx-1">
                <i class="bi bi-facebook"></i>
              </button>

            </div>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Register</p>
            </div>
            <input type="text" hidden readonly value="2" name="role_id">
            <!-- Email input -->
            <div class="form-outline mb-3">
              <input type="email" id="email" class="form-control form-control-lg" name="email"
                placeholder="Enter a valid email address" />
              <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- name input -->
            <div class="form-outline mb-3">
              <input id="name" class="form-control form-control-lg" name="name"
                placeholder="Enter Name" />
              <label class="form-label" for="form3Example3">Name</label>
            </div>

            <!-- Username input -->
            <div class="form-outline mb-3">
              <input id="username" class="form-control form-control-lg" name="username"
                placeholder="Enter a Username" />
              <label class="form-label" for="form3Example3">Username</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" id="password" class="form-control form-control-lg" name="password"
                placeholder="Enter password" />
              <label class="form-label" for="form3Example4">Password</label>
            </div>
            {{-- button register --}}
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-info btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Have an Account? <a href="{{ url('/login')  }}"
                  class="link-danger">Login</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
</section>
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

    $("#register-form").on("submit", function(e) {
      e.preventDefault();
      let formData = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "{{ url('/register') }}",
        data: formData,
        success: function (response) {
          if(response.code == 200) {
            Swal.fire({
                title: 'success',
                text: "Registration Success!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ok!'
              }).then((result) => {
                if (result.isConfirmed) {
                  location.href = '{{ url('/login') }}';
                }
              })
              location.href = '{{ url('/login') }}'
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







  });
</script>

@endsection