@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div id="main-content" class="container-fluid main-content">
        <div class="row gx-3 gy-3">
            <div class="col-md-6">
                <div class="chart-wrapper">
                    <div class="chart-title bg-primary text-white rounded-top p-2">Server Berdasar Asal Project</div>
                    <div class="card-body p-0" style="flex: 1; position: relative;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-wrapper">
                    <div class="chart-title bg-success text-white rounded-top p-2">Total Server</div>
                    <div class="card-body p-0" style="flex: 1; position: relative;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hide');
            mainContent.classList.toggle('expanded');
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (sidebar.classList.contains('hide')) {
                mainContent.classList.add('expanded');
            } else {
                mainContent.classList.remove('expanded');
            }
        });

        const serverCounts = @json($serverCounts);

        const labels = serverCounts.map(item => item.owner_project);
        const data = serverCounts.map(item => item.total);
        const colors = serverCounts.map(item => {
            if (item.owner_project.toLowerCase().includes('telkomsel')) {
                return '#dc3545'; // merah
            } else if (item.owner_project.toLowerCase().includes('indosat')) {
                return '#ffc107'; // kuning
            } else {
                return '#007bff'; // default: biru
            }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.parsed;
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    label: 'Jumlah Server'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.parsed.x;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush