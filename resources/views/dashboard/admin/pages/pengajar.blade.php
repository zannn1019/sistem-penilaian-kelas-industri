@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 text-black flex flex-col gap-5 overflow-y-auto overflow-x-hidden">
        <div class="w-full flex justify-between">
            <div class="flex items-end gap-1 font-semibold">
                <h1 class="text-3xl">Daftar Pengajar</h1>
                <span>({{ $data_pengajar->count() }})</span>
            </div>
            <div>
                <a href="{{ route('pengajar.create') }}" class="btn text-white rounded-circle text-xl shadow-custom">
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="w-full h-full grid grid-cols-4 max-sm:grid-cols-1 max-md:grid-cols-2 gap-3">
            @foreach ($data_pengajar->paginate(8) as $pengajar)
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
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-44 ">
                                <li><a href="https://wa.me/{{ $pengajar->no_telp }}">Nomor Telepon</a></li>
                                <li><a href="mailto:{{ $pengajar->email }}">Email</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="p-5">
            {{ $data_pengajar->paginate(8)->links('components.pagination') }}
        </div>
    </div>
@endsection
