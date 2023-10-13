@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 text-black flex flex-col">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black max-sm:p-5"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li><a href="{{ route('sekolah.show', ['sekolah' => $info_sekolah->id]) }}">{{ $info_sekolah->nama }}</a>
                    </li>
                    <li>Pengajar</li>
                </ul>
            </div>
        </header>
        <div class="info-sekolah flex max-md:flex-col max-md:items-center gap-5 relative w-full max-md:pb-10">
            <img src="{{ asset('storage/sekolah/' . $info_sekolah->logo) }}"
                class="w-44 h-44 z-[5] aspect-square bg-white rounded-circle border-4 border-darkblue-500" alt="">
            <div class="info w-full text-center">
                <h1 class="text-5xl font-semibold py-2 border-b border-black w-full text-start">
                    {{ $info_sekolah->nama }}</h1>
            </div>
            <div
                class="w-11/12 h-1/2 rounded-box text-white flex py-2 justify-end max-md:justify-start pl-20 max-md:px-0 absolute bottom-0 right-0 bg-darkblue-500 ">
                <div class="filter w-full h-full flex px-5 items-center gap-2">
                    <div class="tingkat h-full flex flex-col gap-1 justify-center">
                        <span class="text-xs leading-3 font-semibold">Status</span>
                        <div class="max-w-[15rem] h-full flex gap-1 flex-wrap justify-start items-start">
                            <a href="?status=aktif&sort={{ request('sort') ?? 'asc' }}"
                                class="{{ request('status') == 'aktif' ? 'bg-white border-white text-black' : '' }} text-xs px-5 py-1 border border-white rounded-md">Aktif</a>
                            <a href="?status=online&sort={{ request('sort') ?? 'asc' }}"
                                class="{{ request('status') == 'online' ? 'bg-white border-white text-black' : '' }} text-xs px-5 py-1 border border-white rounded-md">Sedang
                                Mengakses</a>
                            <a href="?status=nonaktif&sort={{ request('sort') ?? 'asc' }}"
                                class="{{ request('status') == 'nonaktif' ? 'bg-white border-white text-black' : '' }} text-xs px-5 py-1 border border-white rounded-md">Nonaktif</a>
                            <a href="{{ route('sekolah.maximize', ['sekolah' => $info_sekolah->id, 'data' => 'pengajar', 'sort' => request('sort')]) }}"
                                class="{{ request('status') == '' ? 'bg-white border-white text-black' : '' }} text-xs px-5 py-1 border border-white rounded-md">Semua</a>
                        </div>
                    </div>
                    <div class="tingkat border-l border-gray-50 pl-5 h-full flex flex-col gap-1 justify-center">
                        <span class="text-xs leading-3 font-semibold">Urutan</span>
                        <div class="h-full flex gap-1 flex-wrap justify-start items-start">
                            <a href="?status={{ request('status') ?? '' }}&sort={{ request('sort') == 'asc' || request('sort') == '' ? 'desc' : 'asc' }}"
                                class=" p-1 px-3 min-w-[6rem] border-darkblue-100 border-2 rounded-lg font-bold flex flex-col justify-center items-center {{ request('sort') == 'asc' || request('sort') == '' ? 'bg-white text-black border-white' : '' }}">
                                <i class="fa-solid fa-arrow-down-a-z text-2xl"></i>
                                <h1 class="text-2xs font-normal">A-Z</h1>
                            </a>
                            <a href="?status={{ request('status') ?? '' }}&sort={{ request('sort') == 'asc' || request('sort') == '' ? 'desc' : 'asc' }}&sort=edited"
                                class=" p-1 px-3 min-w-[6rem] border-darkblue-100 border-2 rounded-lg font-bold flex flex-col justify-center items-center {{ request('sort') == 'edited' ? 'bg-white text-black border-white' : '' }}">
                                <i class="fa-solid fa-pen text-2xl"></i>
                                <h1 class="text-2xs font-normal">Terakhir Diubah</h1>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if ($daftar_pengajar->count() > 0)
            <div class="w-full h-96 overflow-auto scroll-arrow" dir="rtl">
                <div class="grid grid-cols-4 max-md:grid-cols-1 p-2 max-sm:p-0 gap-2" dir="ltr">
                    @foreach ($daftar_pengajar->paginate(8) as $pengajar)
                        @php
                            if (Cache::has('is_online' . $pengajar->id) && $pengajar->status == 'aktif') {
                                $is_online = true;
                                $bg = 'bg-bluesea-100';
                                $btn = 'bg-bluesea-500';
                            } else {
                                $is_online = false;
                                if ($pengajar->status == 'aktif') {
                                    $bg = 'bg-tosca-100';
                                    $btn = 'bg-tosca-500';
                                } else {
                                    $bg = 'bg-darkblue-100';
                                    $btn = 'bg-darkblue-500';
                                }
                            }
                        @endphp
                        <div
                            class="w-full h-fit {{ $bg }} flex p-2 rounded-box shadow-xl flex-col items-center gap-0.5 relative py-5">
                            <div class="avatar">
                                <div class="w-20 rounded-full">
                                    <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}" alt="">
                                </div>
                            </div>
                            <h1 class="font-semibold truncate w-full px-2 text-center">{{ $pengajar->nama }}</h1>
                            <span class="capitalize text-xs">
                                {!! $is_online == true
                                    ? 'Mengakses : ' . '<b>' . Cache::get('at_page' . $pengajar->id) . '</b>'
                                    : $pengajar->status !!}</span>
                            <div class="w-full flex flex-wrap text-center justify-evenly items-center gap-5">
                                <div>
                                    <h1 class="text-xs">Sekolah</h1>
                                    <span class="font-semibold">{{ $pengajar->jumlah_sekolah }}</span>
                                </div>
                                <div>
                                    <h1 class="text-xs">Kelas</h1>
                                    <span class="font-semibold">{{ $pengajar->kelas()->count() }}</span>
                                </div>
                                <div>
                                    <h1 class="text-xs">Mapel</h1>
                                    <span class="font-semibold">{{ $pengajar->mapel()->count() }}</span>
                                </div>
                            </div>
                            <div class="w-full flex justify-evenly p-2">
                                <a href="{{ route('pengajar.show', ['pengajar' => $pengajar->id]) }}"
                                    class="{{ $btn }} px-3 py-1 rounded-box text-white text-xs"><i
                                        class="fa-solid fa-user"></i> Profile</a>
                                <div class="dropdown bg-transparent" data-theme="light">
                                    <div tabindex="0"
                                        class="{{ $btn }} cursor-pointer px-3 py-1 rounded-box text-white text-xs">
                                        <i class="fa-solid fa-envelope"></i> Contact
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-44 ">
                                        <li><a href="https://wa.me/{{ $pengajar->no_telp }}">Nomor Telepon</a></li>
                                        <li><a href="mailto:{{ $pengajar->email }}">Email</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full py-5" dir="ltr">
                    {{ $daftar_pengajar->paginate(8)->withQueryString()->links('components.pagination') }}
                </div>
            </div>
        @else
            <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                <h1>Tidak ada data pengajar!</h1>
            </div>
        @endif
    </div>
@endsection
