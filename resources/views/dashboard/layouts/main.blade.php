<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title> {{ Str::title(auth()->user()->role) }} - {{ $title }}</title>
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite('resources/css/app.css')
    @yield('head')
</head>

<body
    class="overflow-x-hidden max-sm:flex max-md:h-max max-md:min-h-screen h-screen max-md:grid max-md:place-content-center bg-gradient-to-tr from-bluesky-500 from-10% to-darkblue-500 to-90%">
    @if (Session::has('success'))
        <div
            class="alert max-sm:w-11/12 max-sm:flex z-50 bg-green-100 text-success border border-success absolute -right-3 top-3 w-auto shadow-xl opacity-0 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ Session::get('success') }}!</span>
        </div>
    @endif
    @if (Session::has('error'))
        <div
            class="alert max-sm:w-11/12 max-sm:flex z-50 bg-red-200 text-error border border-error absolute -right-3 top-3 w-auto shadow-xl opacity-0 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ Session::get('error') }}!</span>
        </div>
    @endif
    <div class="container-fluid w-full h-full p-5 max-sm:p-0 max-h-full">
        <div
            class="container w-full h-full bg-white bg-opacity-30 max-sm:rounded-none rounded-box max-sm:px-2 flex max-sm:flex-col-reverse">
            @include('dashboard.layouts.sidebar')
            @if ($full == true)
                <div class="content w-full h-full flex flex-col">
                    <div class="w-full h-full bg-white rounded-box shadow-xl overflow-auto relative">
                        @yield('content')
                    </div>
                </div>
            @else
                <div class="content w-full h-full flex flex-col p-3 max-md:p-0">
                    @include('dashboard.layouts.navbar')
                    <div class="w-full h-full bg-white rounded-box shadow-xl overflow-auto">
                        @yield('content')
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
    <script>
        $(".alert").velocity({
            properties: {
                opacity: 1,
                translateX: -20,
            },
            option: {
                duration: 800
            }
        })
        setTimeout(() => {
            $(".alert").velocity({
                properties: {
                    opacity: 0,
                    translateX: -0,
                },
                option: {
                    duration: 800
                }
            })
        }, 3000);
    </script>
    @yield('script')
</body>

</html>
