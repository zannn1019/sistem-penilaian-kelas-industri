@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto">
        <div class="w-full h-24 grid grid-cols-2 max-sm:grid-cols-1 grid-rows-1">
            <div class="w-full border-2 p-2 h-full rounded-3xl shadow-xl flex flex-col justify-center items-center">
                <h1 class="font-semibold">Instansi Terkait</h1>
                <div class="w-full h-full flex justify-center items-center">
                    @foreach ($data_sekolah as $sekolah)
                        <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" alt=""
                            class="w-10 aspect-square object-contain -mr-3 rounded-circle">
                    @endforeach
                    <a href="{{ route('sekolah.index') }}"
                        class="w-10 bg-gray-200 rounded-circle aspect-square shadow-box border-2 border-darkblue-100 flex justify-center items-center"><i
                            class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="w-full h-full flex gap-5 max-md:flex-col">
            <div
                class="w-8/12 max-md:w-full flex flex-col h-full shadow-2xl bg-gradient-to-r from-bluesky-500 from-20% to-darkblue-500 rounded-2xl">
                <div class="w-full h-3/6 flex items-center justify-center">
                    <div class="w-auto text-center">
                        <h1 class="bg-tosca-500 px-5 py-1 rounded-2xl max-sm:text-sm">{{ date('d M Y') }}</h1>
                        <h1 class="text-8xl text-white">{{ $daftar_pengajar->count() }}</h1>
                        <span class="text-white text-xl max-sm:text-sm">Pengajar</span>
                    </div>
                    <img src="{{ asset('img/meet.png') }}" alt=""
                        class="h-full max-md:h-36 object-cover max-sm:h-24">
                </div>
                <div
                    class="w-full h-3/6 rounded-2xl bg-gray-100 shadow-inner grid grid-cols-2 max-sm:grid-cols-1 overflow-hidden">
                    <div class="h-auto flex flex-col gap-1 overflow-y-auto bg-white p-2 shadow-box">
                        <div class="w-full rounded-box bg-gray-300 flex justify-between items-center px-5">
                            <input type="text" class="bg-transparent focus:outline-none p-2 w-full">
                            <i class="fa-solid fa-magnifying-glass border-l-2 border-black pl-2"></i>
                        </div>
                        @foreach ($daftar_pengajar as $pengajar)
                            <div data-id="{{ $pengajar->id }}"
                                class="w-full p-1 flex gap-2 cursor-pointer hover:bg-gray-200 text-sm {{ $loop->iteration == $loop->last ? '' : 'border-b' }}">
                                <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}" alt=""
                                    class="w-10 rounded-circle aspect-square">
                                <div class="info w-full text-xs flex flex-col gap-1">
                                    <h1>{{ $pengajar->nama }}</h1>
                                    <div class="w-full flex justify-between">
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-school-flag bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            4 sekolah</span>
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-school-flag bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            4 sekolah</span>
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-school-flag bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            4 sekolah</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="w-full h-full p-2 flex flex-col justify-center items-center gap-3 max-sm:hidden text-center">
                        <h1>Lihat profil lengkap pengajar</h1>
                        <a href="{{ route('pengajar.index') }}"
                            class="btn bg-bluesky-500 border-none hover:bg-bluesky-600 outline-none text-white rounded-6xl shadow-custom px-5 text-sm">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-4/12 max-md:w-full grid grid-cols-2 grid-rows-2 h-full gap-2">
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Instansi Sekolah
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute">
                        <h1>{{ $data_sekolah->count() }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Mata Pelajaran
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute">
                        <h1>{{ $mapel }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Kelas Industri
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute">
                        <h1>{{ $kelas }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Siswa/Siswi
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semib    old border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute">
                        <h1>{{ $siswa }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
