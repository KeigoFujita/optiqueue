<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-base font-bold font-serif text-gray-900">Revenue Overview</h3>
            <p class="text-xs text-gray-500 mt-0.5">Monthly revenue for the last 12 months</p>
        </div>
        <span class="badge badge-neutral text-xs" id="revenue-change-badge">
            @php
                $totalRevenueChart = array_sum($chartData);
                $prevRevenue = array_sum(array_slice($chartData, 0, 6));
                $currentRevenue = array_sum(array_slice($chartData, 6));
                $changePct = $prevRevenue > 0 ? round((($currentRevenue - $prevRevenue) / $prevRevenue) * 100, 1) : 0;
            @endphp
            {{ $changePct > 0 ? '+' : '' }}{{ $changePct }}% vs last period
        </span>
    </div>
    <div class="h-64 relative">
        <canvas id="revenueChart"></canvas>
    </div>
    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full" style="background: #0F3D2A;"></span>
                Revenue
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full" style="background: #f4d03f;"></span>
                Current
            </span>
        </div>
        <span class="font-medium text-gray-700" id="revenue-change-amount">
            @php
                $lastMonth = count($chartData) > 0 ? end($chartData) : 0;
                $prevMonth = count($chartData) > 1 ? $chartData[count($chartData) - 2] : 0;
                $diff = $lastMonth - $prevMonth;
            @endphp
            {{ $diff >= 0 ? '+' : '' }}${{ number_format($diff, 0) }} vs last month
        </span>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            const labels = @json($chartLabels);
            const data = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: data,
                        borderColor: '#0F3D2A',
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return 'rgba(15, 61, 42, 0.1)';
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(15, 61, 42, 0.15)');
                            gradient.addColorStop(1, 'rgba(15, 61, 42, 0)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: function(context) {
                            const index = context.dataIndex;
                            return index === data.length - 1 ? '#f4d03f' : '#0F3D2A';
                        },
                        pointBorderColor: function(context) {
                            const index = context.dataIndex;
                            return index === data.length - 1 ? '#f4d03f' : '#0F3D2A';
                        },
                        pointBorderWidth: 2,
                        pointRadius: function(context) {
                            return context.dataIndex === data.length - 1 ? 6 : 4;
                        },
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#f4d03f',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#f8fafc',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    family: 'Inter',
                                },
                            },
                        },
                        y: {
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    family: 'Inter',
                                },
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            },
                            beginAtZero: true,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart',
                    },
                }
            });
        });
    </script>
@endpush
