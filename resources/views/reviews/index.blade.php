@extends('layouts.base')

@section('title', 'Items You Can Review')

@section('body')
    @include('layouts.flash-messages')

    <!-- Page Title -->
    <div class="container">
        <h2 class="page-title">Items You Can Review</h2>
    </div>

    <!-- Items Listing -->
    <div class="container">
        @if($items->count() > 0)
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
                                                <img src="/images/default.png" alt="No image available" class="d-block w-100">
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
                                    <h3 class="card-title product-title">{{ $item->name }}</h3>
                                    <p class="product-category mb-2">{{ $item->category }}</p>
                                    <p class="card-text product-description">{{ Str::limit($item->description, 100) }}</p>
                                    
                                    {{-- Review Summary --}}
                                    <div class="mt-auto">
                                        <h5 class="review-title">Item Reviews:</h5>
                                        @if($item->reviews && $item->reviews->count() > 0)
                                            <div class="review-summary">
                                                @foreach($item->reviews->take(2) as $review)
                                                    <div class="review-preview mb-2">
                                                        <p class="mb-1">
                                                            <strong>{{ $review->user->name }}:</strong> 
                                                            {{ Str::limit($review->comment, 70) }}
                                                        </p>
                                                        <div class="rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($item->reviews->count() > 2)
                                                    <a href="{{ route('reviews.index', ['item' => $item->item_id]) }}" class="btn btn-link p-0 mb-2">View all reviews</a>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-muted small">No reviews yet. Be the first!</p>
                                        @endif
                                        
                                        <a href="{{ route('reviews.index', ['item' => $item->item_id]) }}" class="btn btn-primary w-100 mt-2" role="button">
                                            <i class="fas fa-pencil-alt me-1"></i> Write a Review
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">
                <i class="fas fa-info-circle me-2"></i> You have no items to review.
            </div>
        @endif
    </div>
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