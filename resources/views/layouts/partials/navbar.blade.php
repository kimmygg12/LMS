<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-1 d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/a1.jpg') }}" alt="University Logo" class="navbar-logo mr-2" />
        {{ __('messages.library_management') }}
    </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->

    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        {{-- Uncomment and customize if needed --}}
        {{-- 
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div> 
        --}}
    </form>

    <!-- Notifications Dropdown -->
   
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {!! __('messages.language') !!}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'en']) }}">
                    <img src="{{ asset('images/en.jpg') }}" alt="English" style="width: 20px; height: 15px;"> English
                </a>
                <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'kh']) }}">
                    <img src="{{ asset('images/kh.png') }}" alt="Khmer" style="width: 20px; height: 15px;"> ខ្មែរ
                </a>
            </div>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    {{ __('Profile') }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
