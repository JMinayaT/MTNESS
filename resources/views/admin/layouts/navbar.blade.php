<nav class="navbar navbar-default navbar-fixed justify-content-lg-between">
   <a id="sidebarCollapse"><i class="fas fa-bars"></i></a>
   <ul class="nav">
      <li class="nav-item dropdown">
         <a class="nav-link" href="#" id="DropdownMenuMesaje" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="far fa-envelope"></span>
            <span class="badge badge-pill badge-primary">5</span>
         </a>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuMesaje">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">action</a>
            <a class="dropdown-item" href="#">Something</a>
         </div>
      </li>
      <li class="nav-item dropdown">
         <a class="nav-link" href="#"id="DropdownMenuAlert" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="far fa-bell"></span>
            <span class="badge badge-pill badge-danger">8</span>
         </a>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuAlert">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another</a>
            <a class="dropdown-item" href="#">else here</a>
         </div>
      </li>
       <li class="nav-item dropdown">
         <a class="dropdown-toggle" href="#" id="DropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <img src="https://d2giyh01gjb6fi.cloudfront.net/useravatar/0001/87/thumb_86557_useravatar_small.png" class="rounded-circle img-avatar" alt="admin@bootstrapmaster.com">
         <span class="d-none d-md-inline-block">{{ Auth::user()->name }}</span>
         </a>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuUser">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item"  href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
         </div>
      </li>
   </ul>
</nav>