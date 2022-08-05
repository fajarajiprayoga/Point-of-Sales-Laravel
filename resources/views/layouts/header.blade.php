 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a href="" class="nav-link" data-toggle="dropdown">{{ auth()->user()->name }}</a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-center">
            <span class="text-sm">Edit Profile</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-center" onclick="$('#logout-form').submit()">
          <span class="text-sm">Logout</span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <form action="{{ route('logout') }}" method="POST" style="display: none" id="logout-form">
  @csrf
  </form>