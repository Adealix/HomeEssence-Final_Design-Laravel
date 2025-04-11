@extends('layouts.base')
@section('title')
    HomeEssence Shopping Cart
@endsection
@section('body')
    @include('layouts.flash-messages')

    <!-- Page Title -->
    <div class="container">
        <h2 class="page-title">Our Collection</h2>
    </div>

    <!-- Filter Form -->
    <div class="container mb-4">
        <div class="filter-form">
            <form method="GET" action="{{ route('getItems') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="price_min" class="form-label">Price From:</label>
                    <input type="number" name="price_min" id="price_min" class="form-control" min="0" value="{{ request('price_min') }}">
                </div>
                <div class="col-md-3">
                    <label for="price_max" class="form-label">Price To:</label>
                    <input type="number" name="price_max" id="price_max" class="form-control" min="0" value="{{ request('price_max') }}">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Fashion" {{ request('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Home" {{ request('category') == 'Home' ? 'selected' : '' }}>Home</option>
                        <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Books" {{ request('category') == 'Books' ? 'selected' : '' }}>Books</option>
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Items Listing -->
    <div class="container">
        @foreach ($items->chunk(3) as $itemChunk)
            <div class="row mb-4">
                @foreach ($itemChunk as $item)
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card product-card">
                            <!-- Carousel for item images -->
                            <div id="carousel-{{ $item->item_id }}" class="carousel slide product-image" data-bs-interval="0">
                                <div class="carousel-inner">
                                    @if($item->productImages && $item->productImages->count() > 0)
                                        @foreach($item->productImages as $key => $img)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($img->image_path) }}" alt="Item Image" class="d-block w-100">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <img src="{{ Storage::url('default_picture.jpg') }}" alt="No image available" class="d-block w-100">
                                        </div>
                                    @endif
                                </div>
                                @if($item->productImages && $item->productImages->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $item->item_id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $item->item_id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <!-- Clickable item name triggers modal pop-up -->
                                <h3 class="card-title product-title">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#itemModal{{ $item->item_id }}" style="text-decoration: none;">
                                        {{ $item->name }}
                                    </a>
                                </h3>
                                <!-- Category displayed on a new line -->
                                <p class="product-category mb-2">{{ $item->category }}</p>
                                <p class="card-text product-description">{{ Str::limit($item->description, 100) }}</p>
                                <div class="mt-auto">
                                    <h4 class="product-price">₱{{ $item->sell_price }}</h4>
                                    <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary w-100" role="button">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Modals for each item (for full details & reviews) -->
    @foreach ($items as $item)
        <div class="modal fade" id="itemModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="itemModalLabel{{ $item->item_id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itemModalLabel{{ $item->item_id }}">{{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column: Carousel for images in modal -->
                            <div class="col-md-6">
                                <div id="modalCarousel{{ $item->item_id }}" class="carousel slide" data-bs-interval="0">
                                    <div class="carousel-inner">
                                        @if($item->productImages && $item->productImages->count() > 0)
                                            @foreach($item->productImages as $key => $img)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <img src="{{ Storage::url($img->image_path) }}" class="d-block w-100" alt="Item Image">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="carousel-item active">
                                                <img src="{{ Storage::url('default_picture.jpg') }}" class="d-block w-100" alt="No image available">
                                            </div>
                                        @endif
                                    </div>
                                    @if($item->productImages && $item->productImages->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel{{ $item->item_id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel{{ $item->item_id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <!-- Right Column: Full details and reviews -->
                            <div class="col-md-6">
                                <p><strong>Category:</strong> {{ $item->category }}</p>
                                <p><strong>Description:</strong> {{ $item->description }}</p>
                                <p><strong>Price:</strong> ₱{{ $item->sell_price }}</p>
                                <hr>
                                <h5>Reviews</h5>
                                @if($item->reviews && $item->reviews->count() > 0)
                                    @foreach($item->reviews as $review)
                                        <div class="mb-2">
                                            <p><strong>{{ $review->user->name }}:</strong> {{ $review->comment }}</p>
                                            <p><small>Rating: {{ $review->rating }}/5</small></p>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No reviews available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            var carousels = document.querySelectorAll('.carousel');
            carousels.forEach(function(carousel) {
                new bootstrap.Carousel(carousel, {
                    interval: false,
                    pause: 'hover'
                });
            });
            
            // Add hover animations for cards
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.12)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.08)';
                });
            });
            
            // Add hover animations for buttons
            document.querySelectorAll('.btn-primary').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#d4c8b0';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '#e8d8c3';
                });
            });
        });
    </script>
@endpush
