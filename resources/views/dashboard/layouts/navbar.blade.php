@if (auth()->user()->role == 'pengajar')
    <nav class="navbar h-20 flex p-5">
        <div class="navbar-start flex gap-2 max-sm:w-96">
            <div
                class="user max-sm:flex text-white rounded-box shadow-xl text-2xl hidden flex-col justify-center items-center gap-3 max-md:flex-row pointer-events-auto">
                <a href="" class="bg-darkblue-500 px-3 py-2 rounded-full shadow-lg">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>
            <div class="dropdown hidden max-sm:inline-block max-md:inline-block">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-darkblue-500 rounded-box w-52 z-40">
                    <li><a href="{{ route('dashboard-pengajar') }}"
                            class="{{ $title == 'Dashboard' ? 'text-white' : '' }}">DASHBOARD</a></li>
                    <li><a href="{{ route('nilai') }}" class="{{ $title == 'Nilai' ? 'text-white' : '' }}">NILAI</a>
                    </li>
                    <li><a href="{{ route('kelas.index') }}"
                            class="{{ $title == 'Kelas' ? 'text-white' : '' }}">KELAS</a>
                    </li>
                    <li>
                        <label for="my_modal_7" class="hover:text-crimson">
                            <span class="text-xs">LOG OUT</span></label>
                    </li>
                </ul>
            </div>
            <input type="checkbox" id="my_modal_7" class="modal-toggle" />
            <div class="modal">
                <div
                    class="modal-box border border-gray-400 bg-darkblue-500 text-white flex flex-col gap-3 justify-center items-center">
                    <i
                        class="fa-solid fa-exclamation text-8xl border-2 px-12 py-2 rounded-6xl text-crimson border-crimson"></i>
                    <h1 class="text-center">Apakah Anda yakin ingin logout? <br> <i class="font-thin">Click dimana saja
                            untuk
                            menutup.</i></h1>
                    <div class="flex gap-5">
                        <form action="/logout" method="POST">
                            @csrf
                            <input type="submit" value="Logout" class="btn btn-error">
                        </form>
                    </div>
                </div>
                <label class="modal-backdrop" for="my_modal_7"></label>
            </div>
            {{-- <button class="rounded-full px-3 py-2 max-sm:px-2 max-sm:py-1 text-bluesea-500 bg-white relative">
                <i class="fa-solid fa-bell"></i>
                <div class="w-3 h-3 bg-red-500 rounded-full absolute -top-0 -right-0"></div>
            </button> --}}
        </div>
        <div class="navbar-center flex gap-5 font-semibold max-sm:text-xs max-sm:hidden max-md:hidden">
            <a href="{{ route('dashboard-pengajar') }}"
                class="{{ $title == 'Dashboard' ? 'text-white' : '' }}">DASHBOARD</a>
            <a href="{{ route('nilai') }}" class="{{ $title == 'Nilai' ? 'text-white' : '' }}">NILAI</a>
            <a href="{{ route('kelas.index') }}" class="{{ $title == 'Kelas' ? 'text-white' : '' }}">KELAS</a>
        </div>
        <div class="navbar-end ">
            <div class="search-bar bg-tosca-500 px-4 py-2 rounded-box text-black">
                <input type="text"
                    class="max-sm:hidden max-md:hidden bg-transparent focus:border-none focus:outline-none text-black placeholder:text-sm placeholder:italic placeholder:font-thin"
                    placeholder="Type here to search...">
                <button
                    class="fa-solid fa-magnifying-glass max-sm:border-none max-md:border-none max-md:pl-0 max-sm:pl-0 border-l-black border-l pl-3 py-1"></button>
            </div>
        </div>
    </nav>
@else
    <nav class="navbar h-20 flex p-5">
        <div class="navbar-start flex gap-2 max-sm:w-96">
            <div
                class="user max-sm:flex text-white rounded-box shadow-xl text-2xl hidden flex-col justify-center items-center gap-3 max-md:flex-row pointer-events-auto">
                <a href="" class="bg-darkblue-500 px-3 py-2 rounded-full shadow-lg">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>
            <div class="dropdown hidden max-sm:inline-block max-md:inline-block">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-darkblue-500 rounded-box w-52 z-40">
                    <li><a href="{{ route('dashboard-admin') }}"
                            class="{{ $title == 'Dashboard' ? 'text-white' : '' }}">DASHBOARD</a></li>
                    <li><a href="{{ route('sekolah.index') }}"
                            class="{{ $title == 'Sekolah' ? 'text-white' : '' }}">SEKOLAH</a>
                    </li>
                    <li><a href="{{ route('pengajar.index') }}"
                            class="{{ $title == 'Pengajar' ? 'text-white' : '' }}">PENGAJAR</a>
                    </li>
                    <li>
                        <label for="my_modal_7" class="hover:text-crimson">
                            <span class="text-xs">LOG OUT</span></label>
                    </li>
                </ul>
            </div>
            <label for="my_modal_7"
                class="bg-white max-sm:hidden rounded-box cursor-pointer text-sm px-4 max-sm:px-2 max-sm:py-1 py-2 shadow-lg text-bluesea-500">
                <i class="fa-solid fa-door-open"></i> <span class="text-xs">LOG OUT</span>
            </label>

            <input type="checkbox" id="my_modal_7" class="modal-toggle" />
            <div class="modal">
                <div
                    class="modal-box border border-gray-400 bg-darkblue-500 text-white flex flex-col gap-3 justify-center items-center">
                    <i
                        class="fa-solid fa-exclamation text-8xl border-2 px-12 py-2 rounded-6xl text-crimson border-crimson"></i>
                    <h1 class="text-center">Apakah Anda yakin ingin logout? <br> <i class="font-thin">Click dimana
                            saja
                            untuk
                            menutup.</i></h1>
                    <div class="flex gap-5">
                        <form action="/logout" method="POST">
                            @csrf
                            <input type="submit" value="Logout" class="btn btn-error">
                        </form>
                    </div>
                </div>
                <label class="modal-backdrop" for="my_modal_7"></label>
            </div>
            {{-- <button class="rounded-full px-3 py-2 max-sm:px-2 max-sm:py-1 text-bluesea-500 bg-white relative">
                <i class="fa-solid fa-bell"></i>
                <div class="w-3 h-3 bg-red-500 rounded-full absolute -top-0 -right-0"></div>
            </button> --}}
        </div>
        <div class="navbar-center flex gap-5 font-semibold max-sm:text-xs max-sm:hidden max-md:hidden">
            <a href="{{ route('dashboard-admin') }}"
                class="{{ $title == 'Dashboard' ? 'text-white' : '' }}">DASHBOARD</a>
            <a href="{{ route('sekolah.index') }}" class="{{ $title == 'Sekolah' ? 'text-white' : '' }}">SEKOLAH</a>
            <a href="{{ route('pengajar.index') }}"
                class="{{ $title == 'Pengajar' ? 'text-white' : '' }}">PENGAJAR</a>
        </div>
        <div class="navbar-end ">
            <div class="search-bar bg-tosca-500 px-4 py-2 rounded-box text-black">
                <input type="text"
                    class="max-sm:hidden max-md:hidden bg-transparent focus:border-none focus:outline-none text-black placeholder:text-sm placeholder:italic placeholder:font-thin"
                    placeholder="Type here to search...">
                <button
                    class="fa-solid fa-magnifying-glass max-sm:border-none max-md:border-none max-md:pl-0 max-sm:pl-0 border-l-black border-l pl-3 py-1"></button>
            </div>
        </div>
    </nav>
@endif
