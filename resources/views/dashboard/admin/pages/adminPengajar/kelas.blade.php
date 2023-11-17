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
                    <h1 class="text-3xl font-semibold max-sm:text-sm">Kelas Pengajar <span
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
                                        {{ request()->get('sekolah') == $sekolah->id ? 'selected' : '' }}>
                                        {{ $sekolah->nama }}
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
                                <option value="ganjil" {{ request()->get('semester') == 'ganjil' ? 'selected' : '' }}>
                                    Ganjil
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
                            <a href="?sort=az"
                                class="truncate {{ request()->get('sort') == 'az' ? 'font-bold' : '' }}">A-Z</a>
                        </div>
                    </form>
                </div>
                <button onclick="addKelas.showModal()"
                    class="bg-darkblue-500 p-3 text-3xl text-white rounded-circle flex justify-center items-center"><i
                        class="fa-solid fa-plus"></i></button>
                <dialog id="addKelas" class="modal" data-theme="light">
                    <div class="modal-box flex flex-col gap-2">
                        <form action="{{ route('pengajar.store', ['tipe' => 'sekolah']) }}" method="post"
                            class="flex flex-col w-full gap-2 px-5">
                            @csrf
                            <h3 class="font-semibold text-3xl w-full text-center">Tambahkan Kelas!</h3>
                            <input type="text" class="input input-bordered border-black" placeholder="Pilih Sekolah"
                                id="search-sekolah" value="">
                            <input type="hidden" value="" id="id_sekolah" name="id_sekolah">
                            <input type="hidden" value="{{ $info_pengajar->id }}" name="id_user">
                            <input type="hidden" value="" id="id_kelas" name="id_kelas">
                            <input type="text" class="input input-bordered border-black" disabled
                                placeholder="Pilih Kelas" id="search-kelas" data-id-sekolah="">
                            <div class="modal-action w-full flex justify-between">
                                <button class="bg-gray-200 px-4 py-1 rounded-xl" id="cancel-btn">Batal</button>
                                <button class="bg-gray-200 px-4 py-1 rounded-xl">Tambah</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
        </div>
        @if ($data_kelas->count())
            <div
                class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 gap-5 p-5 max-sm:p-0 h-full max-md:grid-cols-1 ">
                @foreach ($data_kelas->paginate(8) as $kelas)
                    <div class="box w-full h-56 p-2">
                        <a href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $kelas->id]) }}"
                            class="w-full flex h-full bg-blue-200 rounded-box p-5 shadow-lg flex-col overflow-hidden">
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
                                    <span class="text-black font-semibold">Semester {{ $kelas->semester }}</span>
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
            {{ $data_kelas->paginate(8)->withQueryString()->links('components.pagination') }}
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
        $(document).ready(function() {
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

            $("#cancel-btn").click(function(e) {
                e.preventDefault()
                addKelas.close()
            })

            $("#search-sekolah").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('sekolah.index') }}",
                        type: 'GET',
                        dataType: "json",
                        data: {
                            query: request.term
                        },
                        success: function(data) {
                            let filteredData = data.map(function(item) {
                                return {
                                    label: item.nama,
                                    value: item.id
                                };
                            });
                            response(filteredData);
                        }
                    });
                },
                select: function(event, ui) {
                    let selectedId = ui.item.value;
                    let selectedNama = ui.item.label;
                    $('#search-sekolah').val(selectedNama);
                    $("#id_sekolah").val(selectedId)
                    $('#search-kelas').data('id-sekolah', selectedId);
                    $('#search-kelas').removeAttr('disabled');
                    return false;
                }
            });

            $("#search-kelas").autocomplete({
                source: function(request, response) {
                    let idSekolah = $('#search-kelas').data(
                        'id-sekolah');
                    $.ajax({
                        url: "{{ route('kelas.index') }}",
                        type: 'GET',
                        dataType: "json",
                        data: {
                            query: request.term,
                            id_sekolah: idSekolah
                        },
                        success: function(data) {
                            let filteredData = data.map(function(item) {
                                return {
                                    label: item.nama_kelas + "-" + item.tingkat +
                                        " " + item
                                        .jurusan + " " + item.kelas,
                                    value: item.id
                                };
                            });
                            response(filteredData);
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    let selectedId = ui.item.value;
                    let selectedNama = ui.item.label;
                    $('#search-kelas').val(selectedNama);
                    $("#id_kelas").val(selectedId)
                    return false;
                }
            });
        });
    </script>
@endsection
