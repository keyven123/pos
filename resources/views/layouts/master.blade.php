<!DOCTYPE html>
<html lang="en">
	<head>

		@include('includes.head')
		
        <style>
        .main-logo {
            height: 2.5rem;
            width: 8rem;
        }
        </style>
	</head>

	<body class="hoversubmenu main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div id="app"  class="page">

			@include('includes.sidebar')

			<!-- main-content -->
			<div class="main-content app-content">

			    @include('includes.header')

				<!-- container -->
				<div class="container-fluid px-0">
					<router-view></router-view>
				</div>
				<!-- /Container -->
			</div>
			<!-- /main-content -->

			<!-- Sidebar-right-->
                @include('includes.sidebar-right')
			<!--/Sidebar-right-->

			<!-- Message Modal -->
				@include('includes.message')

			<!--Video Modal -->
				@include('includes.video')

			<!-- Audio Modal -->
				@include('includes.audio')

			<!-- Audio Footer -->
				@include('includes.footer')

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

        <script src="{{ mix('js/app.js') }}"></script>

		<!-- Bootstrap Bundle js -->

		<!--Internal  Chart.bundle js -->
		<script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

		<!-- Ionicons js -->
		<script src="{{ asset('assets/plugins/ionicons/ionicons.js') }}"></script>

		<!-- Moment js -->
		<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

		<!--Internal Sparkline js -->
		<script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

		<!-- Moment js -->
		<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

		<!--Internal  Flot js-->
		<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
		<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
		<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
		<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
		<script src="{{ asset('assets/js/dashboard.sampledata.js') }}"></script>
		<script src="{{ asset('assets/js/chart.flot.sampledata.js') }}"></script>


		<!-- Rating js-->
		<script src="{{ asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>
		<script src="{{ asset('assets/plugins/rating/jquery.barrating.js') }}"></script>

		<!--Internal  Perfect-scrollbar js -->
		<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

		<!-- Eva-icons js -->
		<script src="{{ asset('assets/js/eva-icons.min.js') }}"></script>

		<!-- right-sidebar js -->
		<script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>
		<script src="{{ asset('assets/plugins/sidebar/sidebar-custom.js') }}"></script>

		<!-- Sticky js -->
		<script src="{{ asset('assets/js/sticky.js') }}"></script>
		<script src="{{ asset('assets/js/modal-popup.js') }}"></script>

		<!-- Left-menu js-->
		<script src="{{ asset('assets/plugins/side-menu/sidemenu1.js') }}"></script>

		<!-- Internal Map -->
		<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>


		<!-- custom js -->
		<script src="{{ asset('assets/js/custom.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
	</body>
</html>