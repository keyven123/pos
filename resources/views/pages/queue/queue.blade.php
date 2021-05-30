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
            .header-left {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                background-color: #005cb9;
            }
            .header-right {
                position: fixed;
                left: 50%;
                top: 0;
                width: 100%;
                background-color: green;
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
            <div id="app">
                <queue></queue>
            </div>

		</div>
		<!-- End Page -->
        <script src="{{ mix('js/app.js') }}"></script>

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