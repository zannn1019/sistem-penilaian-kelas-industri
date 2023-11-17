@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full overflow-y-auto flex flex-col justify-between">
        <div
            class="w-full h-24 max-sm:h-auto max-sm:gap-5 max-md:grid-cols-1 max-md:h-auto grid grid-cols-2 max-sm:grid-cols-1 text-black p-5 max-sm:px-5 px-10 z-10 place-content-end">
            <div class="info flex items-end gap-3">
                <h1 class="text-4xl font-bold">Class Your’re In</h1>
                <span class="font-semibold">({{ $data_kelas->count() }})</span>
            </div>
            <div class="w-10/12 justify-self-end flex transition-all flex-row-reverse relative overflow-hidden  "
                id="filter" data-toggle="closed">
                <div class="h-full w-10 bg-darkblue-500 rounded-2xl text-white py-3 text-xs btn relative z-10">
                    <i class="fa-solid fa-sliders"></i>
                    <i class="fa-solid fa-arrow-up-a-z"></i>
                </div>
                <form method="GET"
                    class="filter-option transition-all flex-col p-2 px-2 gap-1 text-xs text-black bg-gray-200 h-full hidden absolute right-0 top-0 z-0 rounded-2xl"
                    id="filter-option">
                    <div class="w-full flex gap-2 max-sm:gap-1 items-center max-sm:text-2xs">
                        <span class="font-semibold max-sm:hidden">Filter By:</span>
                        <a href="?filter=all"
                            class="px-2 py-0.5 rounded-box {{ request('filter') == 'all' ? 'bg-gray-300 text-white font-semibold' : '' }} border-2 border-gray-300">All</a>
                        <select name="sekolah" id="sekolah"
                            class="text-black bg-gray-300  px-3 py-1 rounded-box filter-item" data-filter="sekolah">
                            <option value="">Sekolah</option>
                            @foreach ($info_pengajar->sekolah as $sekolah)
                                <option value="{{ $sekolah->id }}"
                                    {{ request()->get('sekolah') == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama }}
                                </option>
                            @endforeach
                        </select>
                        <select name="tingkat" id="tingkat"
                            class="text-black bg-gray-300  px-3 py-1 rounded-box filter-item" data-filter="tingkat">
                            <option value="">Tingkat</option>
                            <option value="10" {{ request()->get('tingkat') == 10 ? 'selected' : '' }}>10</option>
                            <option value="11" {{ request()->get('tingkat') == 11 ? 'selected' : '' }}>11</option>
                            <option value="12" {{ request()->get('tingkat') == 12 ? 'selected' : '' }}>12</option>
                            <option value="13" {{ request()->get('tingkat') == 13 ? 'selected' : '' }}>13</option>
                        </select>
                        <select name="semester" id="semester"
                            class="text-black bg-gray-300  px-3 py-1 rounded-box filter-item" data-filter="semester">
                            <option value="">Semester</option>
                            <option value="ganjil" {{ request()->get('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil
                            </option>
                            <option value="genap" {{ request()->get('semester') == 'genap' ? 'selected' : '' }}>Genap
                            </option>
                        </select>
                    </div>
                    <div class="w-full flex gap-2 max-sm:gap-1 max-sm:text-2xs">
                        <span class="font-semibold max-sm:hidden text-xs">Sort By:</span>
                        <a href="?sort=edited"
                            class="truncate {{ request()->get('sort') == 'edited' ? 'font-bold' : '' }}">Terakhir
                            diubah</a>
                        <a href="?sort=az" class="truncate {{ request()->get('sort') == 'az' ? 'font-bold' : '' }}">A-Z</a>
                    </div>
                </form>
            </div>
        </div>
        @if ($data_kelas->count())
            <div
                class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 gap-5 p-5 max-sm:p-0 h-full max-md:grid-cols-1 ">
                @foreach ($data_kelas->paginate(8) as $kelas)
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
                                    <span class="capitalize"><b>Semester {{ $kelas->semester }}</b></span>
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
                {{ $info_pengajar->paginate(8)->withQueryString()->links('components.pagination') }}
            </div>
        @else
            <div class="w-full h-full flex flex-col justify-center items-center">
                <img src="{{ asset('img/404_kelas.png') }}" alt="">
                <h1>Data kelas tidak ditemukan!</h1>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $("#filter").find('.btn').click(function() {
            let filter = $("#filter");
            let filterOption = $("#filter-option");
            let isOpen = filter.data('toggle') == "open";
            if (isOpen) {
                setTimeout(() => {
                    filterOption.children().addClass('hidden');
                    filterOption.addClass('hidden');
                }, 50);
                filterOption.addClass('w-0');
                filterOption.removeClass('w-full');
            } else {
                setTimeout(() => {
                    filterOption.children().removeClass('hidden');
                    filterOption.removeClass('hidden');
                }, 50);
                filterOption.addClass('w-full');
                filterOption.removeClass('w-0');
            }
            filter.data('toggle', isOpen ? "closed" : "open");
        });
        $('.filter-item').on('change', function() {
            let selectedValue = $(this).val();
            let filter = $(this).data('filter');
            let queryParams = new URLSearchParams(window.location.search);
            queryParams.delete('filter');
            queryParams.set(filter, selectedValue);
            let newUrl = window.location.pathname + "?" + queryParams.toString();
            window.location.href = newUrl;
        });
    </script>
@endsection
