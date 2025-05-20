@extends('layouts.frontend.app')
@section('content')
<div class="page-content bg-white">
	
		<!-- Inner Banner -->
		<div class="banner-wraper">
			<div class="page-banner" style="background-image:url(frontend/images/banner/img1.jpg);">
				<div class="container">
					<div class="page-banner-entry text-center">
						<h1>Appointment</h1>
						<!-- Breadcrumb row -->
						<nav aria-label="breadcrumb" class="breadcrumb-row">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index-2.html"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Appointment</li>
							</ul>
						</nav>
					</div>
				</div>
				<img class="pt-img1 animate-wave" src="{{asset('frontend/images/shap/wave-blue.png')}}" alt="">
				<img class="pt-img2 animate2" src="{{asset('frontend/images/shap/circle-dots.png')}}" alt="">
				<img class="pt-img3 animate-rotate" src="{{asset('frontend/images/shap/plus-blue.png')}}" alt="">
			</div>
			<!-- Breadcrumb row END -->
		</div>
		<!-- Inner Banner end -->
			
		<!-- Appointment -->
		<section class="section-area section-sp2 appointment-wraper">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-5 col-lg-6 col-md-6">
						<div class="appointment-form form-wraper">
							<h3 class="title">Clinic Appointment</h3>
							@if(session('success'))
    <div class="alert alert-success text-center" style="background-color: #d1e7dd; border-left: 6px solid #0f5132; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <strong>{{ session('success') }}</strong>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center" style="background-color: #f8d7da; border-left: 6px solid #842029; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <strong>{{ session('error') }}</strong>
    </div>
@endif

							<form action="{{ route('submit.appointment') }}" method="POST">

								@csrf
								<div class="form-group">
        <input type="text" name="doctor" class="form-control @error('doctor') is-invalid @enderror" placeholder="Course">
        @error('doctor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
								
								<div class="form-group">
        <input type="text" name="studentid" class="form-control @error('studentid') is-invalid @enderror" placeholder="Student ID">
        @error('studentid')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
								<div class="form-group">
									<input type="text" name = "name" class="form-control  @error('name') is-invalid @enderror" placeholder="Your Name">
									@error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
								</div>
								<div class="form-group">
									<input type="number" name = "phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Numbers">
									@error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
								</div>
								<div class="form-group">
									<input type="date" class="form-control @error('appointment_date') is-invalid @enderror" name = "appointment_date">
									@error('appointment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
								</div>
								<div class="form-group">
									<input type="text" name = "email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
									@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
								</div>
								<button type="submit" class="btn btn-secondary btn-lg">Appointment Now</button>
							</form>
						</div>
					</div>
				</div>					
			</div>
		</section>
		
	</div>
@endsection