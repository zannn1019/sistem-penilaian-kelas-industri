@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 text-black flex flex-col gap-2 overflow-y-auto">
        <h1>Tambah Pengajar</h1>
        <form action="{{ route('users.store') }}" method="POST" data-theme="light" class="flex flex-col gap-1 max-w-sm"
            enctype="multipart/form-data">
            @csrf
            <input type="file" class="file-input file-input-bordered w-full " name="foto" />
            <input type="text" placeholder="Nama" class="input input-bordered w-full " name="nama" />
            <input type="text" placeholder="NIK" class="input input-bordered w-full " name="nik" />
            <input type="text" placeholder="Username" class="input input-bordered w-full " name="username" />
            <input type="password" placeholder="Password" class="input input-bordered w-full " name="password" />
            <input type="tel" placeholder="Nomor Telepon" class="input input-bordered w-full " name="no_telp" />
            <input type="submit" value="Tambah" class="btn btn-primary w-full">
        </form>
        <div class="flex items-end gap-1 font-semibold">
            <h1 class="text-3xl">Daftar Pengajar</h1>
            <span>({{ $data_pengajar->count() }})</span>
        </div>
        <div class="grid grid-rows-2 grid-cols-4 gap-2 w-full h-full">
            @foreach ($data_pengajar as $pengajar)
                <div
                    class="w-full h-full bg-tosca-100 flex p-2 rounded-box shadow-xl flex-col items-center gap-0.5 relative py-5">
                    <div class="dropdown dropdown-end absolute top-0 right-0 px-5 py-3">
                        <label tabindex="0" class="cursor-pointer">
                            <i class="fa-solid fa-ellipsis"></i>
                        </label>
                        <div tabindex="0"
                            class="dropdown-content z-[1] menu shadow bg-white rounded-box w-20 flex flex-col">
                            <a href="" class="p-2 hover:font-bold">Edit</a>
                            <form action="{{ route('users.destroy', $pengajar->id) }}" method="POST"
                                class="p-2 hover:font-bold">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                    <div class="avatar">
                        <div class="w-20 rounded-full">
                            <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}" alt="">
                        </div>
                    </div>
                    <h1 class="font-semibold leading-3">{{ $pengajar->nama }}</h1>
                    <span class="capitalize text-sm">{{ $pengajar->role }}</span>
                    <div class="w-full flex flex-wrap text-center justify-evenly items-center gap-5">
                        <div>
                            <h1 class="text-xs">Sekolah</h1>
                            <span class="font-semibold">1</span>
                        </div>
                        <div>
                            <h1 class="text-xs">Sekolah</h1>
                            <span class="font-semibold">1</span>
                        </div>
                        <div>
                            <h1 class="text-xs">Kelas</h1>
                            <span class="font-semibold">1</span>
                        </div>
                    </div>
                    <div class="w-full flex justify-evenly p-2">
                        <a href="" class="bg-tosca-400 px-3 py-1 rounded-box text-white text-xs"><i
                                class="fa-solid fa-user"></i> Profile</a>
                        <a href="" class="bg-tosca-400 px-3 py-1 rounded-box text-white text-xs"><i
                                class="fa-solid fa-envelope"></i> Contact</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
