@extends('layouts.layoutmaster')

@section('content')
<div class="row mt-5">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-5">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
                <h6 class="ms-2 mt-4 mb-0">Statistical Follow Days</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Statistical Follow Months</h6>
            </div>
            <div class="card-body p-5">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-bar" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Row for the Pie Chart -->
<div class="row mt-5">
    <div class="col-lg-12" style="margin-bottom:20px;">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Most Booked Venues</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-pie" class="chart-canvas" height="300px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    async function fetchData(url) {
        const response = await fetch(url);
        return response.json();
    }

    const dailyRevenueData = await fetchData('/statistics/daily-revenue');
    const monthlyRevenueData = await fetchData('/statistics/monthly-revenue');
    const mostBookedPitchesData = await fetchData('/statistics/most-booked-pitches');

    // Render the line chart
    const dailyLabels = dailyRevenueData.map(item => item.date);
    const dailyRevenues = dailyRevenueData.map(item => item.revenue);

    const ctx1 = document.getElementById("chart-line").getContext("2d");
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: dailyLabels,
            datasets: [{
                label: "Revenue",
                borderColor: "#36A2EB",
                data: dailyRevenues,
                fill: false,
                tension: 0.4,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
                x: {
                    display: true,
                },
            },
        },
    });

    // Render the bar chart
    const monthlyLabels = monthlyRevenueData.map(item => `${item.year}-${item.month}`);
    const monthlyRevenues = monthlyRevenueData.map(item => item.revenue);

    const ctx2 = document.getElementById("chart-bar").getContext("2d");
    new Chart(ctx2, {
        type: "bar",
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: "Revenue",
                backgroundColor: "#5E72E4",
                data: monthlyRevenues,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
                x: {
                    display: true,
                },
            },
        },
    });

    // Render most booked venues chart
    const mostBookedLabels = mostBookedPitchesData.map(item => item.name);
    const mostBookedBookings = mostBookedPitchesData.map(item => item.bookings);

    const ctx3 = document.getElementById("chart-pie").getContext("2d");
    new Chart(ctx3, {
        type: "pie",
        data: {
            labels: mostBookedLabels,
            datasets: [{
                label: "Booked Labels",
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                data: mostBookedBookings,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                }
            },
        },
    });
});
</script>

@endsection
