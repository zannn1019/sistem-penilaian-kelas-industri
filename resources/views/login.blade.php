<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>{{ $title }}</title>
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body class="h-screen overflow-hidden">
    <div class="container-fluid w-full h-full flex justify-center items-center">
        <div class="absolute z-10 top-0 left-0 p-5">
            <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-16">
        </div>
        <img src="{{ asset('img/login_bg.png') }}" alt=""
            class="absolute top-0 left-0 w-full h-full object-cover">
        <div
            class="login z-10 bg-white p-10 rounded-box w-1/2 max-sm:w-10/12 justify-center items-center flex flex-col gap-3">
            <h1 class="text-5xl text-bluesky-500 font-bold">Login</h1>
            <p class="text-center text-black text-md">Masukkan Username dan Password Anda. Kami akan segera mengarahkan
                Anda ke
                halaman Dashboard.</p>
            <form action="/login" method="POST" class="flex flex-col w-10/12 max-sm:w-full h-full gap-3">
                @if (Session::has('error'))
                    <div class="alert bg-red-100 border border-error text-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ Session::get('error') }}</span>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert bg-green-100 border border-success text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ Session::get('success') }}</span>
                    </div>
                @endif
                @csrf
                <div
                    class="login-input text-white p-0 input input-bordered focus:outline-none flex gap-2 bg-gray-200 rounded-3xl">
                    <div class="icon bg-bluesky-500 px-4 py-3 rounded-full">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="username" placeholder="Username" id="username"
                        class="bg-transparent  w-full  focus:border-none text-black focus:bg-transparent" required>
                </div>
                <div
                    class="login-input text-white p-0 input input-bordered focus:outline-none flex gap-2 bg-gray-200 rounded-3xl">
                    <div class="icon bg-bluesky-500 px-4 py-3 rounded-full">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <input type="password" name="password" placeholder="Password" id="password"
                        class="bg-transparent w-full  focus:border-none text-black " required>
                </div>
                <a href="{{ route('forgot-password') }}" class="text-bluesea-500 hover:underline">Lupa password? </a>
                <div class="submit-btn w-full flex justify-center items-center">
                    <input type="submit" value="Login" id="submit_btn"
                        class="btn text-white text-xl px-10 shadow-xl rounded-box pointer-events-none bg-gray-200 border-2 border-none hover:bg-bluesky-500">
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script>
        $("#username, #password").on('input', function() {
            var usernameValue = $("#username").val();
            var passwordValue = $("#password").val();
            if (usernameValue !== '' && passwordValue !== '') {
                $("#submit_btn").removeClass("pointer-events-none")
                $("#submit_btn").removeClass("bg-gray-200")
                $("#submit_btn").addClass("bg-bluesky-500")
            } else {
                $("#submit_btn").addClass("pointer-events-none")
                $("#submit_btn").addClass("bg-gray-200")
                $("#submit_btn").removeClass("bg-bluesky-500")
            }
            $("#username, #password").keydown(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
