
@extends('layouts.backend.app')
@section('content')
<style>
    .schedule-card {
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        padding: 32px 28px 24px 28px;
    }
    .schedule-card h2 {
        margin-bottom: 24px;
        font-size: 1.7rem;
        color: #003c96;
        text-align: center;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #222;
    }
    .form-input, .form-select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #bfc9d1;
        border-radius: 6px;
        font-size: 1rem;
        background: #f8fafc;
        transition: border-color 0.2s;
    }
    .form-input:focus, .form-select:focus {
        border-color: #003c96;
        outline: none;
    }
    .availability-group {
        display: flex;
        gap: 24px;
        margin-top: 6px;
    }
    .availability-label {
        font-weight: 500;
        margin-left: 6px;
        cursor: pointer;
    }
    .form-actions {
        margin-top: 28px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .btn {
        padding: 9px 22px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        color: #fff;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background-color: #003c96;
    }
    .btn-primary:hover {
        background-color: #022d6f;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #b02a37;
    }
    .alert {
        color: #721c24;
        background-color: #f8d7da;
        padding: 12px 18px;
        margin-bottom: 18px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-size: 0.97rem;
    }
</style>

<div class="schedule-card">
    <h2>Edit Schedule</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctor-schedule.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="doctor_name" class="form-label">Doctor Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" value="{{ $schedule->doctor_name }}" required class="form-input">
        </div>

        <div class="form-group">
            <label for="date" class="form-label">Date:</label>
            <input type="date" id="date" name="date" value="{{ $schedule->date->format('Y-m-d') }}" required class="form-input">
        </div>

        <div class="form-group">
            <label for="start_time" class="form-label">Start Time:</label>
            <input type="time" id="start_time" name="start_time" value="{{ $schedule->start_time }}" required class="form-input">
        </div>

        <div class="form-group">
            <label for="end_time" class="form-label">End Time:</label>
            <input type="time" id="end_time" name="end_time" value="{{ $schedule->end_time }}" required class="form-input">
        </div>

        <div class="form-group">
            <span class="form-label">Availability:</span>
            <div class="availability-group">
                <label>
                    <input type="radio" id="present" name="availability" value="present" {{ $schedule->availability == 'present' ? 'checked' : '' }}>
                    <span class="availability-label">Available</span>
                </label>
                <label>
                    <input type="radio" id="absent" name="availability" value="absent" {{ $schedule->availability == 'absent' ? 'checked' : '' }}>
                    <span class="availability-label">Unavailable</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Schedule</button>
            <a href="{{ route('doctor-schedule.index') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>
@endsection