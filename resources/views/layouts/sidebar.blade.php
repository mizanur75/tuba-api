<div class="sidebar" data-background-color="dark">
	<div class="sidebar-logo">
	<!-- Logo Header -->
	<div class="logo-header" data-background-color="dark">

	  <a href="{{route('dashboard')}}" class="logo">
	    <img src="assets/img/admin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
	  </a>
	  <div class="nav-toggle">
	    <button class="btn btn-toggle toggle-sidebar">
	      <i class="gg-menu-right"></i>
	    </button>
	    <button class="btn btn-toggle sidenav-toggler">
	      <i class="gg-menu-left"></i>
	    </button>
	  </div>
	  <button class="topbar-toggler more">
	    <i class="gg-more-vertical-alt"></i>
	  </button>

	</div>
	<!-- End Logo Header -->  
	</div>  
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
		  <ul class="nav nav-secondary">
		    <li class="nav-item {{Request::is('dashboard') ? 'active':''}}">
		      <a href="{{route('dashboard')}}">
		        <i class="fas fa-home"></i>
		        <p>Dashboard</p>
		      </a>
		    </li>
		    <li class="nav-item {{request()->routeIs('permissions.*') ? 'active' : ''}}">
		      <a href="{{route('permissions.index')}}">
		        <i class="fas fa-lock"></i>
		        <p>Permissions</p>
		      </a>
		    </li>
		    <li class="nav-item {{request()->routeIs('roles.*') ? 'active' : ''}}">
		      <a href="{{route('roles.index')}}">
		        <i class="fas fa-tasks"></i>
		        <p>Roles</p>
		      </a>
		    </li>
		    <li class="nav-item {{request()->routeIs('users.*') ? 'active' : ''}}">
		      <a href="{{route('users.index')}}">
		        <i class="fas fa-users"></i>
		        <p>Users</p>
		      </a>
		    </li>
		    <li class="nav-item {{request()->routeIs('videos.*') ? 'active' : ''}}">
		      <a href="{{route('videos.index')}}">
		        <i class="fas fa-play"></i>
		        <p>Videos</p>
		      </a>
		    </li>
		  </ul>
		</div>
	</div>
</div>