@if (auth()->user()->role === 'pengajar')
    <div class="max-sm:hidden sidebar h-full w-28 flex bottom-0 left-0 justify-between flex-col items-center ">
        <div class="logo avatar p-5 ">
            <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-full" draggable="false">
        </div>
        <div class="page_link text-white flex flex-col gap-10 ">
            <a href="" class="flex flex-col gap-2 text-center text-2xl justify-center items-center">
                <i class="fa-solid fa-box-archive"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">ARSIP KELAS</h1>
            </a>
            <a href="" class="flex flex-col gap-2 text-center text-2xl justify-center items-center">
                <i class="fa-solid fa-print"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">CETAK RAPORT</h1>
            </a>
            <a href="" class="flex flex-col gap-2 text-center text-2xl justify-center items-center">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">RIWAYAT NILAI</h1>
            </a>
            <a href="" class="flex flex-col gap-2 text-center text-2xl justify-center items-center">
                <i class="fa-solid fa-gear"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">PENGATURAN</h1>
            </a>
        </div>
        <div class="user text-white p-5 text-2xl flex flex-col justify-center items-center gap-3 max-sm:flex-row">
            <a href="" class="bg-darkblue-500 px-3 py-2 rounded-full shadow-lg">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="" class="">
                <i class="fa-solid fa-message"></i>
            </a>
        </div>
    </div>

    <div class="max-sm:flex hidden w-full absolute h-20 bottom-0 left-0 z-10 items-center justify-between p-5 ">
        <div class="dropdown dropdown-top flex flex-col ">
            <div tabindex="0"
                class="bg-darkblue-500 py-2 px-1 rounded-circle w-16 h-16 flex items-center justify-center shadow-lg cursor-pointer">
                <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-10">
            </div>
            <div tabindex="0" class="dropdown-content z-[1] menu w-full flex flex-col gap-3 mb-2 ">
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-box-archive"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-print"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </div>
        </div>
        <div
            class="user text-white bg-bluesea-500 py-2 px-4 rounded-box shadow-xl text-2xl flex flex-col justify-center items-center gap-3 max-sm:flex-row">
            <a href="" class="bg-darkblue-500 px-3 py-2 rounded-full shadow-lg">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </div>
@else
    <div class="max-md:hidden sidebar h-full w-28 flex bottom-0 left-0 justify-between flex-col items-center ">
        <div class="logo avatar p-5 ">
            <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-full" draggable="false">
        </div>
        <div class="page_link text-white flex flex-col w-full gap-2">
            <a href="{{ route('mapel.index') }}"
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Mapel' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">MAPEL</h1>
            </a>
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'FAQ' ? 'bg-white text-black' : '' }}">
                <i class="fa-regular fa-message"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">FAQ</h1>
            </a>
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Pengaturan' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-gear"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">PENGATURAN</h1>
            </a>
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Riwayat' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">RIWAYAT EDIT</h1>
            </a>
        </div>
        <div class="user text-white p-5 text-2xl flex flex-col justify-center items-center gap-3 max-sm:flex-row">
            <a href="" class="bg-darkblue-500 px-3 py-2 rounded-full shadow-lg">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </div>

    <div class="max-md:flex z-50 hidden w-full fixed h-20 bottom-0 left-0 items-center justify-between p-5 pointer-events-none select-none"
        id="bubble-median">
        <div class="dropdown dropdown-top flex flex-col pointer-events-auto">
            <div tabindex="0"
                class="bg-darkblue-500 py-2 px-1 rounded-circle w-16 h-16 flex items-center justify-center shadow-lg cursor-pointer">
                <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-10">
            </div>
            <div tabindex="0" class="dropdown-content z-[1] menu w-full flex flex-col gap-3 mb-2 ">
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-book-bookmark"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-regular fa-message"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-gear"></i>
                </a>
                <a href=""
                    class="flex flex-col gap-2 text-center text-2xl justify-center items-center bg-bluesea-500 hover:bg-bluesea-700 text-white w-full p-3 rounded-circle">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </a>
            </div>
        </div>
    </div>
@endif
