<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Member Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Siemreap&display=swap');

        body {
            font-family: "Siemreap", sans-serif;
            font-weight: 550;
        }

        .A1 {
            display: flex;
            justify-content: flex-start;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .A2 {
            width: 180px;
            margin-bottom: 15px;
        }

        .A2 img {
            height: 250px;
            object-fit: cover;
        }

        .navbar-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="{{ asset('images/a1.jpg') }}" alt="University Logo" class="navbar-logo mr-2" />
        <a class="navbar-brand" href="{{ route('members.dashboard') }}">
            {{ __('messages.library_name') }}

            <br>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('members.dashboard') }}">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('members.showmember', ['id' => Auth::guard('member')->id()]) }}">{{ __('messages.my_details') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('members.showLoans', ['id' => Auth::guard('member')->id()]) }}">{{ __('messages.my_books') }}</a>
                </li>
            </ul>

            <!-- Right aligned elements -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {!! __('messages.language') !!}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'en']) }}">
                            <img src="{{ asset('images/en.jpg') }}" alt="English" style="width: 20px; height: 15px;">
                            English
                        </a>
                        <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'kh']) }}">
                            <img src="{{ asset('images/kh.png') }}" alt="Khmer" style="width: 20px; height: 15px;">
                            ខ្មែរ
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="logoutDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> {{ __('messages.logout') }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="logoutDropdown">
                        <form method="POST" action="{{ route('member.logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">{{ __('messages.logout') }}</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container mt-4 mb-4">
        @yield('content')
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
