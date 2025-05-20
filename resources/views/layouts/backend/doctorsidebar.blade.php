<div class="navigation">
    <ul>
        <li>
            <a href="#">
                <span class="icon">
                    <img src="{{ url('frontend/images/mediplus.png')}}" alt="Logo" style="height: 60px;">
                </span>
                <span class="title">CLICK N' CARE</span>
            </a>
        </li>

       <li>
    <a href="{{ route('doctor.dashboard') }}">
        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
        <span class="title">Dashboard</span>
    </a>
</li>

        <li>
            <a href="{{ route('appointments-new') }}">
                <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                <span class="title">Appointments</span>
            </a>
        </li>

        <li>
            <a href="{{ route('doctor-schedule.index') }}">
                <img src="{{ url('frontend/images/doctors.png')}}" alt="Logo" style="height: 60px;">
                <span class="title">Doctor Schedule</span>
            </a>
        </li>

      <li>
    <a href="{{ route('archive.index') }}">
        <span class="icon"><ion-icon name="archive-outline"></ion-icon></span>
        <span class="title">Archive</span>
    </a>
</li>

        <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                <span class="title">Sign Out</span>
            </a>
        </li>
    </ul>
</div>
