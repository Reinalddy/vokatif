@extends('home.master.master')

@section('content')

  <h1 class="text-center">My Post</h1>
  <div class="album py-5 bg-body-tertiary">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach ($posts as $item)
        <div class="col">
          <div class="card shadow-sm">
            <img src="{{ url("/storage/$item->image_path") }}" alt="" style="width: 100%", height="450px">
            <div class="card-body">
              <p class="card-text">{{ $item->title }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="{{ url("/detail-posts/$item->id") }}" class="btn btn-outline-info">Detail</a>
                </div>
                <small class="text-body-secondary">Uploded By : {{$item->user_posts->name }}</small>
              </div>
            </div>
          </div>
        </div>
            
        @endforeach

      </div>
    </div>
  </div>
@endsection