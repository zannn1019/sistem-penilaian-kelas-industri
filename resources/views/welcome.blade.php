<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>{{ $title }}</title>
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container-fluid w-full h-screen max-sm:flex-col max-md:flex-col bg-darkblue-500 flex">
        <img src="{{ asset('img/index_img.png') }}" alt="" class="h-full max-sm:hidden max-md:hidden"
            draggable="false">
        <div
            class="greating w-full h-full text-end max-md:items-center max-md:text-center max-sm:items-center max-sm:text-center items-end flex p-10 flex-col justify-center gap-2">
            <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-32">
            <h1 class="text-tosca-500 text-7xl max-sm:text-3xl font-bold ">Sistem Penilaian Kelas
                Industri</h1>
            <h1 class="text-xl w-10/12 text-center text-white max-sm:text-sm ">Mudahkan pengerjaan
                Anda. Masukkan nilai dengan cepat, mudah dan efisien.
            </h1>
            <div class="w-full flex justify-center py-5">
                <a href="{{ route('login') }}"
                    class="btn btn-outline border-2 border-tosca-500 text-tosca-500 text-lg rounded-3xl hover:bg-tosca-500 hover:border-tosca-500 px-10">Login</a>
            </div>
        </div>
    </div>
</body>

</html>
