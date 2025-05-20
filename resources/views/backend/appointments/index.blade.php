@extends('layouts.backend.app')
@section('content')
<style>
    .sort-form {
    margin: 0;
}

.sort-select {
    padding: 8px 16px;
    background: #003c96;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 16px;
    padding-right: 32px;
}

.sort-select:hover {
    background-color: #002b6f;
}

.sort-select:focus {
    outline: none;
}
    .sort-container {
    display: flex;
    align-items: center;
    gap: 15px;
}

.sort-dropdown {
    position: relative;
}

.sort-btn {
    padding: 8px 16px;
    background: #003c96;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
}

.sort-btn:hover {
    background: #002b6f;
}

.sort-options {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 4px;
    z-index: 100;
    min-width: 180px;
}

.sort-options a {
    display: block;
    padding: 8px 16px;
    color: #333;
    text-decoration: none;
}

.sort-options a:hover {
    background: #f0f0f0;
}
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
        background-color:rgb(0, 60, 150);
        color: white;
    }
    
    @media screen and (max-width: 768px) {
        .search {
            display: none;
        }
    }
    
    /* Notification styles */
    .notification-container {
        width: 100%;
        margin-bottom: 20px;
    }
</style>

<!-- Notification container at the top -->
<div class="notification-container">
    @if(session('error'))
    <div class="alert alert-danger" id="errorMessage" style="display: {{ session('error') ? 'block' : 'none' }};
        color: #721c24;
        background-color: #f8d7da;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" id="successMessage" style="display: {{ session('success') ? 'block' : 'none' }};
        color: #155724;
        background-color: #d4edda;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;">
        {{ session('success') }}
    </div>
    @endif
</div>

<div class="details">
    <div class="recentOrders" style="width: 110%;"> <!-- Make the table container full width -->
      <div class="cardHeader">
    <h2>Recent Appointments</h2>
    
   <div class="sort-container" style="display: flex; align-items: center; gap: 10px;">
    <div class="search" id="searchdiv">
        <label>
            <input type="text" id="searchInput" placeholder="Search here">
            <ion-icon name="search-outline"></ion-icon>
        </label>
    </div>
        
       <form method="GET" action="{{ route('appointments-new') }}" class="sort-form">
        <input type="hidden" name="page" value="1"> <!-- Reset to page 1 when sorting -->
        
        <select name="sort_by" class="sort-select" onchange="this.form.submit()">
            <option value="">Sort By</option>
            <option value="appointment_date-desc" {{ request('sort_by') == 'appointment_date' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                Date (Newest First)
            </option>
            <option value="appointment_date-asc" {{ request('sort_by') == 'appointment_date' && request('sort_order') == 'asc' ? 'selected' : '' }}>
                Date (Oldest First)
            </option>
            <option value="name-asc" {{ request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'selected' : '' }}>
                Name (A-Z)
            </option>
            <option value="name-desc" {{ request('sort_by') == 'name' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                Name (Z-A)
            </option>
            <option value="status-asc" {{ request('sort_by') == 'status' && request('sort_order') == 'asc' ? 'selected' : '' }}>
                Status
            </option>
        </select>
    </form>
        
        <form method="POST" action="{{ route('appointments.deleteAll') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn" onclick="return confirm('Are you sure you want to archive all appointments?')">Archive All</button>
    </form>
</div>
    </div>
        <div class="table-container">
            <table style="width: 100%;"> <!-- Make table full width -->
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Course</th>
                        <th>Student Name</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Email</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table data -->
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td style="text-align: left;">{{ $appointment->studentid }}</td>
                        <td style="text-align: left;">{{ $appointment->doctor }}</td>
                        <td style="text-align: left;">{{ $appointment->name }}</td>
                        <td style="text-align: left;">{{ $appointment->phone }}</td>
                        <td style="text-align: left;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, Y') }}</td>
                        <td style="text-align: left;">{{ $appointment->email }}</td>
                       <td style="text-align: left;">{{ $appointment->created_at->format('h:i A') }}</td>
                        <td style="text-align: left;">{{ $appointment->status }}</td>
                        <td style="text-align: left;">
                            <div class="cardHeader" style="justify-content:space-evenly;">
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning" style="background-color: orange;">Edit</a>
                                
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')" style="background-color:red;">Archive</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination info -->
        <div class="row cardHeader" style="margin-top: 150px; justify-content: space-between;">
            <div class="col-md-6">
                <!-- Empty div for alignment -->
            </div>
            <div class="col-md-6">
               @if($appointments->currentPage() > 1)
    <a href="?page={{ $appointments->currentPage() - 1 }}&sort_by={{ request('sort_by') }}" class="btn">Previous</a>
@endif

@if($appointments->hasMorePages())
    <a href="?page={{ $appointments->currentPage() + 1 }}&sort_by={{ request('sort_by') }}" class="btn">Next</a>
@endif
            </div>
        </div>
    </div>
    
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/appointments-sort.js') }}"></script>
@endsection