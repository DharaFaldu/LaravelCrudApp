<!DOCTYPE html>
<html>
<head>
    <title>TEST - CRUD APPLICATION</title>

    <link rel="stylesheet" href="{{ URL::asset('storage/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('storage/css/jquery.dataTables.min.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('storage/css/dataTables.bootstrap4.min.css') }}" >
    <script type="text/javascript" src="{{ URL::asset('storage/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('storage/js/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('storage/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('storage/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('storage/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('storage/js/fontawesome.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('storage/js/bootstrap-datepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('storage/css/bootstrap-datepicker3.css') }}"/>
    <style>
        .required {
            color: red;
        }
        .modal-dialog {
            max-width: 650px!important;
        }
    </style>
</head>
<body>

<div class="container">
    @yield('content')
</div>

</body>
</html>
