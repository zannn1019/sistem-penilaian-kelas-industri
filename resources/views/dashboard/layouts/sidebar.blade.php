@if (auth()->user()->role === 'pengajar')
    <div class="max-sm:hidden sidebar h-full w-28 flex bottom-0 left-0 justify-between flex-col items-center ">
        <div class="logo avatar p-5 ">
            <a href="{{ route('dashboard-pengajar') }}">
                <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-full" draggable="false">
            </a>
        </div>
        <div class="page_link text-white flex flex-col w-full gap-2">
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Arsip' ? 'bg-white text-black' : '' }}">
                <i class="fa fa-archive" aria-hidden="true"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">ARSIP</h1>
            </a>
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Riwayat' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">RIWAYAT EDIT</h1>
            </a>
        </div>
        <div class="user text-white p-5 text-2xl flex flex-col justify-center items-center gap-3 max-sm:flex-row">
            <a href="{{ route('profile-pengajar') }}" class=" rounded-full shadow-lg aspect-square overflow-hidden">
                <img src="{{ asset('storage/pengajar/' . auth()->user()->foto) }}" class="w-full h-full object-cover"
                    alt="">
            </a>
        </div>
    </div>
@else
    <div class="max-md:hidden sidebar h-full w-28 flex bottom-0 left-0 justify-between flex-col items-center py-3">
        <div class="log avatar p-5 ">
            <a href="{{ route('dashboard-admin') }}">
                <img src="{{ asset('img/logo_white.png') }}" alt="" class="w-full" draggable="false">
            </a>
        </div>
        <div class="page_link text-white flex flex-col w-full gap-2">
            <a href="{{ route('mapel.index') }}"
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Mapel' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">MAPEL</h1>
            </a>
            <a href=""
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Arsip' ? 'bg-white text-black' : '' }}">
                <i class="fa fa-archive" aria-hidden="true"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">ARSIP</h1>
            </a>
            <a href="{{ route('riwayatEditAdmin') }}"
                class="flex flex-col gap-2 text-center text-2xl justify-center items-center w-full py-3 rounded-l-6xl {{ $title == 'Riwayat Edit' ? 'bg-white text-black' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h1 class="text-2xs leading-3 max-sm:hidden">RIWAYAT EDIT</h1>
            </a>
        </div>
        <div
            class="user {{ $title == 'Profile' ? 'bg-white rounded-l-2xl text-white' : '' }} px-5 py-2 text-2xl flex flex-col justify-center items-center gap-3 max-sm:flex-row">
            <a href="{{ route('profile-admin') }}" class=" rounded-full shadow-lg aspect-square overflow-hidden">
                <img src="{{ asset('storage/pengajar/' . auth()->user()->foto) }}" class="w-full h-full object-cover"
                    alt="">
            </a>
        </div>
    </div>
@endif
