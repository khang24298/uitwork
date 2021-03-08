<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <div class="flex-center position-ref full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <example-component></example-component>
                <div class="content">
                    <div class="title m-b-md">
                        Laravel
                    </div>

                    <div class="links">
                        <a href="https://laravel.com/docs">Docs</a>
                        <a href="https://laracasts.com">Laracasts</a>
                        <a href="https://laravel-news.com">News</a>
                        <a href="https://blog.laravel.com">Blog</a>
                        <a href="https://nova.laravel.com">Nova</a>
                        <a href="https://forge.laravel.com">Forge</a>
                        <a href="https://vapor.laravel.com">Vapor</a>
                        <a href="https://github.com/laravel/laravel">GitHub</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="float-contact">
   
            <script type="text/javascript">
                var array = ['0357791333','0374943343','0367878179'];
                var item = array[Math.floor(Math.random() * array.length)];
            </script>
            <div class="zalo">
                <a href="https://zalo.me/" onclick="window.open(this.href + item)" target="_blank">
                    <img alt="zalo" src="https://i.pinimg.com/originals/27/92/1e/27921eeb41b9bd80b61f14835a7b8b96.png" style="width: 40px; height: 40px;" />
                </a>
            </div>
        </div>


        <style type="text/css">


        @media (min-width: 1025px) {
        .float-contact {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 99999;
            text-align: left;
        }
        .chat-face, .hotline, .zalo, .face {
            overflow: hidden;
            border: none !important;
            background: none !important;
        }   
        .chat-face a, .hotline a, .zalo a, .face a {
            display: block;
            margin-bottom: 6px;
        }
        .chat-face a:hover, .hotline a:hover, .zalo a:hover, .face a:hover {
            background: #137b00;
            color: #fff;
            text-decoration: none;
        }
        .chat-face a img, .hotline a img, .zalo a img, .face a img {
            display: block;
            margin: auto;
        }
        .chat-face a, .hotline a, .zalo a, .face a {
            color: #000;
            text-align: center;
            display: block;
            font-size: 10px;
        }   
        }

        @media (max-width: 1024px) {
        .float-contact {
            position: fixed;
            bottom: 10%;
            z-index: 99999;
            display: flex;
            /* background: linear-gradient(#fff,#137b00); */
            width: 100%;
            height: 63px;
        }
        .face, .chat-face, .zalo, .hotline {
            width: 25%;
            text-align: center;
            margin: auto;
            border-left: 1px solid #fff;
            border-right: 1px solid #fff;
        }
        .face a img, .chat-face a img, .zalo a img, .hotline a img {
            display: block;
            margin: 5px auto 5px;
        }
        .face a, .chat-face a, .zalo a, .hotline a {
            color: #fff;
            font-size: 13px;
        }

        }
        </style>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
