    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name', 'Party Booker') }}</title>
    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/developer.css')}}">
    @yield('pageStyles')    
    <script>
        var BASE_URL = "{{URL::to('/admin')}}";
    </script> 