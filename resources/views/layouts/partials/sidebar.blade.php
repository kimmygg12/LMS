<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link {{ request()->routeIs('dashboard', 'profile.edit') ? 'active' : '' }}"
                href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                {{ __('messages.home') }}
            </a>

            <a class="nav-link {{ request()->routeIs('books.index', 'books.create', 'subjects.index', 'subjects.create', 'books.show', 'books.edit', 'subjects.edit', 'authors.index') ? 'active' : '' }}"
                data-toggle="collapse" href="#collapseBook" role="button"
                aria-expanded="{{ request()->routeIs('books.index', 'books.create', 'subjects.index', 'subjects.create', 'books.show', 'books.edit', 'subjects.edit', 'authors.index') ? 'true' : 'false' }}"
                aria-controls="collapseBook">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                {{ __('messages.books') }}
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse {{ request()->routeIs('books.index', 'books.create', 'subjects.index', 'subjects.create', 'books.show', 'books.edit', 'subjects.edit', 'authors.index') ? 'show' : '' }}"
                id="collapseBook">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->routeIs('books.index', 'books.show', 'books.edit') ? 'active' : '' }}"
                        href="{{ route('books.index') }}">{{ __('messages.book_list') }}</a>
                    <a class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}"
                        href="{{ route('books.create') }}">{{ __('messages.add_book') }}</a>
                    <a class="nav-link {{ request()->routeIs('subjects.index', 'subjects.create', 'subjects.edit') ? 'active' : '' }}"
                        href="{{ route('subjects.index') }}">{{ __('messages.subjects') }}</a>
                    <a class="nav-link {{ request()->routeIs('authors.index', 'authors.create', 'authors.edit') ? 'active' : '' }}"
                        href="{{ route('authors.index') }}">{{ __('messages.authors') }}</a>
                </nav>
            </div>

            <a class="nav-link {{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index', 'studies.create', 'categories.create', 'members.edit', 'studies.edit', 'categories.edit') ? 'active' : '' }}"
                data-toggle="collapse" href="#collapseMembers" role="button"
                aria-expanded="{{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index', 'studies.create', 'categories.create', 'members.edit', 'studies.edit', 'categories.edit') ? 'true' : 'false' }}"
                aria-controls="collapseMembers">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></div>
                {{ __('messages.students_management') }}
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse {{ request()->routeIs('members.index', 'members.create', 'categories.index', 'studies.index', 'studies.create', 'categories.create', 'members.edit', 'studies.edit', 'categories.edit') ? 'show' : '' }}"
                id="collapseMembers">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->routeIs('members.index', 'members.edit') ? 'active' : '' }}"
                        href="{{ route('members.index') }}">{{ __('messages.all_students') }}</a>

                    <a class="nav-link {{ request()->routeIs('members.create') ? 'active' : '' }}"
                        href="{{ route('members.create') }}">{{ __('messages.add_student') }}</a>

                    @if (Auth::check() && Auth::user()->usertype === 'admin')
                        <a class="nav-link {{ request()->routeIs('studies.index', 'studies.create', 'studies.edit') ? 'active' : '' }}"
                            href="{{ route('studies.index') }}">{{ __('messages.school_years') }}</a>
                    @endif

                    <a class="nav-link {{ request()->routeIs('categories.index', 'categories.create', 'categories.edit') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">{{ __('messages.categories') }}</a>
                </nav>
            </div>

            <a class="nav-link {{ request()->routeIs('loans.index', 'loans.create', 'loans.finebook.form', 'loans.edit', 'loan.invoice.show') ? 'active' : '' }}"
                href="{{ route('loans.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                {{ __('messages.loans') }}
            </a>

            <a class="nav-link {{ request()->routeIs('loans.overdueBooksReport') ? 'active' : '' }}"
                href="{{ route('loans.overdueBooksReport') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt"></i></div>
                {{ __('messages.overdue_reports') }}
            </a>
            <a class="nav-link {{ request()->routeIs('loanBookHistories.index', 'loanBookHistories.show', 'loanBookHistories.showInvoice', 'invoice.show') ? 'active' : '' }}"
                href="{{ route('loanBookHistories.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                {{ __('messages.returned_books') }}
            </a>

            <div class="sb-sidenav-menu-heading">{{ __('messages.report') }}
            </div>


            <a class="nav-link {{ request()->routeIs('reports.new_books', 'reports.combinedReport') ? 'active' : '' }}"
                data-toggle="collapse" href="#collapseReports" role="button"
                aria-expanded="{{ request()->routeIs('reports.new_books', 'reports.combinedReport') ? 'true' : 'false' }}"
                aria-controls="collapseReports">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-database"></i></div>
                {{ __('messages.report') }}
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse {{ request()->routeIs('reports.new_books', 'reports.combinedReport') ? 'show' : '' }}"
                id="collapseReports">
                <nav class="sb-sidenav-menu-nested nav">

                    <a class="nav-link {{ request()->routeIs('reports.combinedReport') ? 'active' : '' }}"
                        href="{{ route('reports.combinedReport') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        {{ __('messages.combined_reports') }}
                    </a>
                    <a class="nav-link {{ request()->routeIs('reports.new_books') ? 'active' : '' }}"
                        href="{{ route('reports.new_books') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        {{ __('messages.books_new_reports') }}
                    </a>

                </nav>
            </div>





            {{-- 
            <a class="nav-link {{ request()->routeIs('reports.combinedReport') ? 'active' : '' }}"
                href="{{ route('reports.combinedReport') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                {{ __('messages.report') }}
            </a> --}}
            {{-- <a class="nav-link {{ request()->routeIs('reports.combinedReport') ? 'active' : '' }}"
                href="{{ route('reports.new_books') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                {{ __('messages.combined_reports') }}
            </a> --}}
        </div>
    </div>
</nav>
