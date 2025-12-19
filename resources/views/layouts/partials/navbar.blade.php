<nav class="navbar navbar-expand navbar-light bg-white border-bottom">
    <button class="btn btn-outline-secondary" id="sidebarToggle"><i class="fa fa-bars"></i></button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle"></i> {{ Auth::user() ? Auth::user()->name : 'Pengguna' }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                <a class="dropdown-item" href="#">Profile</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="px-3">
                    @csrf
                    <button class="btn btn-sm btn-danger btn-block" type="submit">Logout</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
