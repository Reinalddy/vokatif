<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Navbar brand -->
      <a class="navbar-brand mt-2 mt-lg-0" href="/">
        <img
          src="{{ asset('img/logo.png') }}"
          height="35"
          alt="MDB Logo"
          loading="lazy"
        />
      </a>
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-5">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/creatifity') }}">Creatifity</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/about-us') }}">About Us</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
      @if ($user)

        @if($user->profile_path == url('/img/profile_default.jpg'))
        <img src="{{ $user->profile_path }}" alt="" class="user-pic" onclick="toggleMenu()" id="toggle-menu">
        @else
        <img src="{{ url("storage/$user->profile_path" ) }}" alt="" class="user-pic" onclick="toggleMenu()" id="toggle-menu">

      <!-- Button trigger modal -->
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Upload
        </button>

        <img src="{{ asset('/img/logo.png') }}" alt="" class="user-pic" onclick="toggleMenu()" id="toggle-menu">


        @endif
        <div class="sub-menu-wrap" id="subMenu">
          <div class="sub-menu">
            <div class="user-info">
              @if($user->profile_path == url('/img/profile_default.jpg'))
              <img src="{{ $user->profile_path }}" alt="">

              @else
              <img src="{{ url("storage/$user->profile_path") }}" alt="">
              @endif
              <h2 style="margin-left: 5%">{{ $user->name }}</h2>
            </div>
            <hr>
            <div>
              <a href="{{ url('/profile') }}" class="sub-menu-link">
                <p>Edit Profile</p>
              </a>
            </div>
            <div>
              <a href="{{ url('/settings') }}" class="sub-menu-link">
                <p>Settings</p>
              </a>
            </div>
            <div>
              <a href="" class="sub-menu-link" id="logout-button">
                <p>Log Out</p>
              </a>
            </div>            
          </div>
        </div>

      @else
        <a href="{{ url('/login') }}" class="btn btn-outline-info me-2">Login</a>
        <a href="{{ url('/register') }}" class="btn btn-info me-5">Register</button></a>
      @endif

      <!-- Notifications -->
      <!-- Avatar -->

    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->

<script>
  let subMenu = document.getElementById('subMenu');

  function toggleMenu() {
    subMenu.classList.toggle('open-menu');
    
  }
  
</script>
