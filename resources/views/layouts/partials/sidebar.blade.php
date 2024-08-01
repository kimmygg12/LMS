<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></i></div>
                ទំព័រដើម
            </a>

            <a class="nav-link {{ request()->routeIs('books.index', 'books.create', 'books.edit','books.show') ? 'active' : '' }}"
                href="{{ route('books.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                សៀវភៅ
            </a>
            <a class="nav-link {{ request()->routeIs('members.index', 'members.create', 'members.edit') ? 'active' : '' }}"
                href="{{ route('members.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-plus"></i></div>
                អ្នកខ្ចីសៀវភៅ
            </a>
            {{-- <a class="nav-link {{ request()->routeIs('students.index', 'students.create', 'students.edit') ? 'active' : '' }}"
                href="{{ route('students.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                អ្នកខ្ចីសៀវភៅ
            </a> --}}
            <a class="nav-link {{ request()->routeIs('loans.index', 'loans.create') ? 'active' : '' }}"
                href="{{ route('loans.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                ខ្ចីសៀវភៅ
            </a>
            <a class="nav-link {{ request()->routeIs('loans.indexloan','loans.finebook.form') ? 'active' : '' }}"
                href="{{ route('loans.indexloan') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                សងសៀវភៅ
            </a>
            <a class="nav-link {{ request()->routeIs('loanBookHistories.index','loanBookHistories.show') ? 'active' : '' }}"
                href="{{ route('loanBookHistories.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                សៀវភៅដែលបានសង
            </a>

            <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-database"></i> របាយការណ៍</div>
            <a class="nav-link {{ request()->routeIs('loans.overdueBooksReport') ? 'active' : '' }}" href="{{ route('loans.overdueBooksReport') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                1
            </a>
            <a class="nav-link" href="{{route('loans.reportLoan')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
               2
            </a>  
            <a class="nav-link" href="{{route('loans.report.total')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
               3
            </a> 

            <a class="nav-link" href="{{route('loans.reports')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
               reports
            </a> 
 
        </div>
    </div>
</nav>
