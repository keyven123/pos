<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
    <body class="error-page1  bg-light">
            <div class="container-fluid scrollDiv">
            <div class="row">
                <div class="col-lg-12 col-md-12 pt-5 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block">
                                    <div class="main-content-label mg-b-5">
                                        LICENSING DETAILS
                                    </div>
                                    <p class="mg-b-20">Please fill up all the details to activate the system.</p>
                                    @if($errors->any())
                                    <div class="alert alert-danger">
                                        <h4>{{$errors->first()}}</h4>
                                    </div>
                                    @endif
                                    <form method="POST" action="/license">
                                        @csrf
                                        <div class="card card-body pd-20 pd-md-40 border shadow-none">
                                            <h5 class="card-title mg-b-20">Activation Requirements</h5>
                                            <div class="form-group">
                                                <label for="username" class="main-content-label tx-11 tx-medium tx-gray-600">USERNAME</label>
                                                <input id="username" name="username" class="form-control" required="" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="main-content-label tx-11 tx-medium tx-gray-600">PASSWORD</label>
                                                <input id="password" name="password" class="form-control" required="" type="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="license" class="main-content-label tx-11 tx-medium tx-gray-600">LICENSE KEY</label>
                                                <input id="license" name="license" class="form-control" required="" type="text">
                                            </div>
                                            <button class="btn btn-main-primary btn-block">Submit Details</button>
                                        </div>
                                    </form>
                                    <div class="d-flex justify-content-center">
                                        <p>System is activated already?</p><br>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div >
                                                <a class="under" href="{{ route('login') }}">Sign in now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
