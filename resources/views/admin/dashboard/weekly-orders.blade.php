<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-base font-bold font-serif text-gray-900">Weekly Orders</h3>
            <p class="text-xs text-gray-500 mt-0.5">Order volume for the current week</p>
        </div>
        <span class="badge badge-neutral text-xs">Updated today</span>
    </div>
    <div class="h-64 relative">
        <canvas id="weeklyOrdersChart"></canvas>
    </div>
    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full" style="background: #0F3D2A; opacity: 0.65;"></span>
                Orders
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full" style="background: #f4d03f; opacity: 0.85;"></span>
                Peak
            </span>
        </div>
        <span class="font-medium text-gray-700" id="avg-orders-label">Avg. {{ $avgOrdersPerDay }} orders/day</span>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('weeklyOrdersChart');
            if (!ctx) return;

            const weekDays = @json($weekDays);
            const orderData = @json($weekOrderData);
            const maxVal = Math.max(...orderData, 1);

            // Bar colors - highlight peak (Saturday index 5, Sunday index 6)
            const barColors = orderData.map((val, i) => {
                if (i === 5) return '#f4d03f';
                if (i === 6) return '#e8b923';
                return '#0F3D2A';
            });
            const barOpacity = orderData.map((val, i) => {
                if (i === 5 || i === 6) return 0.85;
                return 0.65;
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weekDays,
                    datasets: [{
                        label: 'Orders',
                        data: orderData,
                        backgroundColor: barColors.map((c, i) => {
                            const opacity = barOpacity[i];
                            const r = parseInt(c.slice(1,3), 16);
                            const g = parseInt(c.slice(3,5), 16);
                            const b = parseInt(c.slice(5,7), 16);
                            return `rgba(${r}, ${g}, ${b}, ${opacity})`;
                        }),
                        borderColor: barColors,
                        borderWidth: 0,
                        borderRadius: 8,
                        barPercentage: 0.65,
                        categoryPercentage: 0.8,
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
                                    return context.parsed.y + ' orders';
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
                                stepSize: Math.max(1, Math.ceil(maxVal / 5)),
                            },
                            beginAtZero: true,
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                    },
                }
            });
        });
    </script>
@endpush
