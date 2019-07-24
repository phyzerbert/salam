<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="MultiStore Management System">
    <meta name="author" content="Yuyuan Zhang">

    <title>{{config("app.name")}}</title>

    <!-- vendor css -->
    <link href="{{asset('master/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('master/css/bracket.css')}}">
    @yield('style')
</head>

<body>

    @yield('content')

    <script src="{{asset('master/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('master/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('master/lib/bootstrap/bootstrap.js')}}"></script>

</body>
@yield('script')
</html>
