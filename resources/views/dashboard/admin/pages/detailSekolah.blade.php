@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-sm:text-lg text-black"></a>
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li>{{ $data->nama }}</li>
                </ul>
            </div>
        </header>
        <div class="w-full h-full flex flex-col px-16 py-3 gap-2">
            <div class="info-sekolah flex relative">
                <img src="{{ asset('storage/sekolah/' . $data->logo) }}"
                    class="w-44 h-44 aspect-square rounded-circle border-4 border-darkblue-500 z-10" alt="">
                <div class="info w-full text-center">
                    <h1 class="text-5xl font-semibold py-2 border-b border-black w-full">{{ $data->nama }}</h1>
                </div>
                <div
                    class="w-full h-1/2 rounded-box text-white p-5 flex justify-end px-16 items-center absolute bottom-0 left-0 bg-darkblue-500">
                    <div class="data w-10/12">
                        <div class="contact flex gap-10 text-xs">
                            <div class="email flex gap-2 justify-center items-center">
                                <i class="fa-solid fa-envelope text-xl"></i>
                                <span><b>Email</b></span>
                                <span> | </span>
                                <span>{{ $data->email }}</span>
                            </div>
                            <div class="phone flex gap-2 justify-center items-center">
                                <i class="fa-solid fa-phone text-xl"></i>
                                <span><b>No. Telepon</b></span>
                                <span>|</span>
                                <span>{{ $data->no_telp }}</span>
                            </div>
                        </div>
                        <div class="address flex items-center gap-2 text-xs">
                            <span><i class="fa-solid fa-school text-lg"></i></span>
                            <span><b>Alamat</b></span>
                            <span>|</span>
                            <span
                                class="capitalize truncate">{{ Str::lower($data->jalan . ', ' . $data->kelurahan . ', ' . $data->kecamatan . ', ' . $data->kabupaten_kota . ', ' . $data->provinsi) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data w-full h-full border border-black rounded-box">
                <div
                    class="flex justify-between bg-gray-300 gap-2 w-full rounded-box outline outline-gray-300 p-1 text-center">
                    <a href="" class="link-hover w-full bg-darkblue-500 text-white p-1 rounded-box">Kelas Industri
                        ({{ $data->kelas->count() }})</a>
                    <a href="" class="link-hover w-full text-gray-500 p-1 rounded-box">Pengajar
                        ({{ $data->pengajar->count() }})</a>
                </div>
                <div class="w-full h-full grid place-content-center">
                    @if ($data->kelas->count() > 0)
                        <h1>Ada data</h1>
                    @else
                        <h1>Gada Data</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto">
        <a href="{{ route('sekolah.index') }}">Back</a>
        <img src="{{ asset('/storage/sekolah/' . $data->logo) }}" alt="" class="w-20">
        <h1>{{ $data->nama }}</h1>
        <span>{{ $data->alamat }}</span>
        <span>{{ $data->no_telp }}</span>

        <hr class="border-black">
        <h1 class="text-xl font-bold w-full text-center">Data Kelas</h1>

        <form action="{{ route('kelas.store') }}" method="POST" data-theme="light" class="flex flex-col gap-2"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_sekolah" value="{{ $data->id }}">
            <select class="file-input file-input-bordered w-full  border px-2" name="tingkat">
                <option disabled selected>Tingkat</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
            </select>
            <input type="text" placeholder="Jurusan" class="input input-bordered w-full " name="jurusan" />
            <input type="text" placeholder="Nama" class="input input-bordered w-full " name="nama" />
            <input type="file" class="file-input file-input-bordered file-input-accent w-full " name="sticker" />
            <input type="submit" class="btn btn-primary" value="Simpan">
        </form>
        <hr>

        @if ($data->kelas == null)
            <h1>Belum ada data</h1>
        @else
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Sticker</th>
                    <th>Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th>Aksi</th>
                </tr>
                @foreach ($data->kelas as $kelas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('storage/jurusan/' . $kelas->sticker) }}" alt="" class="w-20"></td>
                        <td>{{ $kelas->tingkat }}-{{ $kelas->jurusan }}-{{ $kelas->nama }}</td>
                        <td>{{ $kelas->siswa->count() }}</td>
                        <td class="flex gap-2"><a href="{{ route('kelas.show', ['kela' => $kelas->id]) }}">Detail</a> | <a
                                href="">edit</a> |
                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div> --}}
@endsection
