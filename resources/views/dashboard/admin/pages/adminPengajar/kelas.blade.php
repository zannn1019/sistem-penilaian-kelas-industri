@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full p-5 flex flex-col gap-2">
        <header class="w-full flex justify-between gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 items-center">
                <a href="{{ route('pengajar.show', ['pengajar' => $info_pengajar->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                            <li><a href="{{ route('pengajar.show', ['pengajar' => $info_pengajar->id]) }}">Profil
                                    Pengajar</a>
                            </li>
                            <li>Kelas Pengajar</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold">Kelas Pengajar <span
                            class="text-sm">({{ $info_pengajar->kelas()->count() }})</span>
                    </h1>
                </div>
            </div>
            @include('dashboard.admin.pages.adminPengajar.components.switch')
        </header>
        <div
            class="w-full h-24 max-sm:h-auto max-sm:gap-5 max-md:grid-cols-1 max-md:h-auto grid grid-cols-2 max-sm:grid-cols-1 text-black p-5 max-sm:px-5 px-10 z-10 place-content-end">
            <div class="info flex items-end gap-3">
                <div
                    class="input w-full max-w-xs bg-transparent flex items-center gap-2 border-none rounded-6xl bg-zinc-300">
                    <i class="fa-solid fa-search border-r pr-4 py-2 border-black"></i>
                    <input type="text" placeholder="Telusuri Kelas" class=" w-full h-full bg-transparent" />
                </div>
            </div>
            <div class="w-full flex justify-end items-end gap-2">
                <div class="filter bg-gray-200 flex rounded-2xl transition-all justify-end items-end " id="filter"
                    data-toggle="closed">
                    <div class="filter-option hidden flex-col w-full p-2 px-2 gap-1 text-xs text-black" id="filter-option">
                        <div class="w-full flex gap-2 max-sm:gap-1 items-center max-sm:text-2xs">
                            <span class="font-semibold max-sm:hidden">Filter By:</span>
                            <a href="?filter=all"
                                class="px-2 py-0.5 rounded-box {{ request('filter') == 'all' ? 'bg-gray-300 text-white' : '' }} border-2 border-gray-300">All</a>
                            <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                                <option value="">Kelas</option>
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                            <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                                <option value="">Sekolah</option>
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                        </div>
                        <div class="w-full flex gap-2 max-sm:gap-1 max-sm:text-2xs">
                            <span class="font-semibold max-sm:hidden text-xs">Sort By:</span>
                            <a href="" class="truncate">Terakhir dibuka</a>
                            <a href="" class="truncate">Terakhir diubah</a>
                            <a href="" class="truncate">Sekolah</a>
                            <a href="" class="truncate">Kelas</a>
                        </div>
                    </div>
                    <div class="h-full w-10 bg-darkblue-500 rounded-2xl text-white py-3 text-xs btn">
                        <i class="fa-solid fa-sliders"></i>
                        <i class="fa-solid fa-arrow-up-a-z"></i>
                    </div>
                </div>
                <button onclick="addKelas.showModal()"
                    class="bg-darkblue-500 p-3 text-3xl text-white rounded-circle flex justify-center items-center"><i
                        class="fa-solid fa-plus"></i></button>
                <dialog id="addKelas" class="modal" data-theme="light">
                    <div class="modal-box flex flex-col gap-2">
                        <form action="" method="post" class="flex flex-col w-full gap-2 px-5">
                            <h3 class="font-semibold text-3xl w-full text-center">Tambahkan Kelas!</h3>
                            <input type="text" class="input input-bordered border-black" placeholder="Pilih Sekolah">
                            <input type="text" class="input input-bordered border-black" placeholder="Pilih Kelas">
                            <div class="modal-action w-full flex justify-between">
                                <button class="bg-gray-200 px-4 py-1 rounded-xl">Batal</button>
                                <button class="bg-gray-200 px-4 py-1 rounded-xl">Tambah</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
        </div>
        <div
            class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 gap-5 p-5 max-sm:p-0 h-full max-md:grid-cols-1 ">
            @foreach ($info_pengajar->kelas()->paginate(8) as $kelas)
                <div class="box w-full h-56 p-2">
                    <a href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $kelas->id]) }}"
                        class="w-full flex h-full bg-blue-200 rounded-box p-5 shadow-lg flex-col">
                        <div class="w-full flex justify-between h-2/6">
                            <div class="info">
                                <h1 class="text-black text-xs font-semibold">{{ $kelas->sekolah->nama }}</h1>
                                <h1 class="text-bluesea-500 font-bold text-2xl">{{ $kelas->nama_kelas }}</h1>
                            </div>
                            <img src="{{ asset('storage/sekolah/' . $kelas->sekolah->logo) }}" alt="">
                        </div>
                        <div class="w-full h-full grid grid-cols-2 gap-2 justify-between items-center text-black">
                            <img src="{{ asset('img/data_kelas.png') }}" alt=""
                                class="max-md:w-1/2 max-sm:w-3/4
                            ">
                            <div class="info flex flex-col text-xs gap-2">
                                <span><i class="fa-solid fa-chalkboard"></i>
                                    {{ $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas }}</span>
                                <span><i class="fa-solid fa-users"></i> {{ $kelas->siswa->count() }} Siswa</span>
                            </div>
                        </div>
                    </a>
                    <h1 class="text-black px-2 py-1 font-bold text-xs">Kelas Industri - {{ $kelas->sekolah->nama }} -
                        {{ $kelas->tingkat . ' ' . $kelas->jurusan . ' ' . $kelas->kelas }} </h1>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#filter .btn").click(function() {
            let filter = $("#filter");
            let filterOption = $("#filter-option");
            let isOpen = filter.data('toggle') == "open";

            filter.velocity({
                width: isOpen ? "auto" : "100%"
            });
            setTimeout(() => {
                filterOption.css("display", isOpen ? "none" : "flex");
            }, isOpen ? 250 : 500);

            filter.data('toggle', isOpen ? "closed" : "open");
        });
    </script>
@endsection
