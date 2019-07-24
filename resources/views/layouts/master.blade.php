<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="MultiStore Management System">
    <meta name="author" content="Yuyuan Zhang">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config("app.name")}}</title>

    <!-- vendor css -->
    <link href="{{asset('master/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Bracket CSS -->
    @yield('style')
    <link rel="stylesheet" href="{{asset('master/css/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('master/css/custom.css')}}">
    
</head>

<body>
    <div id="ajax-loading" class="text-center">
        <img class="mx-auto" src="{{asset('images/loader.gif')}}" width="70" alt="" style="margin:45vh auto;">
    </div>
    @include('layouts.aside')

    @include('layouts.header')
    
    @yield('content')    

    <script src="{{asset('master/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('master/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('master/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('master/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('master/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('master/lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
    <script src="{{asset('master/lib/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('master/lib/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('master/lib/moment/moment.js')}}"></script>

    <script src="{{asset('master/js/bracket.js')}}"></script>
    
    @yield('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function showloader(){
            $("#ajax-loading").show();
        }
        $(document).ready(function(){
            $("#ajax-loading").hide();
        });
    </script>

    <script>
        var notification = '<?php echo session()->get("success"); ?>';
        if(notification != ''){
            toastr_call("success","Success",notification);
        }
        var errors_string = '<?php echo json_encode($errors->all()); ?>';
        errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
        var errors = errors_string.split(",");
        if (errors_string != "") {
            for (let i = 0; i < errors.length; i++) {
                const element = errors[i];
                toastr_call("error","Error",element);             
            } 
        }       

        function toastr_call(type,title,msg,override){
            toastr[type](msg, title,override);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }  
        }
    </script>
</body>
</html>
