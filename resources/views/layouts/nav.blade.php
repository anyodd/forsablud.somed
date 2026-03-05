<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <h5 class="nav-link"><strong>{{nm_unit()}} - {{ Tahun() }}</strong></h5>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="theme-switch-wrapper nav-link">
          <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox">
            <div class="slider round"></div>
          </label>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link d-sm-inline-block" data-toggle="dropdown" href="#">
          <img src="{{ asset('template') }}/dist/img/icon_login/profile.png" class="nav-icon img-circle img-size-32 mr-2">
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-secondary">
          <span class="dropdown-item dropdown-header bg-primary">{{ getUser('username') }}</span>
          <a href="{{route('user.show',getUser('user_id'))}}" class="dropdown-item">Profile</a>
          <a href="{{route('logout')}}" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
<!-- /.navbar -->