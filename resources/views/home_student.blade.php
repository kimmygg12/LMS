<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.home') }}</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Siemreap&display=swap');

        body {
            font-family: "Siemreap", sans-serif;
            font-weight: 550;
        }

        .A1 {
            display: flex;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <img src="{{ asset('images/a1.jpg') }}" alt="University Logo" class="navbar-logo mr-2" />
            <h5 class="card-title">{{ __('messages.library_name') }}</h5>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {!! __('messages.language') !!}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'en']) }}">
                                <img src="{{ asset('images/en.jpg') }}" alt="English"
                                    style="width: 20px; height: 15px;"> English
                            </a>
                            <a class="dropdown-item" href="{{ route('locale.set', ['locale' => 'kh']) }}">
                                <img src="{{ asset('images/kh.png') }}" alt="Khmer"
                                    style="width: 20px; height: 15px;"> ខ្មែរ
                            </a>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('member.login') }}">{{ __('messages.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('member.register') }}">{{ __('messages.register') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-4">
        <div class="card text-center mb-4">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.library_title') }}</h4>
            </div>
        </div>

        <form action="{{ route('search.books') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="{{ __('messages.search_books') }}" value="{{ request()->input('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>


        <div class="card-container mt-4 mb-4 A1">
            @forelse($books as $book)
                <div class="card A2">
                    <img src="{{ asset($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $book->author->name }}</h6>
                    </div>
                    <div class="card-footer text-muted">
                        <a href="{{ route('members.student-book', $book->id) }}"
                            class="btn btn-primary">{{ __('messages.view_details') }}</a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info" role="alert">
                    {{ __('messages.no_books_found') }}
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
