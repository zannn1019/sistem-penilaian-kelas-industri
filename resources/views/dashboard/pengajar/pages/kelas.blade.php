@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full overflow-y-auto flex flex-col justify-between">
        <div
            class="w-full h-24 max-sm:h-auto max-sm:gap-5 max-md:grid-cols-1 max-md:h-auto grid grid-cols-2 max-sm:grid-cols-1 text-black p-5 max-sm:px-5 px-10 z-10 place-content-end">
            <div class="info flex items-end gap-3">
                <h1 class="text-4xl font-bold">Class Your’re In</h1>
                <span class="font-semibold">(12)</span>
            </div>
            <div class="w-full flex justify-end items-end">
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
            </div>
        </div>
        <div
            class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 gap-5 p-5 max-sm:p-0 h-full max-md:grid-cols-1 ">
            @foreach ($info_pengajar->kelas()->paginate(8) as $kelas)
                <div class="box w-full h-56 p-2">
                    <a href="{{ route('select-mapel', ['kelas' => $kelas->id]) }}"
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
                                class="w-32
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
        <div class="w-full p-2">
            {{ $info_pengajar->kelas()->paginate(8)->withQueryString()->links('components.pagination') }}
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
