@extends('layouts.backend.app')
@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: white;
    }

    th, td {
        padding: 6px;
        text-align: left;
        word-wrap: break-word;
    }

    th {
        background-color: rgb(0, 60, 150);
        color: white;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
    }

    .btn-primary {
        background-color: rgb(243, 159, 56);
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .sort-select {
        padding: 8px 16px;
        background: #003c96;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
        padding-right: 32px;
    }

    .search label {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 25px;
        border: 1px solid #ccc;
        padding: 4px 16px;
    }

    .search input[type="text"] {
        border: none;
        outline: none;
        font-size: 1rem;
        padding: 8px 10px;
        background: transparent;
        width: 220px;
    }

    @media screen and (max-width: 768px) {
        .search {
            display: none;
        }
    }

    .notification-container {
        width: 100%;
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        border: 1px solid transparent;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
    }

    .cardHeader {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

</style>

<!-- Notifications -->
<div class="notification-container">
    @if(session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" id="errorMessage">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="details">
    <div class="recentOrders" style="width: 130%;">
        <div class="cardHeader">
            <h2>Doctor Schedules</h2>
            <div class="sort-container" style="display: flex; align-items: center; gap: 10px;">
                <div class="search" id="searchdiv">
                    <label>
                        <input type="text" id="searchInput" placeholder="Search here" value="{{ request('search') }}">
                    </label>
                </div>
                <a href="{{ route('doctor-schedule.create') }}" class="btn btn-primary">Add New Schedule</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($doctors as $doctor)
    @php
        $schedule = $doctor->schedules()
            ->whereDate('date', now()->toDateString())
            ->latest()
            ->first();
    @endphp
    <tr>
        <td>{{ $doctor->name }}</td>
        <td>{{ $doctor->email }}</td>
        <td>{{ $schedule ? $schedule->availability : 'N/A' }}</td>
        <td>
            <form action="{{ route('doctor-schedule.toggle', $doctor->id) }}" method="POST">
                @csrf
                <input type="hidden" name="availability" value="{{ ($schedule && $schedule->availability === 'present') ? 'absent' : 'present' }}">
                <button type="submit" class="btn btn-danger">
                    {{ ($schedule && $schedule->availability === 'present') ? 'Mark Absent' : 'Mark Present' }}
                </button>
            </form>
        </td>
    </tr>
@endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            const searchValue = this.value.trim();
            window.location.href = "{{ route('doctor-schedule.index') }}" +
                (searchValue ? `?search=${encodeURIComponent(searchValue)}` : '');
        }
    });

    if (searchInput.value === '') {
        searchInput.addEventListener('blur', function() {
            if (this.value === '') {
                window.location.href = "{{ route('doctor-schedule.index') }}";
            }
        });
    }

    // Auto-hide messages after 5s
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';
    }, 5000);
});
</script>
@endsection
