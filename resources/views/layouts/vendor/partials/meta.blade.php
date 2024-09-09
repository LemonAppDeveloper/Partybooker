    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Party Booker') }}</title>
    
    <link rel="stylesheet" type="text/css" href="{{asset('vendor-assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'>
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/plugins/toastr/toastr.min.css')}}">
    
    @yield('pageStyles')
	<link rel="stylesheet" type="text/css" href="{{asset('vendor-assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor-assets/css/developer.css')}}">
    
    <style>
         .pac-container {
            z-index: 10000 !important;
        }
    </style>
   
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe4wpJ11h1ZivefTePLG0iIOOQMAfIo3g&libraries=places"></script>
    <script>
        var BASE_URL = '{{  url("/") }}';
    </script>