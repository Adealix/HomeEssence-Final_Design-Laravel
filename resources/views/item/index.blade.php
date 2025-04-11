@extends('layouts.base')
@section('body')
    <div class="container">
        @include('layouts.flash-messages')
        
        <!-- Page Header -->
        <div class="container">
            <h2 class="page-title">Item Management</h2>
        </div>
        
        <!-- Item Dashboard -->
        <div class="container mb-5">
            <div class="card dashboard-card">
                <div class="card-body">
                    <!-- Admin Controls Section -->
                    <div class="admin-controls mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="admin-icon me-3">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Product Inventory</h5>
                                        <p class="text-muted small mb-0">Manage your store products</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end mt-3 mt-md-0">
                                    <a class="btn btn-primary me-2" href="{{ route('items.create') }}" role="button">
                                        <i class="fas fa-plus-circle me-1"></i> Add Item
                                    </a>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="fas fa-file-import me-1"></i> Import Items
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="search-container mb-4">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" id="itemSearch" class="form-control border-start-0" placeholder="Search items...">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Items Table Section -->
                    <div class="table-container">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'table table-hover custom-table', 'id' => 'itable']) !!}
                        </div>
                        <div class="table-info mt-3">
                            <p class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Use the carousel arrows in the Images column to navigate through multiple images.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Items from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('item.import') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="uploadName" class="form-label">Select Excel File</label>
                            <input type="file" class="form-control" id="uploadName" name="item_upload" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-upload me-1"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    
    <script>
        $(document).ready(function() {
            // Add custom styling to DataTables
            $('.dataTable').addClass('border-0');
            $('.dataTables_wrapper .dataTables_filter input').addClass('form-control form-control-sm ms-2');
            $('.dataTables_wrapper .dataTables_length select').addClass('form-select form-select-sm');
            
            // Connect the custom search box to DataTable
            $('#itemSearch').on('keyup', function() {
                $('#itable').DataTable().search($(this).val()).draw();
            });
            
            // Add loading state during AJAX requests
            $(document).on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('.dataTables_processing').addClass('custom-processing');
                }
            });
        });
    </script>
@endpush
