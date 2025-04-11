@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    
    <!-- Page Header -->
    <div class="container">
        <h2 class="page-title">Analytics Dashboard</h2>
    </div>
    
        <!-- Date Range Filter -->
        <div class="card dashboard-card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="filter-icon me-3">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Sales Data Filter</h5>
                                <p class="text-muted small mb-0">Select date range to analyze sales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('dashboard.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="date_from" class="form-label">From:</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="date_to" class="form-label">To:</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-4 align-self-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i> Apply Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chart Rows -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <h5 class="card-title chart-title">
                            <i class="fas fa-users me-2"></i> Customer Demographics
                        </h5>
                        <div class="chart-container">
                            {!! $customerChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <h5 class="card-title chart-title">
                            <i class="fas fa-chart-bar me-2"></i> Monthly Sales
                        </h5>
                        <div class="chart-container">
                            {!! $monthlySalesChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <h5 class="card-title chart-title">
                            <i class="fas fa-chart-line me-2"></i> Yearly Sales
                        </h5>
                        <div class="chart-container">
                            {!! $yearlySalesChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <h5 class="card-title chart-title">
                            <i class="fas fa-calendar-day me-2"></i> Sales by Date Range
                        </h5>
                        <div class="chart-container">
                            {!! $salesBarChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <h5 class="card-title chart-title">
                            <i class="fas fa-box-open me-2"></i> Product Sales Distribution
                        </h5>
                        <div class="chart-container">
                            {!! $itemChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <!-- This is a placeholder column for potential future charts -->
            </div>
        </div>
    </div>
    
    <!-- Chart Scripts (must be placed at the bottom to ensure they load after containers) -->
    {!! $customerChart->script() !!}
    {!! $monthlySalesChart->script() !!}
    {!! $yearlySalesChart->script() !!}
    {!! $salesBarChart->script() !!}
    {!! $itemChart->script() !!}
@endsection

@push('styles')
<style>
    .dashboard-stat-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .dashboard-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon, .filter-icon {
        color: var(--accent-beige);
    }
    
    .dashboard-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .chart-title {
        padding-bottom: 12px;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--secondary-beige);
        color: var(--text-dark);
    }
    
    .chart-container {
        height: 300px;
    }
</style>
@endpush
