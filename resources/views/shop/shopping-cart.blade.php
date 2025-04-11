<!-- filepath: c:\homeessence\resources\views\shop\shopping-cart.blade.php -->
@extends('layouts.base')

@section('title')
    HomeEssence Shopping Cart
@endsection

@section('body')
    @include('layouts.flash-messages')

    @if (Session::has('cart'))
        <div class="container mt-4">
            <h2 class="page-title">Your Shopping Cart</h2>
            <div class="row">
                <div class="col-md-8">
                    <ul class="list-group">
                        @foreach ($products as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div id="carousel-{{ $product['item']->item_id }}" class="carousel slide me-3" data-bs-interval="0" style="width: 100px; height: 100px;">
                                        <div class="carousel-inner">
                                            @if($product['item']->productImages && $product['item']->productImages->count() > 0)
                                                @foreach($product['item']->productImages as $key => $img)
                                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                        <img src="{{ Storage::url($img->image_path) }}" alt="Product Image" class="d-block w-100" style="width:100px; height:100px;">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="carousel-item active">
                                                    <img src="/images/default.png" alt="No image available" class="d-block w-100" style="width:100px; height:100px;">
                                                </div>
                                            @endif
                                        </div>
                                        @if($product['item']->productImages && $product['item']->productImages->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $product['item']->item_id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $product['item']->item_id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $product['item']->name }}</h5>
                                        <small class="text-muted">Category: {{ $product['item']->category }}</small>
                                        <p class="mb-1">{{ $product['item']->description }}</p>
                                        <span class="badge bg-success">₱{{ $product['item']->sell_price }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge rounded-pill bg-danger me-3">{{ $product['qty'] }}</span>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $product['item']->item_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Choose
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $product['item']->item_id }}">
                                            <li><a class="dropdown-item" href="{{ route('reduceByOne', $product['item']->item_id) }}">Reduce By 1</a></li>
                                            <li><a class="dropdown-item" href="{{ route('removeItem', $product['item']->item_id) }}">Remove All</a></li>
                                        </ul>
                                    </div>
                                    <div class="ms-3">
                                        <span class="badge bg-primary">Total: ₱{{ $product['price'] }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Cart Summary</h4>
                            <p class="card-text">Total: ₱{{ $totalPrice }}</p>
                            <p class="card-text">Shipping Fee: ₱45.00</p>
                            <p class="card-text"><strong>Grand Total: ₱{{ $totalPrice + 45.00 }}</strong></p>
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container mt-4">
            <h2 class="page-title">Your Shopping Cart</h2>
            <div class="alert alert-warning" role="alert">
                No items in cart!
            </div>
        </div>
    @endif
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
        });
    </script>
@endpush