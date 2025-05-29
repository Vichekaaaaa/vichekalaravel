<?php
// resources/views/dashboard.blade.php
?>

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2 class="mb-4 animate__animated animate__fadeInDown">Dashboard</h2>

        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                {{ session('error') }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="card-header">Contact Methods</div>
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                            Total: {{ $contactMethodCount }}
                        </h5>
                        <p class="card-text">Number of contact methods registered.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                    <div class="card-header">Projects</div>
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeIn" style="animation-delay: 0.7s;">
                            Total: {{ $projectCount }}
                        </h5>
                        <p class="card-text">Number of active projects.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeIn" style="animation-delay: 0.9s;">
                            Total: {{ $categoryCount }}
                        </h5>
                        <p class="card-text">Number of categories created.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white animate__animated animate__fadeInUp" style="animation-delay: 1.0s;">
                    <div class="card-header">Tutorials</div>
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeIn" style="animation-delay: 1.1s;">
                            Total: {{ $tutorialCount }}
                        </h5>
                        <p class="card-text">Number of tutorials available.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 1.2s;">Quick Actions</h3>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('contact-methods.create') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.3s;">Add New Contact Method</a>
                <a href="{{ route('projects.create') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.4s;">Add New Project</a>
                <a href="{{ route('categories.create') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.5s;">Add New Category</a>
                <a href="{{ route('logo.edit') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.6s;">Edit Logo</a>
                <a href="{{ route('tutorials.create') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.7s;">Add New Tutorial</a>
            </div>
        </div>

        <div class="card animate__animated animate__fadeInUp" style="animation-delay: 1.8s;">
            <div class="card-header">Statistics Overview</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 1.9s;">Count Breakdown</h5>
                        <canvas id="dashboardChart" style="max-height: 300px;"></canvas>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 2.0s;">Distribution</h5>
                        <canvas id="distributionChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 animate__animated animate__fadeInUp" style="animation-delay: 2.1s;">
            <div class="card-header">Activity Breakdown</div>
            <div class="card-body">
                <h5 class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 2.2s;">Project Status Distribution</h5>
                <canvas id="activityChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <div class="card mt-4 animate__animated animate__fadeInUp" style="animation-delay: 2.3s;">
            <div class="card-header">Trend Analysis</div>
            <div class="card-body">
                <h5 class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 2.4s;">Monthly Project Growth</h5>
                <canvas id="trendChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Contact Methods', 'Projects', 'Categories', 'Tutorials'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $contactMethodCount }}, {{ $projectCount }}, {{ $categoryCount }}, {{ $tutorialCount }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Blue for Contact Methods
                        'rgba(75, 192, 192, 0.6)', // Green for Projects
                        'rgba(255, 206, 86, 0.6)', // Yellow for Categories
                        'rgba(153, 102, 255, 0.6)' // Purple for Tutorials
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Contact Methods', 'Projects', 'Categories', 'Tutorials'],
                datasets: [{
                    label: 'Distribution',
                    data: [{{ $contactMethodCount }}, {{ $projectCount }}, {{ $categoryCount }}, {{ $tutorialCount }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Blue for Contact Methods
                        'rgba(75, 192, 192, 0.6)', // Green for Projects
                        'rgba(255, 206, 86, 0.6)', // Yellow for Categories
                        'rgba(153, 102, 255, 0.6)' // Purple for Tutorials
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });

        // Doughnut Chart
        const doughnutCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Completed', 'Pending'],
                datasets: [{
                    label: 'Project Status',
                    data: [10, 5, 3], // Placeholder data; replace with actual project status counts
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.6)', // Green for Active
                        'rgba(0, 123, 255, 0.6)', // Blue for Completed
                        'rgba(253, 126, 20, 0.6)' // Orange for Pending
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(253, 126, 20, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });

        // Line Chart
        const lineCtx = document.getElementById('trendChart').getContext('2d');
        const trendChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar'], // Placeholder months
                datasets: [{
                    label: 'Projects Added',
                    data: [5, 7, 10], // Placeholder data; replace with actual monthly counts
                    backgroundColor: 'rgba(23, 162, 184, 0.2)', // Teal fill
                    borderColor: 'rgba(23, 162, 184, 1)', // Teal line
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });
    </script>
@endsection