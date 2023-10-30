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
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @yield('head')
</head>

<body
    class="overflow-x-hidden max-sm:flex max-md:h-max max-md:min-h-screen h-screen max-md:grid max-md:place-content-center bg-gradient-to-tr from-bluesky-500 from-10% to-darkblue-500 to-90%">
    <div class="absolute -right-3 top-3 w-auto z-50 flex flex-col gap-2 max-sm:w-11/12" id="alert-box">
        @if (Session::has('success'))
            <div
                class="alert max-sm:w-11/12 max-sm:flex bg-green-200 text-success border border-success w-auto shadow-xl opacity-0 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24" id="alert-box-success">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ Session::get('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $index => $error)
                <div class="alert max-sm:w-11/12 max-sm:flex bg-red-200 text-error border border-error w-auto shadow-xl opacity-0 pointer-events-none"
                    id="error-{{ $index }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        @endif
        @if (Session::has('error'))
            <div
                class="alert max-sm:w-11/12 max-sm:flex z-50 bg-red-200 text-error border border-error shadow-xl opacity-0 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24" id="alert-box-error">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ Session::get('error') }}</span>
            </div>
        @endif
    </div>

    <div class="container-fluid w-screen h-screen p-5 max-sm:p-0 a">
        <div
            class="container-fluid max-sm:pb-5 w-full h-full bg-white bg-opacity-30 max-sm:rounded-none rounded-box max-sm:px-2 flex max-sm:flex-col-reverse">
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"
        integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
    <script>
        $(document).ready(function() {
            $(this).find("#bubble-median").draggable()
            $("#bubble-median").dblclick(function() {
                $(this).find('.dropdown').toggleClass('dropdown-open')
            })
            $("#alert-box").find(".alert").each(function(index) {
                setTimeout(() => {
                    $(this).velocity({
                        properties: {
                            opacity: 1,
                            translateX: -20,
                        },
                        option: {
                            duration: 1000
                        },
                    })
                }, 200 * index);

                setTimeout(() => {
                    $(this).velocity({
                        properties: {
                            opacity: 0,
                            translateX: 0,
                        },
                        option: {
                            duration: 1000
                        },
                    });
                    setTimeout(() => {
                        $(this).remove()
                    }, 1000);
                }, 1500 * (index + 1));
            });
            $("#global-search input").on("input", function() {
                let query = $(this).val();
                if (query != '') {
                    $("#global-search").find(".search-result").removeClass("hidden");
                    $.ajax({
                        type: "GET",
                        url: "{{ auth()->user()->role == 'pengajar' ? '/pengajar/search/' . auth()->user()->id : route('adminSearch') }}",
                        data: {
                            query: query
                        },
                        dataType: "JSON",
                        success: function(response) {
                            $("#global-search").find(".search-result").html("");
                            $.each(response, function(index, val) {
                                if (val.length > 0) {
                                    let title =
                                        `<div class="title w-full bg-tosca-600 px-4 py-1 font-semibold capitalize">${index}</div>`;
                                    $("#global-search").find(".search-result").append(
                                        title);
                                }
                                $.each(val, function(i, data) {
                                    let result =
                                        `<a class="result-item px-4 py-2 hover:bg-tosca-300 w-full flex flex-col font-semibold" href="${data.url}">${data.nama} ${data.desc != null ? '<br><small class="font-normal">' + data.desc + '</small>' : ''}</a>`;
                                    $("#global-search").find(".search-result")
                                        .append(
                                            result);
                                });
                            });
                        }
                    });
                } else {
                    $("#global-search").find(".search-result").addClass("hidden");
                }
            })
        });
    </script>
    @yield('script')
</body>

</html>
