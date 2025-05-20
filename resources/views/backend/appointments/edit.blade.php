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
        padding: 8px;
        text-align: left;
        word-wrap: break-word;
    }

    th {
        background-color: #2a2185;
        color: white;
    }

    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 8px;
    }

    .form-container input, 
    .form-container select, 
    .form-container textarea,
    .form-container button {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border-radius: 30px;
        border: 1px solid #ddd;
    }

    .form-container textarea {
        height: 100px;
        border-radius: 10px;
    }

    .form-container button {
        background-color: #2a2185;
        color: white;
        border: none;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #1b165b;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
</style>
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Edit Appointment</h2>
            <a href="{{ route('appointments-new') }}" class="btn">Back to Appointments</a>
        </div>
        
        <div id="messageContainer">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Errors:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="form-container">
            <form id="appointmentForm" action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $appointment->name) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $appointment->email) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="studentid">Student ID</label>
                    <input type="text" name="studentid" id="studentid" value="{{ old('studentid', $appointment->studentid) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $appointment->phone) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="doctor">Course</label>
                    <input type="text" name="doctor" id="doctor" value="{{ old('doctor', $appointment->doctor) }}" required>
                </div>
                
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="Pending" {{ old('status', $appointment->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status', $appointment->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Completed" {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
<!-- Inside your form, modify the message textarea part -->
<div class="form-group">
    <label for="message">Message</label>
    <textarea 
        name="message" 
        id="message" 
        placeholder="E.g., Your appointment is scheduled for [time]. Please arrive 10 minutes early."
    >{{ old('message', $appointment->message) }}</textarea>
</div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="send_email" value="1" checked>
                        Send confirmation email
                    </label>
                </div>
                
                <div>
                    <button type="submit" id="submitBtn">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointmentForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Success - show message
                document.getElementById('messageContainer').innerHTML = `
                    <div class="alert alert-success">
                        ${data.message}
                        ${data.email_sent ? '<br>Confirmation email sent to ' + data.email : ''}
                    </div>
                `;
                
                // Scroll to show the message
                document.getElementById('messageContainer').scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Optionally reset the form or redirect after a delay
                setTimeout(() => {
                    window.location.href = "{{ route('appointments-new') }}";
                }, 2000);
            } else {
                // Error - show message
                let errorHtml = '<div class="alert alert-danger"><strong>Error:</strong><ul>';
                
                if (data.errors) {
                    // Laravel validation errors
                    for (const field in data.errors) {
                        data.errors[field].forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                    }
                } else if (data.message) {
                    // Single error message
                    errorHtml += `<li>${data.message}</li>`;
                } else {
                    // Unknown error format
                    errorHtml += `<li>An unknown error occurred. Please try again.</li>`;
                }
                
                errorHtml += '</ul></div>';
                document.getElementById('messageContainer').innerHTML = errorHtml;
                
                // Scroll to show the error
                document.getElementById('messageContainer').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        } catch (error) {
            document.getElementById('messageContainer').innerHTML = `
                <div class="alert alert-danger">
                    Network error: ${error.message}
                </div>
            `;
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Appointment';
        }
    });
});
</script>
@endsection