@extends('dashboard.layouts.main')
@php
    $warna = collect(['tosca', 'bluesea', 'bluesky']);
@endphp
@section('content')
    <div class="w-full h-full p-5 text-black flex flex-col">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.show', ['sekolah' => $info_sekolah->id]) }}"
                class="fa-solid fa-chevron-left max-md:text-lg text-black max-sm:p-5"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li><a href="{{ route('sekolah.show', ['sekolah' => $info_sekolah->id]) }}">{{ $info_sekolah->nama }}</a>
                    </li>
                    <li>Kelas Industri</li>
                </ul>
            </div>
        </header>
        <div class="w-full flex h-full flex-col gap-1">
            <div class="info-sekolah flex max-md:flex-col max-md:items-center gap-5 relative w-full max-md:pb-10">
                <img src="{{ asset('storage/sekolah/' . $info_sekolah->logo) }}"
                    class="w-44 h-44 z-[5] aspect-square bg-white rounded-circle border-4 border-darkblue-500"
                    alt="">
                <div class="info w-full text-center">
                    <h1 class="text-5xl font-semibold py-2 border-b border-black w-full text-start">
                        {{ $info_sekolah->nama }}</h1>
                </div>
                <div
                    class="w-11/12 h-1/2 rounded-box text-white flex py-2 justify-end max-md:justify-start pl-20 max-md:px-0 items-center absolute bottom-0 right-0 bg-darkblue-500 ">
                    <div class="filter w-full h-full flex px-5 items-center gap-2 justify-between">
                        <div class="tingkat h-full flex flex-col gap-1 justify-center pr-3">
                            <span class="text-xs leading-3">Tingkat Kelas</span>
                            <div class="w-full h-full flex gap-1">
                                @for ($tingkat = 10; $tingkat <= 13; $tingkat++)
                                    <a href="?tingkat={{ request('tingkat') == $tingkat ? 'all' : $tingkat }}&jurusan={{ request('jurusan') ?? 'all' }}&ajaran={{ request('ajaran') ?? 'all' }}&semester={{ request('semester') ?? 'all' }}"
                                        class="py-2.5 px-4 border-darkblue-100 border-2 rounded-lg font-bold flex justify-center items-center {{ $tingkat == request('tingkat') ? 'bg-white border-white text-black' : '' }}">
                                        <h1 class="text-xl">{{ $tingkat }}</h1>
                                    </a>
                                @endfor
                            </div>
                        </div>
                        <div
                            class="jurusan border-l w-auto border-darkblue-200 px-5 h-full flex flex-col gap-1 justify-start">
                            <span class="text-xs leading-3">Jurusan</span>
                            <div class="relative inline-flex">
                                <svg class="w-2 h-2 absolute top-0 right-0 m-3 pointer-events-none"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                                    <path
                                        d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                                        fill="white" fill-rule="nonzero" />
                                </svg>
                                <select
                                    class="border-2 max-w-[12rem] border-darkblue-100 rounded-lg h-8 text-xs pl-2 pr-16 bg-transparent text-white hover:border-gray-400 focus:outline-none appearance-none"
                                    data-theme="dark" id="filter-jurusan">
                                    <option class="text-black" value="all">Semua Jurusan</option>
                                    @foreach ($daftar_jurusan as $jurusan)
                                        <option class="text-black" value="{{ $jurusan['slug'] }}"
                                            {{ request('jurusan') == $jurusan['slug'] ? 'selected' : '' }}>
                                            {{ $jurusan['nama_jurusan'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="jurusan border-l border-darkblue-200 px-5 h-full flex flex-col gap-1 justify-start">
                            <span class="text-xs leading-3">Tahun Ajaran</span>
                            <div class="relative inline-flex">
                                <svg class="w-2 h-2 absolute top-0 right-0 m-3 pointer-events-none"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                                    <path
                                        d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                                        fill="white" fill-rule="nonzero" />
                                </svg>
                                <select
                                    class="border-2 border-darkblue-100 rounded-lg h-8 text-xs pl-2 pr-16 bg-transparent text-white hover:border-gray-400 focus:outline-none appearance-none"
                                    data-theme="dark" id="filter-tahun">
                                    <option class="text-black" value="all">Semua Ajaran</option>
                                    @foreach ($tahun_ajaran as $tahun)
                                        <option class="text-black" value="{{ $tahun }}"
                                            {{ request('ajaran') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="jurusan border-l border-darkblue-200 px-5 h-full flex flex-col gap-1 justify-start">
                            <span class="text-xs leading-3">Semester</span>
                            <a href="?tingkat={{ request('tingkat') ?? 'all' }}&jurusan={{ request('jurusan') }}&ajaran={{ request('ajaran') ?? 'all' }}&semester={{ request('semester') == 'ganjil' ? 'all' : 'ganjil' }}"
                                class="px-10 py-1 border-darkblue-100 text-2xs rounded-md border-2 {{ request('semester') == 'ganjil' ? 'bg-white text-black border-white' : '' }}">GANJIL</a>
                            <a href="?tingkat={{ request('tingkat') ?? 'all' }}&jurusan={{ request('jurusan') }}&ajaran={{ request('ajaran') ?? 'all' }}&semester={{ request('semester') == 'genap' ? 'all' : 'genap' }}"
                                class="px-10 py-1 border-darkblue-100 text-2xs rounded-md border-2 {{ request('semester') == 'genap' ? 'bg-white text-black border-white' : '' }}">GENAP</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full h-full flex">
                @if ($daftar_kelas->count() > 0)
                    <div class="w-full h-96 overflow-auto scroll-arrow" dir="rtl">
                        <div class="grid grid-cols-3 max-md:grid-cols-1 p-2 max-sm:p-0 gap-2" dir="ltr">
                            @foreach ($daftar_kelas->paginate(6)->withQueryString() as $kelas)
                                @php
                                    $data_warna = $warna->random();
                                @endphp
                                <div class="box w-full h-56 p-2" dir="ltr">
                                    <a href="{{ route('kelas.show', ['kela' => $kelas->id]) }}"
                                        class="w-full flex h-full bg-{{ $data_warna }}-100 rounded-box p-5 shadow-lg flex-col items-center">
                                        <div class="w-full flex justify-between h-2/6">
                                            <div class="info">
                                                <h1 class="text-black text-xs font-semibold">
                                                    {{ $kelas->sekolah->nama }}
                                                </h1>
                                                <h1 class="text-{{ $data_warna }}-500 font-bold text-2xl max-sm:text-lg">
                                                    {{ $kelas->nama_kelas }}
                                                </h1>
                                            </div>
                                            <img src="{{ asset('storage/sekolah/' . $kelas->sekolah->logo) }}"
                                                alt="" class="w-12 h-12 aspect-square rounded-circle">
                                        </div>
                                        <div class="flex w-full text-black text-sm items-center justify-evenly gap-5">
                                            <img src="{{ asset('img/data_kelas.png') }}" alt=""
                                                class="w-36 max-sm:w-24">
                                            <div class="status flex flex-col gap-1 text-xs">
                                                <h1 class="font-semibold">Semester {{ $kelas->semester }}</h1>
                                                <h1 class="font-semibold">
                                                    {{ $kelas->tingkat }}-{{ $kelas->jurusan }}-{{ $kelas->kelas }}
                                                </h1>
                                                <span class="font-semibold">{{ $kelas->siswa->count() }} Siswa</span>
                                            </div>
                                        </div>
                                    </a>
                                    <h1 class="text-black px-2 py-1 font-bold text-xs">
                                        {{ $kelas->tingkat . ' ' . $kelas->jurusan . ' ' . $kelas->kelas }}-
                                        Semester {{ $kelas->semester }} </h1>
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full py-5" dir="ltr">
                            {{ $daftar_kelas->paginate(6)->withQueryString()->links('components.pagination') }}
                        </div>
                    </div>
                @else
                    <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                        <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                        <h1>Data kelas tidak ditemukan!</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#filter-jurusan").change(function() {
            let selectedJurusan = $(this).val()
            window.location.href =
                `?tingkat={{ request('tingkat') ?? 'all' }}&jurusan=${selectedJurusan}&ajaran={{ request('ajaran') ?? 'all' }}&semester={{ request('semester') ?? 'all' }}`;
        })
        $("#filter-tahun").change(function() {
            let selectedTahun = $(this).val()
            window.location.href =
                `?tingkat={{ request('tingkat') ?? 'all' }}&jurusan={{ request('jurusan') }}&ajaran=${selectedTahun}&semester={{ request('semester') ?? 'all' }}`;
        })
    </script>
@endsection
