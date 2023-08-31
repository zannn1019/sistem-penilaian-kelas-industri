@extends('dashboard.layouts.main')
@php
    $warna = collect(['tosca', 'bluesea', 'blue']);
@endphp
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-10 overflow-y-auto relative">
        <div class="header flex justify-between">
            <h1 class="text-4xl max-sm:text-2xl font-semibold">Sekolah Yang Terdaftar <span
                    class="text-lg">({{ $data_sekolah->count() }})</span></h1>
            <a href="{{ route('sekolah.create') }}" class="btn text-white rounded-circle text-xl shadow-custom">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        <div class="w-full h-full grid grid-cols-4 max-sm:grid-cols-1 max-md:grid-cols-2 gap-2">
            @foreach ($data_sekolah->paginate(8) as $sekolah)
                @php
                    $data_warna = $warna->random();
                @endphp
                <div class="box w-full bg-white border h-60 rounded-box shadow-xl flex flex-col gap-2 p-2 relative">
                    <div class="dropdown dropdown-end absolute top-0 right-0 px-5 py-3">
                        <label tabindex="0" class="cursor-pointer">
                            <i class="fa-solid fa-ellipsis"></i>
                        </label>
                        <div tabindex="0"
                            class="dropdown-content z-[1] menu shadow bg-white border rounded-box w-20 flex flex-col">
                            <a href="{{ route('sekolah.edit', ['sekolah' => $sekolah->id]) }}"
                                class="p-2 hover:font-bold">Edit</a>
                            <form action="{{ route('sekolah.destroy', $sekolah->id) }}" method="POST"
                                class="p-2 hover:font-bold">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                    <img src="{{ asset('img/sekolah_' . $data_warna . '.png') }}" alt=""
                        class="h-1/2 object-contain aspect-square ">
                    <a href="{{ route('sekolah.show', $sekolah->id) }}"
                        class="info w-full h-full items-center justify-center flex flex-col bg-{{ $data_warna }}-200 rounded-box shadow-md p-1 px-5">
                        <h1 class="text-center font-semibold nama-sekolah w-full text-xl truncate">{{ $sekolah->nama }}</h1>
                        <div class="w-full flex gap-2 justify-between items-center">
                            <div class="sub-info text-xs flex flex-col gap-1">
                                <span><i class="fa-solid fa-chalkboard-user"></i>
                                    {{ $sekolah->pengajar->count() }}
                                    Pengajar</span>
                                <span><i class="fa-solid fa-graduation-cap"></i>
                                    {{ $sekolah->kelas->groupBy('jurusan')->count() }}
                                    Jurusan</span>
                                <span><i class="fa-solid fa-users-rectangle"></i>
                                    {{ $sekolah->kelas->count() }}
                                    Kelas</span>
                            </div>
                            <div class="w-14 h-14 aspect-square">
                                <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" alt="" class="h-full">
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        {{ $data_sekolah->paginate(8)->links('components.pagination') }}
    </div>
@endsection
