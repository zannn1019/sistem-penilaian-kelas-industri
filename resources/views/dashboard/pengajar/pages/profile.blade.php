@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full max-sm:h-auto text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full h-14 flex gap-3 items-center text-2xl justify-between">
            <div class="flex justify-center items-center gap-2">
                <a href="{{ route('dashboard-pengajar') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="text-sm max-sm:hidden breadcrumbs">
                    <ul>
                        <li>Profil Pengajar</li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="w-full h-full flex max-md:flex-col max-md:px-1 px-10 max-md:gap-5" data-theme="light">
            <div class="profile-info flex flex-col max-md:w-full gap-2 p-5 w-60 bg-darkblue-500 rounded-6xl shadow-box">
                <div class="profile-picture flex justify-center items-center relative">
                    <div id="edit-gambar"
                        class="input-logo bg-gray-100 w-52 max-md:w-53 aspect-square border border-black rounded-circle flex justify-center items-center relative">
                        <div
                            class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative">
                            <input type="file" name="foto" id="input-photo"
                                class="hidden z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0"
                                accept="image/*">
                            <img src="{{ asset('storage/pengajar/' . $data_pengajar->foto) }}" alt=""
                                class="absolute top-0 left-0 w-full h-full pointer-events-none z-20" id="photo-preview">
                        </div>
                    </div>
                </div>
                <hr class="border-white">
                <div class="w-full flex flex-col text-white ">
                    <div class="p-1 text-xs">
                        <label for="username">Status</label>
                        <select id="" name="status"
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white text-white bg-darkblue-500"
                            disabled>
                            <option value="aktif" {{ $data_pengajar->status == 'aktif' ? 'selected' : '' }}>aktif</option>
                            <option value="nonaktif" {{ $data_pengajar->status == 'nonaktif' ? 'selected' : '' }}>nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="p-1 text-xs">
                        <label for="username">Username</label>
                        <input type="text" name="username" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->username }}">
                    </div>
                    <div class="p-1 text-xs">
                        <label for="email">Email</label>
                        <input type="text" name="email" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->email }}">
                    </div>
                    <div class="p-1 text-xs">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->no_telp }}">
                    </div>
                </div>
            </div>
            <div class="w-full h-full px-5 flex flex-col gap-2">
                <h1 class="font-semibold text-xl">PROFIL PENGAJAR</h1>
                <h1
                    class="font-semibold text-4xl max-sm:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-tosca-500 via-blue-500 to-bluesea-500">
                    {{ $data_pengajar->nama }}
                </h1>
                <div class="w-full p-5 flex flex-col shadow-custom rounded-6xl gap-5 h-full">
                    <div class="w-full grid grid-cols-2 max-sm:grid-cols-1 border-collapse gap-0.5">
                        <span><b>Nama</b></span>
                        <input type="text" name="nama" id=""
                            class="profile-input border-l border-black profile-input-2 w-full flex items-center px-2 bg-transparent"
                            disabled value="{{ $data_pengajar->nama }}">
                        <span><b>NIK</b></span>
                        <input type="text" name="nik" id=""
                            class="profile-input border-l border-black profile-input-2 w-full flex items-center px-2 bg-transparent"
                            disabled value="{{ $data_pengajar->nik }}">
                        <span><b>Mata Pelajaran</b></b></span>
                        <span class="px-2 font-semibold flex flex-wrap gap-2 border-l border-black">
                            @php
                                $warna = collect(['bg-purple-200 border-purple-500 text-purple-700', 'bg-tosca-200 border-tosca-500 text-tosca-700', 'bg-bluesea-200 border-bluesea-500 text-bluesea-700', 'bg-bluesky-200 border-bluesky-500 text-bluesky-700', 'bg-orange-200 border-orange-500 text-orange-700']);
                            @endphp

                            @foreach ($mapel_pengajar as $mapel)
                                @php
                                    $data_warna = $warna->random();
                                @endphp
                                <div class="badge badge-outline {{ $data_warna }} flex gap-2 text-xs">
                                    {{ $mapel->nama_mapel }}
                                    <button class="remove-btn hidden" data-id="{{ $mapel->id }}"><i
                                            class="fa-solid fa-x"></i></button>
                                </div>
                            @endforeach
                            <a onclick="mapel_modal.showModal()" class="badge badge-outline cursor-pointer hidden"
                                id="mapel-add">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </span>
                    </div>

                    <div class="w-full h-full">
                        <h1 class="font-semibold">Detail</h1>
                        <div
                            class="w-full h-full grid grid-cols-2 gap-2 p-5 max-md:grid-cols-1 max-md:p-0 place-content-center">
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-darkblue-200 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/sekolah.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">
                                    {{ $jumlah_sekolah }}</h1>
                                <span class="font-semibold">Sekolah</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-bluesea-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/kelas.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">{{ $data_pengajar->kelas()->count() }}</h1>
                                <span class="font-semibold">Kelas</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-bluesky-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/tugas.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">{{ $data_pengajar->tugas()->count() }}</h1>
                                <span class="font-semibold">Tugas</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-tosca-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/siswa.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">{{ $jumlah_siswa }}</h1>
                                <span class="font-semibold">Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
