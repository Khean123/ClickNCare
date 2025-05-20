@extends('layouts.backend.app')

@section('content')
<head>
    <style>
           .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            table-layout: fixed;
        }
        th, td {
            border-bottom: 1px solid #2a2185;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #2a2185;
            color: white;
        }
        .cardHeader {
            text-align: center;
            margin-bottom: 20px;
        }
        .cardHeader h2 {
            color: #2a2185;
        }
        .welcome-message {
            background-color: #2a2185;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .chart-container {
            width: 100%;
            height: 300px;
            margin: 0 auto;
        }
    </style>
</head>

<div class="welcome-message">
    <h2>Welcome, Dr. {{ auth()->user()->name }}</h2>
    <p>Today is {{ now()->format('l, F j, Y') }}</p>
</div>

<div class="details">
    <!-- Appointment Distribution Chart -->
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Today's Appointment Distribution</h2>
        </div>
        <div class="chart-container">
            <canvas id="appointmentChart"></canvas>
        </div>
    </div>

    <!-- Today's Appointments List -->
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Today's Appointments ({{ $todayAppointments->count() }})</h2>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Time</th>
                        <th>Service</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todayAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}</td>  
                        <td>
                            <span class="status-badge status-{{ strtolower($appointment->status) }}">
    {{ ucfirst(strtolower($appointment->status)) }}
</span>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No appointments scheduled for today</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Chart.js for the appointment distribution chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Appointment Distribution Chart
        const ctx = document.getElementById('appointmentChart').getContext('2d');
        const appointmentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Confirmed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $appointmentStats['confirmed'] }},
                        {{ $appointmentStats['pending'] }},
                        {{ $appointmentStats['cancelled'] }}
                    ],
                    backgroundColor: [
                        '#28a745', // green for confirmed
                        '#ffc107', // yellow for pending
                        '#dc3545'  // red for cancelled
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Status badge colors
        document.querySelectorAll('.status-badge').forEach(badge => {
            const status = badge.classList[1].replace('status-', '');
            switch(status) {
                case 'confirmed':
                    badge.style.backgroundColor = '#28a745';
                    break;
                case 'pending':
                    badge.style.backgroundColor = '#ffc107';
                    break;
                case 'cancelled':
                    badge.style.backgroundColor = '#dc3545';
                    break;
            }
            badge.style.color = 'white';
            badge.style.padding = '3px 8px';
            badge.style.borderRadius = '10px';
            badge.style.fontSize = '0.8em';
        });
    });
</script>
@endsection