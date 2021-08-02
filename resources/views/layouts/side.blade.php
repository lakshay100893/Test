<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="{{ route('profile') }}" class="nav-link">
        <div class="nav-profile-image">
          @auth
          <img src="{{ asset( (Auth::user()->avtar) ? Auth::user()->avtar : 'assets/images/faces/face1.jpg') }}" width="32px" height="32px" alt="profile">
          @endauth
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          @auth
          <span class="font-weight-bold mb-2">{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
          <span class="text-secondary text-small">{{Auth::user()->getRoleNames()->implode('name',',')}}</span>
          @endauth
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    
    @canany(['User Add','User List'])
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">User's</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          @can('User Add')
          <li class="nav-item"> <a class="nav-link" href="{{ route('register') }}">Add</a></li>
          @endcan
          @can('User List')
          <li class="nav-item"> <a class="nav-link" href="{{ route('Userlist') }}">List</a></li>
          @endcan
        </ul>
      </div>
    </li>
    @endcanany

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Agencie & Hospital</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-playlist-play menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          @can('User Add')
          <li class="nav-item"> <a class="nav-link" href="{{ route('agencie') }}">Agencie's</a></li>
          @endcan
          @can('User List')
          <li class="nav-item"> <a class="nav-link" href="{{ route('Userlist') }}">Hospital's</a></li>
          @endcan
        </ul>
      </div>
    </li>

    @canany(['Add Role','Add Permission'])
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#rolePermission" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Role's & Permission's</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-key menu-icon"></i>
      </a>
      <div class="collapse" id="rolePermission">
        <ul class="nav flex-column sub-menu">
          @can('Add Role')
          <li class="nav-item"> <a class="nav-link" href="{{ route('role') }}">Add Role</a></li>
          @endcan
          @can('Add Permission')
          <li class="nav-item"> <a class="nav-link" href="{{ route('permission') }}">Add Permission</a></li>
          @endcan
        </ul>
      </div>
    </li>
    @endcanany
   
  </ul>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
  @csrf
</form>