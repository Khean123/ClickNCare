<div class="topbar">
    <div class="toggle">
        <ion-icon name="menu-outline"></ion-icon>
    </div>

    <!--<div class="search">-->
    <!--    <label>-->
    <!--        <input type="text" placeholder="Search here">-->
    <!--        <ion-icon name="search-outline"></ion-icon>-->
    <!--    </label>-->
    <!--</div>-->


</div>
<!-- ======================= Cards ================== -->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers">{{ $totalAppointmentsCount }}</div>
            <div class="cardName">Total Appointments</div>
        </div>
    </div>
    
    <div class="card">
        <div>
            <div class="numbers">{{ $totalUserCount }}</div>
            <div class="cardName">Total Users</div>
        </div>
    </div>
    <div class="card">
        <div>
            <div class="numbers">{{ $totalDoctorSchedulesCount }}</div>
            <div class="cardName">Doctor Schedules</div>
        </div>
    </div>
</div>