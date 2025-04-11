@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    
    <!-- Page Header -->
    <div class="container">
        <h2 class="page-title">Users Management</h2>
    </div>

    <!-- Users Dashboard -->
    <div class="container mb-5">
        <div class="card dashboard-card">
            <div class="card-body">
                <!-- Admin Info Section -->
                <div class="user-info mb-4">
                    @if(Auth::check())
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                <p class="text-muted small mb-0">Administrator</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Users Table Section -->
                <div class="table-container">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-hover custom-table']) }}
                    </div>
                    <div class="table-info mt-3">
                        <p class="text-muted small"><i class="fas fa-info-circle me-1"></i> Manage user accounts and permissions</p>
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
                // Initialize DataTable with column definitions before initialization
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    // This runs on each row before display - no modifications needed for filtering
                    return true;
                });
                
                // Initialize with the default settings
                let table = $('#dataTableBuilder').DataTable();
                
                // Add custom styling to DataTables
                $('.dataTable').addClass('border-0');
                $('.dataTables_wrapper .dataTables_filter input').addClass('form-control form-control-sm ms-2');
                $('.dataTables_wrapper .dataTables_length select').addClass('form-select form-select-sm');
                
                // Function to process table cells after each draw
                function formatTableCells() {
                    // Format status cells - find column indexes for status and role
                    $('#dataTableBuilder thead th').each(function(index) {
                        const headerText = $(this).text().trim().toLowerCase();
                        
                        // Check which header this is
                        if (headerText === 'status') {
                            // Process status column cells
                            $(`#dataTableBuilder tbody tr td:nth-child(${index + 1})`).each(function() {
                                const status = $(this).text().trim();
                                if (status === 'Ac') $(this).text('Active');
                                if (status === 'In') $(this).text('Inactive');
                                $(this).addClass('status-cell');
                            });
                        }
                        
                        if (headerText === 'role') {
                            // Process role column cells
                            $(`#dataTableBuilder tbody tr td:nth-child(${index + 1})`).each(function() {
                                const role = $(this).text().trim();
                                if (role === 'Ad') $(this).text('Admin');
                                if (role === 'Us') $(this).text('User');
                                $(this).addClass('role-cell');
                            });
                        }
                        
                        if (headerText === 'email') {
                            // Process email column - add line break before @
                            $(`#dataTableBuilder tbody tr td:nth-child(${index + 1})`).each(function() {
                                const email = $(this).text().trim();
                                if (email.includes('@')) {
                                    const parts = email.split('@');
                                    $(this).html(parts[0] + '<br>@' + parts[1]);
                                }
                                $(this).addClass('email-cell');
                            });
                        }
                    });
                }

                // Run on initial load and after each draw
                formatTableCells();
                table.on('draw', formatTableCells);
                
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