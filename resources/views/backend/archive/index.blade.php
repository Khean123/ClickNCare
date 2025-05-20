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
    
    /* Button styles */
    .btn-restore {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .btn-force-delete {
        background-color: #dc3545;
        color: white;
        padding: 0.5px 4px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
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
    <div class="recentOrders" style="width: 110%;">
        <div class="cardHeader">
            <h2>Archived Appointments</h2>
            <div class="search" id="searchdiv">
                <label>
                    <input type="text" id="searchInput" placeholder="Search here">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
        </div>
        
        <div class="table-container">
            <table style="width: 100%;">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivedAppointments as $appointment)
                    <tr>
                        <td style="text-align: left;">{{ $appointment->studentid }}</td>
                        <td style="text-align: left;">{{ $appointment->doctor }}</td>
                        <td style="text-align: left;">{{ $appointment->name }}</td>
                        <td style="text-align: left;">{{ $appointment->phone }}</td>
                        <td style="text-align: left;">{{ $appointment->appointment_date }}</td>
                        <td style="text-align: left;">{{ $appointment->email }}</td>
                        <td style="text-align: left;">{{ $appointment->created_at->format('H:i') }}</td>
                        <td style="text-align: left;">{{ $appointment->status }}</td>
                        <td style="text-align: left;">
                            <div class="cardHeader" style="justify-content:space-evenly;">
                                <a href="{{ route('archive.restore', $appointment->id) }}" 
                                   class="btn-restore">Restore</a>
                                   
                                <form action="{{ route('archive.force-delete', $appointment->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-force-delete" 
                                            onclick="return confirm('Permanently delete this appointment?')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row cardHeader" style="margin-top: 150px; justify-content: space-between;">
            <div class="col-md-6">
                <!-- Empty div for alignment -->
            </div>
            <div class="col-md-6">
                @if($archivedAppointments->currentPage() > 1)
                    <a href="?page={{ $archivedAppointments->currentPage() - 1 }}" class="btn">Previous</a>
                @endif
                
                @if($archivedAppointments->hasMorePages())
                    <a href="?page={{ $archivedAppointments->currentPage() + 1 }}" class="btn">Next</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection