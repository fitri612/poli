<header id="home">
    <nav class="navbar navbar-inverse navbar-expand-lg header-nav fixed-top light-header">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="img/logo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCodeply">
                <i class="icofont-navigation-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCodeply">
                <ul class="nav navbar-nav ml-auto">
                    <li><a class="nav-link" href="{{ route('get.register.poli') }}">Buat Janji</a></li>
                    <li><a class="nav-link" href="#services">Dokter Kami</a></li>
                    <li>
                        @if (Auth::check())
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        @else
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal" onclick="{{ route('login') }}">
                                Login
                            </button> --}}
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
