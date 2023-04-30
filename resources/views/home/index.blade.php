@extends('home.master.master')

@section('content')
<section id="header">
  <div class="container header-content">
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-center">
        <div id="carouselExample" class="carousel slide w-50">
          <div class="carousel-inner">
            <div class="carousel-item active carousel-section">
              <img src="{{ asset('img/kasumi.png') }}" class="img-fluid" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>

</section>
@endsection