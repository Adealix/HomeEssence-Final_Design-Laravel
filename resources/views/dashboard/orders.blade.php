@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    
    <!-- Page Header -->
    <div class="container">
        <h2 class="page-title">Your Orders</h2>
    </div>

    <!-- Orders Dashboard -->
    <div class="container mb-5">
        <div class="card dashboard-card">
            <div class="card-body">
                <!-- User Info Section -->
                <div class="user-info mb-4">
                    @if(Auth::check())
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                <p class="text-muted small mb-0">Order History</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Orders Table Section -->
                <div class="table-container">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-hover custom-table']) }}
                    </div>
                    <div class="table-info mt-3">
                        <p class="text-muted small"><i class="fas fa-info-circle me-1"></i> Click on an order to view details</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script src="/vendor/datatables/buttons.server-side.js"></script>
        {!! $dataTable->scripts() !!}
        
        <script>
            $(document).ready(function() {
                // Add custom styling to DataTables
                $('.dataTable').addClass('border-0');
                $('.dataTables_wrapper .dataTables_filter input').addClass('form-control form-control-sm ms-2');
                $('.dataTables_wrapper .dataTables_length select').addClass('form-select form-select-sm');
                
                // Add loading state during AJAX requests
                $(document).on('processing.dt', function(e, settings, processing) {
                    if (processing) {
                        $('.dataTables_processing').addClass('custom-processing');
                    }
                });
            });
        </script>
    @endpush
@endsection