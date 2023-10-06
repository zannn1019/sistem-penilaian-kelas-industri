@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full gap-2 p-5 text-black flex flex-col">
        <div class="w-full h-auto flex items-center gap-4 ">
            <a href="{{ route('mapel.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black text-2xl"></a>
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('mapel.index') }}">Mata Pelajaran</a></li>
                    <li>{{ $info_mapel->nama_mapel }}</li>
                </ul>
            </div>
        </div>
        <div class=" w-full h-auto px-8 pb-5 border-b border-black flex justify-between items-center">
            <h1 class="text-5xl max-sm:text-lg font-semibold">{{ $info_mapel->nama_mapel }}</h1>
            <div class="dropdown dropdown-left" data-theme="light">
                <label tabindex="0" class="text-2xl cursor-pointer m-1">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </label>

                <div tabindex="0" class="dropdown-content z-[1] p-2 shadow bg-gray-100 rounded-box flex flex-col w-52">
                    <label onclick="editModal.showModal()"
                        class="p-2 w-full cursor-pointer hover:font-semibold border-b border-black">Edit</label>
                    <form action="{{ route('mapel.destroy', $info_mapel->id) }}" method="POST"
                        class="p-2 w-full hover:font-bold">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-start">Arsip</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-full h-[75%] flex flex-col gap-2 ">
            <span class="px-10 font-semibold text-xl max-sm:text-sm">Daftar Pengajar</span>
            @if ($info_mapel->pengajar->count())
                <div class="overflow-x-auto w-full h-full" dir="rtl" data-theme="light">
                    <table class="table max-sm:table-xs table-zebra border border-black text-center" dir="ltr">
                        <thead>
                            <tr class="bg-darkblue-500 text-white">
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Pengajar</th>
                                <th>Email</th>
                                <th>Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info_mapel->pengajar as $pengajar)
                                <tr>
                                    <td class="border border-black">{{ $loop->iteration }}</td>
                                    <td class="border border-black">{{ $pengajar->nik }}</td>
                                    <td class="border border-black">{{ $pengajar->nama }}</td>
                                    <td class="border border-black">{{ $pengajar->email }}</td>
                                    <td class="border border-black">{{ $pengajar->no_telp }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="w-full h-full flex justify-center items-center flex-col text-gray-500">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                    <h1>Belum ada pengajar!</h1>
                </div>
            @endif
        </div>
    </div>
    <dialog id="editModal" class="modal" data-theme="light">
        <form action="{{ route('mapel.update', ['mapel' => $info_mapel->id]) }}" method="POST"
            class="modal-box text-black flex flex-col w-full gap-2">
            @csrf
            @method('PATCH')
            <h1 class="font-semibold text-3xl w-full text-center">Edit Mata Pelajaran</h1>
            <input type="text" class="input input-bordered" placeholder="Nama mata pelajaran" name="nama_mapel"
                value="{{ $info_mapel->nama_mapel }}" required>
            <div class="w-full flex justify-between py-2">
                <button id="close-btn" class="px-4 py-1 bg-gray-200 rounded-2xl">Close</button>
                <button type="submit" class="px-4 py-1 bg-darkblue-500 rounded-2xl text-white">Edit</button>
            </div>
        </form>
    </dialog>
@endsection

@section('script')
    <script>
        $("#close-btn").click(function(e) {
            e.preventDefault()
            editModal.close()
        })
    </script>
@endsection
