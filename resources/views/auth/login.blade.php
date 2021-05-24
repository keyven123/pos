<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="POS">
		<meta name="Author" content="Keyven POS">
		<meta name="Keywords" content="delivery, service, services, food near me, restaurants, pos"/>

		<!-- Title -->
		<title> Jollitea POS </title>

		<!-- Logo -->
		<link rel="icon" href="{!! asset('images/Jollitea.jpg') !!}" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="../../assets/css/icons.css" rel="stylesheet">

		<!--- Style css --->
		<link href="../../assets/css/style.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="../../assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="../../assets/css/animate.css" rel="stylesheet">
		<style>
			.login-background{
				background-color: skyblue;
			}
			.btn-get-started {
				font-family: "Raleway", sans-serif;
				font-weight: 500;
				font-size: 16px;
				letter-spacing: 1px;
				display: inline-block;
				padding: 10px 30px;
				border-radius: 50px;
				text-decoration:none;
				transition: 0.5s;
				color: #fff;
				border: 2px solid #fff;
			}
			.btn-get-started:hover{
				color:#fff !important;
				background-color: #3498db !important;
				border: 2px solid #3498db !important;
			}
			.radius-border{
				border-radius: 50px;
			}
			.under{
				text-decoration: underline
			}
			
		</style>

	</head>
	<body class="error-page1  bg-light">

		<!-- Loader -->
		<div id="global-loader">
			<img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div class="container-fluid">
				<div class="row no-gutter">
					<!-- The image half -->
					<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex login-background">
						<div class="row wd-100p mx-auto text-center">
							<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
								<div class="container">
									<div class="row">
										<div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
										<h1 data-aos="fade-up" class="aos-init aos-animate">Welcome to Jollitea!</h1>
										<!-- <h2 data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">We provide services to serve you. Download our App</h2>
										<div class="row">
											<div class="col-lg-6 text-left">
												<div style="display:inline;" class="aos-init aos-animate">
													<a href="https://play.google.com/store/apps/details?id=com.pluckoo_buyer" target="_blank" class="btn-get-started scrollto">Download Buyer App</a>
												</div>
											</div>
											<div class="col-lg-6 text-left">
												<div style="display:inline;" class="aos-init aos-animate">
													<a href="https://play.google.com/store/apps/details?id=com.pluckoo_rider_v1" target="_blank" class="btn-get-started scrollto">Download Rider App</a>
												</div>
											</div>
										</div> -->
										</div>
										<div class="col-lg-6 order-1 order-lg-2 hero-img aos-init aos-animate" data-aos="fade-left" data-aos-delay="200">
										<img src="/images/delivery.png" class="img-fluid animated" alt="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- The content half -->
					<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
						<div class="login d-flex align-items-center py-2">
							<!-- Demo content-->
							<div class="container p-0">
								<div class="row">
									<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
										<div class="card-sigin">
											<div class="mb-5 d-flex"> <a href="/"><img src="images/jollitea-6.jpg" class="img-fluid" alt="pluckoo-logo"></a></div>
											<div class="card-sigin">
												<div class="main-signup-header">
												<!-- <div  class="d-flex justify-content-center"> -->
													<h2 style="color: black">Welcome back!</h2>
												<!-- </div> -->
													<h5 class="font-weight-semibold mb-4">Please {{ __('Login') }}</h5>
													<form method="POST" action="{{ route('login') }}">
                                                    @csrf
														<div class="form-group">
                                                            <label for="email">{{ __('E-Mail Address') }}</label> 
                                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                            @if($errors->any())
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{$errors->first()}}</strong>
                                                                </span>
                                                            @endif
														</div>
														<div class="form-group">
                                                            <label for="password">{{ __('Password') }}</label> 
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                        
                                                            <div class="d-flex justify-content-between mt-3">
																<div class="d-flex">
																	<div class="form-check">
																		<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

																		<label class="form-check-label" for="remember">
																			{{ __('Remember Me') }}
																		</label>
																	</div>
																</div>
																<div class="d-flex">
																	
																</div>
															</div>

                                                        </div><button type="submit" class="btn btn-main-primary btn-block radius-border">{{ __('Login') }}</button>
														
													</form>
													<hr>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- End -->
						</div>
					</div><!-- End -->
				</div>
			</div>

		</div>
		<!-- End Page -->

		<!-- JQuery min js -->
		<script src="../../assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Ionicons js -->
		<script src="../../assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="../../assets/plugins/moment/moment.js"></script>

		<!-- eva-icons js -->
		<script src="../../assets/js/eva-icons.min.js"></script>

		<!-- Rating js-->
		<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js"></script>

	</body>
</html>