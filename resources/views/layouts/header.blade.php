<!-- filepath: c:\homeessence\resources\views\layouts\header.blade.php -->
<header class="bg-beige py-2">
    <div class="container">
        <a class="logo text-decoration-none" href="{{ route('getItems') }}">
            <h1 class="m-0">Home<span>Essence</span></h1>
        </a>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="{{ route('getItems') }}">HomeEssence</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('getItems') }}">Home<span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown position-relative">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{-- Show profile picture if available; otherwise, show default icon --}}
                        @if(Auth::check() && Auth::user()->customer && Auth::user()->customer->profile_picture)
                            <img src="{{ Storage::url('profile_pictures/' . Auth::user()->customer->profile_picture) }}" 
                                alt="Profile Picture" class="rounded-circle" 
                                style="width:40px; height:40px; margin-right:10px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle" style="font-size:40px; margin-right:10px;"></i>
                        @endif
                        <span>{{ Auth::check() ? Auth::user()->name : '' }}</span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position:absolute; left:0; right:auto; top:100%;">
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a class="dropdown-item py-1" href="{{ route('customerprofile.edit') }}">Profile</a>
                            <a class="dropdown-item py-1" href="{{ route('reviews.reviewable_items') }}">Reviews</a>
                            <a class="dropdown-item py-1" href="{{ route('admin.orders') }}">Orders</a>
                            <a class="dropdown-item py-1" href="{{ route('admin.users') }}">Users</a>
                            <a class="dropdown-item py-1" href="{{ route('admin.items') }}">Items</a>
                            <a class="dropdown-item py-1" href="{{ route('dashboard.index') }}">Charts</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        @elseif (Auth::check())
                            <a class="dropdown-item" href="{{ route('customerprofile.edit') }}">Profile</a>
                            <a class="dropdown-item" href="{{ route('reviews.reviewable_items') }}">Reviews</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                        @else
                            <a class="dropdown-item" href="{{ route('register') }}">Signup</a>
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                        @endif
                    </div>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <form action="{{ route('search') }}" method="GET" class="d-flex me-3">
                    <div class="input-group search-group">
                        <input class="form-control search-input" type="search" placeholder="Search" aria-label="Search" name="term" style="min-width:150px;">
                        <select class="form-select search-select" name="search_type" aria-label="Search Type">
                            <option value="like">Simple Search</option>
                            <option value="model">Model Search</option>
                            <option value="scout">Scout Search</option>
                        </select>
                        <button class="btn btn-outline-primary search-button" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <a class="nav-link cart-btn-nav" href="{{ route('getCart') }}">
                    <i class="fa-solid fa-cart-shopping me-1"></i>Your Cart
                    <span class="badge rounded-pill bg-danger">
                        {{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>