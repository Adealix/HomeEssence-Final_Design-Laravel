<!-- filepath: c:\homeessence\resources\views\order\processOrder.blade.php -->
@extends('layouts.base')
@section('body')

<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-lg-8">
            <h1 class="page-title">Order #{{$customer->orderinfo_id}}</h1>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card order-card">
                        <div class="card-body p-3">
                            <h4 class="card-title">Shipping Info</h4>
                            <p class="mb-1"><b>Name:</b> {{$customer->lname}} {{$customer->fname}}</p>
                            <p class="mb-1"><b>Phone:</b> {{$customer->phone}}</p>
                            <p class="mb-1"><b>Address:</b> {{$customer->addressline}}</p>
                            <p class="mb-0"><b>Amount:</b> ₱{{ $total }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card order-card">
                        <div class="card-body p-3">
                            <h4 class="card-title">Order Status</h4>
                            <p class="mb-1">Current Status: <span class="badge bg-{{$customer->status == 'delivered' ? 'success' : ($customer->status == 'canceled' ? 'danger' : 'warning')}}">{{$customer->status}}</span></p>
                            <p class="mb-1"><b>Date Placed:</b> {{date('M d, Y', strtotime($customer->date_placed))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-3">
                <div class="card-body p-3">
                    <h4 class="card-title">Order Items</h4>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Details</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td style="width: 80px;">
                                        <img src="{{ Storage::url($order->image) }}" alt="" class="img-fluid rounded">
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $order->name }}</h6>
                                        <small>Category: {{ $order->category }}</small>
                                    </td>
                                    <td>₱{{ $order->sell_price }}</td>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card mb-3">
                <div class="card-body p-3">
                    <h4 class="card-title">Update Order Status</h4>
                    <form action="{{ route('admin.orderUpdate', $customer->orderinfo_id) }}" method="POST" class="row align-items-end">
                        @csrf
                        <div class="col-md-8 mb-2">
                            <label for="status" class="form-label">Order Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $customer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="delivered" {{ $customer->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $customer->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-4">
            <div class="card order-summary">
                <div class="card-body p-3">
                    <h4 class="card-title">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₱{{ $total }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Fee:</span>
                        <span>₱45.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-0">
                        <strong>Grand Total:</strong>
                        <strong>₱{{ $total + 45.00 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection