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
          <form id="login-form">
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
              <p class="lead fw-normal mb-0 me-3">Sign in to Vokatif</p>
              <button type="button" class="btn btn-info btn-floating mx-1">
                <i class="bi bi-google"></i>
              </button>

              <button type="button" class="btn btn-info btn-floating mx-1">
                <i class="bi bi-facebook"></i>
              </button>
            </div>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Login</p>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="email" class="form-control form-control-lg" name="email"
                placeholder="Enter a valid email address" />
              <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" id="password" class="form-control form-control-lg" name="password"
                placeholder="Enter password" />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <a href="#!" class="text-body">Forgot password?</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-info btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ url('/register')  }}"
                  class="link-danger">Register</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div
      class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-info">
      <!-- Copyright -->
      <div class="text-white mb-3 mb-md-0">

        Vokatif Copyright © 2020. All rights reserved.
      </div>
      <!-- Copyright -->

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

    $("#login-form").on("submit", function(e) {
      e.preventDefault();
      let formData = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "{{ url('/login') }}",
        data: formData,
        success: function (response) {
          if(response.code == 200) {
              location.href = '{{ url('/') }}'
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