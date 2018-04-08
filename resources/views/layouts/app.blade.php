<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    @yield('page-data')
</head>
<body>
    <div id="app">
        <div class="header">
            <div class="navigation">
                <img class="logo" src="./logo.png" />
                <a class="nav-link" href="/#/">Eyepeices</a>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a class="nav-link" href="/eyepiece">Manage Eyepieces</a>
                    <a class="nav-link" href="/manufacturer">Manufacturers</a>
                @endif
            </div>
            <div class="user-info">
                @if(Auth::check())
                    <span class="username epp-button"><i class="epp-button-icon usericon glyphicon glyphicon-user"></i> {{ Auth::user()->name }}</span>
                    <a class="logout-link nav-link" href="{{ url('/logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <a class="nav-link" href="/login">Login</a>
                    <a class="nav-link" href="/register">Register</a>
                @endif
            </div>
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script>
        window.eyepieces = JSON.parse('{!! $eyepieces !!}');
        window.telescopes = JSON.parse('{!! $telescopes_json !!}');
        window.auth = JSON.parse('{!! $auth !!}');

        // Add custom telescope
        if (window.telescopes.length === 0) {
            window.telescopes.push({
                name: 'Example 8" F/5.9 telescope',
                aperture: 203,
                focal_ratio: 5.9,
                focal_length: 1200,
                max_eyepiece_size: "3",
                id: Math.random().toString(36).substring(2, 5),
                is_custom: false
            });

            window.telescopes.push({
                name: 'Example 4" F/9 telescope',
                aperture: 102,
                focal_ratio: 9,
                focal_length: 918,
                max_eyepiece_size: "1.25",
                id: Math.random().toString(36).substring(2, 5),
                is_custom: false
            });
        }
    </script>
    @yield('page-script')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-91014085-1', 'auto');
        ga('send', 'pageview');

    </script>
</body>
</html>
