<div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <h3>{{ \App\Models\CarrierDispatcher::count() }}</h3>
            <p>Total Applications</p>
        </div>
        <div class="icon">
            <i class="fas fa-truck"></i>
        </div>
        <a href="{{ route('backend.carrier_dispatchers.index') }}" class="small-box-footer">
            View All <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
        <div class="inner">
            <h3>{{ \App\Models\CarrierDispatcher::pending()->count() }}</h3>
            <p>Pending Review</p>
        </div>
        <div class="icon">
            <i class="fas fa-clock"></i>
        </div>
        <a href="{{ route('backend.carrier_dispatchers.index') }}?status=pending" class="small-box-footer">
            Review Now <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ \App\Models\CarrierDispatcher::approved()->count() }}</h3>
            <p>Approved</p>
        </div>
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <a href="{{ route('backend.carrier_dispatchers.index') }}?status=approved" class="small-box-footer">
            View Approved <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{ \App\Models\CarrierDispatcher::rejected()->count() }}</h3>
            <p>Rejected</p>
        </div>
        <div class="icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <a href="{{ route('backend.carrier_dispatchers.index') }}?status=rejected" class="small-box-footer">
            View Rejected <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<!-- Recent Applications Chart -->
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line"></i> Recent Carrier Dispatcher Applications
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <canvas id="carrierDispatcherChart" style="height: 300px;"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Business Types</span>
                            <span class="info-box-number">
                                @php
                                    $businessTypes = \App\Models\CarrierDispatcher::selectRaw('business_type, COUNT(*) as count')
                                        ->groupBy('business_type')
                                        ->orderBy('count', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                {{ $businessTypes->count() }} Types
                            </span>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                                @foreach($businessTypes as $type)
                                    {{ $type->business_type }} ({{ $type->count }})
                                    @if(!$loop->last), @endif
                                @endforeach
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">This Month</span>
                            <span class="info-box-number">
                                {{ \App\Models\CarrierDispatcher::whereMonth('created_at', now()->month)->count() }}
                            </span>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                                New applications this month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get monthly data for the chart
    const monthlyData = @json(\App\Models\CarrierDispatcher::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get());
    
    const ctx = document.getElementById('carrierDispatcherChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'Applications',
                data: monthlyData.map(item => item.count),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});
</script>
