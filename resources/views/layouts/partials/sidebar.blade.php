<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></i></div>
                ទំព័រដើម
            </a>

            <a class="nav-link {{ request()->routeIs('books.index','books.create','subjects.index','subjects.create') ? 'active' : '' }}"
                data-toggle="collapse" href="#collapseBook" role="button"
                aria-expanded="{{ request()->routeIs('books.index','books.create','subjects.index','subjects.create') ? 'true' : 'false' }}"
                aria-controls="collapseBook">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                សៀវភៅ
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse {{ request()->routeIs('books.index','books.create','subjects.index','subjects.create') ? 'show' : '' }}"
                id="collapseBook">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}"
                        href="{{ route('books.index') }}">បញ្ជីសៀវភៅ</a>
                    <a class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}"
                        href="{{ route('books.create') }}">បន្ថៃមសៀវភៅថ្មី</a>
                    <a class="nav-link {{ request()->routeIs('subjects.index','subjects.create') ? 'active' : '' }}"
                        href="{{ route('subjects.index') }}">ប្រភេទ</a>
                 
                </nav>
            </div>
            <a class="nav-link {{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index','studies.create','categories.create') ? 'active' : '' }}"
                data-toggle="collapse" href="#collapseMembers" role="button"
                aria-expanded="{{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index','studies.create','categories.create') ? 'true' : 'false' }}"
                aria-controls="collapseMembers">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></div>
                គ្រប់គ្រងសិស្ស
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse {{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index','studies.create','categories.create') ? 'show' : '' }}"
                id="collapseMembers">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->routeIs('members.index') ? 'active' : '' }}"
                        href="{{ route('members.index') }}">សិស្សទាំអស់</a>
                    <a class="nav-link {{ request()->routeIs('members.create') ? 'active' : '' }}"
                        href="{{ route('members.create') }}">បន្ថៃមសិស្សថ្មី</a>
                    <a class="nav-link {{ request()->routeIs('studies.index','studies.create') ? 'active' : '' }}"
                        href="{{ route('studies.index') }}">ឆ្នាំសិក្សា</a>
                    <a class="nav-link {{ request()->routeIs('categories.index','categories.create') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">ជំនាញ</a>
                </nav>
            </div>
            <a class="nav-link {{ request()->routeIs('loans.index', 'loans.create', 'loans.finebook.form') ? 'active' : '' }}"
                href="{{ route('loans.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                ខ្ចីសៀវភៅ
            </a>
            <a class="nav-link {{ request()->routeIs('loans.overdueBooksReport') ? 'active' : '' }}"
                href="{{ route('loans.overdueBooksReport') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt"></i></div>
                ផុតកំណត់សងសៀវភៅ
            </a>
            <a class="nav-link {{ request()->routeIs('loanBookHistories.index', 'loanBookHistories.show') ? 'active' : '' }}"
                href="{{ route('loanBookHistories.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                សៀវភៅដែលបានសង
            </a>

            <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-database"></i> របាយការណ៍</div>
            {{-- <a class="nav-link {{ request()->routeIs('loans.topBorrowedBooksReport') ? 'active' : '' }}"
                 href="{{ route('loans.topBorrowedBooksReport') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                សៀវភៅដែលខ្ចីជាងគេ
            </a> --}}
            {{-- <a class="nav-link {{ request()->routeIs('dashboard.Payments') ? 'active' : '' }}" href="{{ route('dashboard.Payments') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Loan Payments Report
            </a> --}}
            <a class="nav-link {{ request()->routeIs('reports.combined') ? 'active' : '' }}"
                href="{{ route('reports.combinedReport') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                របាយការណ៍ខ្ចីសៀវភៅ
            </a>
            {{-- <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}"
                href="{{ route('reports.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                របាយការណ៍ខ្ចីសៀវភៅ
            </a> --}}
        </div>
    </div>
</nav>
