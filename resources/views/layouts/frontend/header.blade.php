<header class="header header-transparent rs-nav">
		<!-- main header -->
		<div class="sticky-header navbar-expand-lg">
			<div class="menu-bar clearfix">
				<div class="container-fluid clearfix">
					<!-- website logo -->
					<div class="menu-logo logo-dark">
						<a href="{{ asset('images/Screenshot_2025-04-22_233713-removebg-preview.png') }}" alt="" height = "10" width = "60"></a>
					</div>
					<!-- nav toggle button -->
					<button class="navbar-toggler collapsed menuicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#menuDropdown" aria-controls="menuDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- extra nav -->
					<div class="secondary-menu">
						<ul>
							
							<li class="btn-area"><a href="{{url('login')}}" class="btn btn-primary shadow">Login <i class="btn-icon-bx fas fa-chevron-right"></i></a></li>
						</ul>
					</div>
					<!-- Search Box ==== -->
                    <div class="nav-search-bar">
                        <form action="#">
                            <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                            <span><i class="ti-search"></i></span>
                        </form>
						<span id="searchRemove"><i class="ti-close"></i></span>
                    </div>
					<div class="menu-links navbar-collapse collapse justify-content-end" id="menuDropdown">
						<div class="menu-logo">
						    <a href="{{url('/')}}"><img src="{{asset('frontend/images/mediplus.png')}}" alt="" ></a>
						</div>
						<ul class="nav navbar-nav">	
							<li class="active"><a href="{{url('/')}}">Home</a></li>
		
							</li>
							
							<li><a href="{{url('booking')}}">Appointment<i class="fas fa-plus"></i></a>
								
	
						</ul>
					</div>
					<!-- Navigation Menu END ==== -->
				</div>
			</div>
		</div>
		<!-- main header END -->
	</header>