@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 flex flex-col gap-2 ">
        <header
            class="w-full h-1/4 max-sm:h-auto flex justify-between  border-b border-black gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3">
                <a href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                            <li><a href="{{ route('pengajar.show', ['pengajar' => $info_pengajar->id]) }}">Profil
                                    Pengajar</a>
                            </li>
                            <li><a href="{{ route('admin-kelas-pengajar', ['pengajar' => $info_pengajar->id]) }}">Kelas
                                    Pengajar</a></li>
                            <li><a
                                    href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}">Mata
                                    Pelajaran</a></li>
                            <li>{{ $info_mapel->mapel->nama_mapel }}</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"><span class="max-sm:hidden">Kelas Industri -</span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-lg    ">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                    <h1 class="text-2xl font-semibold max-sm:text-sm">
                        {{ $info_kelas->tahun_ajar . ' - Semester ' . $info_kelas->semester }}</h1>
                </div>
            </div>
        </header>
        <div class="flex h-auto max-sm:h-full relative">
            <div class="self-end sticky bottom-0 py-5 flex flex-col gap-2 max-sm:fixed max-sm:right-5 max-sm:bottom-2">
                <div class="relative w-12 rounded-circle aspect-square flex items-end">
                    <details class="dropdown dropdown-top">
                        <summary
                            class="dropdown-btn absolute bottom-0 bg-darkblue-500 z-[1] p-3 shadow-box btn rounded-circle text-white text-2xl flex justify-center items-center aspect-square"
                            id="list-btn"><i class="fa-solid fa-bars-staggered"></i></summary>
                        <div
                            class="p-3 shadow-box rounded-3xl dropdown-content bg-white absolute bottom-0 left-0 max-sm:-left-52 w-64  flex flex-col text-black text-center justify-center items-center gap-2">
                            <a href="{{ route('admin-show-siswa-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}"
                                class="w-full border-b p-2 border-black hover:font-semibold">Daftar siswa</a>
                            <a href="{{ route('admin-show-nilai-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id, 'mapel' => $info_mapel->id]) }}"
                                class="w-full p-2 hover:font-semibold border-b border-black">Daftar nilai</a>
                            <a href="{{ route('admin-show-pengajar-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}"
                                class="w-full p-2 hover:font-semibold">Daftar pengajar</a>
                        </div>
                    </details>
                </div>
            </div>
            <div class="px-5 py-2 max-sm:px-0 w-full h-full text-black flex flex-col gap-2">
                {{--
                    ?? HAPUS JIKA SUDAH
                    @if ($daftar_tugas['ujian']->count())
                    <h1 class="font-semibold">Assesmen</h1>
                    <div class="w-full grid grid-cols-3 max-sm:grid-cols-1 max-md:grid-cols-2">
                        @foreach ($daftar_tugas['ujian'] as $ujian)
                            <div class="box w-full h-56 p-2">
                                <a href="{{ route('admin-show-nilai-pertugas-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id, 'tugas' => $ujian->id]) }}"
                                    class="w-full flex h-full bg-tosca-100 rounded-box p-5 shadow-lg flex-col">
                                    <div class="w-full flex justify-between h-2/6">
                                        <div class="flex justify-between items-center w-full">
                                            <h1 class="text-black text-2xl font-bold w-52">{{ $ujian->nama }}</h1>
                                            <span
                                                class="bg-black flex justify-center items-center p-2 px-2.5 rounded-circle"><i
                                                    class="fa-solid fa-arrow-right text-white"></i></span>
                                        </div>
                                    </div>
                                    <div
                                        class="w-full h-full grid grid-cols-2 gap-4 justify-between items-center text-black">
                                        <img src="{{ asset('img/_' . $ujian->tipe . '.png') }}" alt=""
                                            class="">
                                        <div class=" w-full h-full flex justify-center items-center">
                                            <div
                                                class="flex justify-center flex-col items-center overflow-hidden w-28 aspect-square bg-tosca-500 rounded-circle">
                                                <div class="w-full flex items-end justify-center">
                                                    <span
                                                        class="font-semibold text-3xl">{{ $ujian->nilai->count() }}</span>
                                                    <span class="text-sm">/{{ $ujian->kelas->siswa->count() }}</span>
                                                </div>
                                                <span>Ternilai</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif --}}
                @if ($daftar_tugas['tugas']->count())
                    <h1 class="font-semibold">Tugas</h1>
                    <div class="w-full grid grid-cols-3  max-sm:grid-cols-1 max-md:grid-cols-2">
                        @foreach ($daftar_tugas['tugas'] as $tugas)
                            <div class="box w-full h-56 p-2">
                                <a href="{{ route('admin-show-nilai-pertugas-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id, 'tugas' => $tugas->id]) }}"
                                    class="w-full flex h-full bg-bluesea-100 rounded-box p-5 shadow-lg flex-col">
                                    <div class="w-full flex justify-between h-2/6">
                                        <div class="flex justify-between items-center w-full">
                                            <h1 class="text-black text-2xl font-bold w-52">{{ $tugas->nama }}</h1>
                                            <span
                                                class="bg-black flex justify-center items-center p-2 px-2.5 rounded-circle"><i
                                                    class="fa-solid fa-arrow-right text-white"></i></span>
                                        </div>
                                    </div>
                                    <div
                                        class="w-full h-full grid grid-cols-2 gap-4 justify-between items-center text-black">
                                        <img src="{{ asset('img/_' . $tugas->tipe . '.png') }}" alt=""
                                            class="min-h-12 max-h-40">
                                        <div class=" w-full h-full flex justify-center items-center">
                                            <div
                                                class="flex justify-center flex-col items-center overflow-hidden w-28 aspect-square bg-bluesea-500 rounded-circle">
                                                <div class="w-full flex items-end justify-center">
                                                    <span
                                                        class="font-semibold text-3xl">{{ $tugas->nilai->count() }}</span>
                                                    <span class="text-sm">/{{ $tugas->kelas->siswa->count() }}</span>
                                                </div>
                                                <span>Ternilai</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (!$daftar_tugas['tugas']->count() && !$daftar_tugas['ujian']->count())
                    <div class="w-full h-full flex flex-col text-black justify-center items-center">
                        <img src="{{ asset('img/404_kelas.png') }}" alt="">
                        <h1>Tidak ada data tugas!</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
