@extends('layouts.backend.app')
@section('content')
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var chartData = {!! $chartData !!};
            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: 'Monthly Statistics',
                legend: { position: 'top' },
                bar: { groupWidth: '85%' },
                colors: ['#3366CC', '#DC3912', '#FF9900', '#109618', '#990099'], // Added color for Doctor Schedules
                vAxis: { title: 'Count' },
                hAxis: { title: 'Month', slantedText: true, slantedTextAngle: 45 },
                height: 400,
                chartArea: { width: '70%', height: '75%' },
                isStacked: false
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('monthly_chart'));
            chart.draw(data, options);
        }
    </script>
<style>
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
</style>
<!-- ======================= Cards ================== -->
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader" style="text-align:center">
            <h2>Monthly Trends</h2>
        </div>

        <div id="monthly_chart"></div>
    </div>

    <!-- ================= New Customers ================ -->
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Recent Appointments</h2>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Time</th>
                        <th>Appointment Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->created_at->format('H:i') }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection