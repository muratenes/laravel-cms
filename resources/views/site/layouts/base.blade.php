<!DOCTYPE html>
<html lang="tr-TR">
<head>
    <meta name="robots" content="noindex">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="copyright" content="(c) 2017"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta property="og:site_name" content="{{ $site->title }}"/>
    <meta property="og:locale" content="tr_TR"/>
    <link rel="shortcut icon" href="/uploads/site/favicon.ico"/>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/site/assets/images/icons/favicon.ico">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="/site/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/site/assets/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="/site/assets/vendor/fontawesome-free/css/all.min.css">
    @yield('header')
</head>
<body>


<div class="page-wrapper">
    @include('site.layouts.partials.header')
    <main class="main">
        @yield('content')
    </main><!-- End .main -->
    @include('site.layouts.partials.footer')
</div>


</body>
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

<!-- Plugins JS File -->
<script src="/site/assets/js/jquery.min.js"></script>
<script src="/site/assets/js/bootstrap.bundle.min.js"></script>
<script src="/site/assets/js/plugins.min.js"></script>

<!-- Main JS File -->
<script src="/site/assets/js/main.min.js"></script>
{{--<script--}}
{{--    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"--}}
{{--    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="--}}
{{--    crossorigin="anonymous"></script>--}}

<script src="/js/ecommerce.js"></script>


@yield('footer')
</html>
