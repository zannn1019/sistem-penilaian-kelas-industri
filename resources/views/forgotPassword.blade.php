<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot password</title>
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>

<body class="w-full h-screen flex justify-center items-center bg-bg bg-cover overflow-hidden" data-theme="light">
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
    </div>
    <form class="w-full items-center flex flex-col gap-5 max-w-xs bg-white" action="{{ route('password.email') }}"
        method="POST">
        @csrf
        <img src="{{ asset('img/logo.png') }}" class="w-20" alt="">
        <span class="text-sm">Mohon masukkan alamat email akun Anda, kami akan kirimkan tautan reset kata sandi.</span>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input required type="text" placeholder="Masukkan alamat email"
                class="input input-bordered input-info w-full max-w-xs" name="email" />
        </div>
        <button type="submit" class="btn btn-info w-full max-w-xs text-white">LANJUTKAN</button>
    </form>
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
        });
    </script>
</body>

</html>
