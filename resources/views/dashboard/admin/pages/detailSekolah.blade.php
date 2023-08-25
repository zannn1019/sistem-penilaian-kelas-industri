@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li>{{ $data->nama }}</li>
                </ul>
            </div>
        </header>
        <div class="w-full h-full flex flex-col max-md:px-5 px-16 gap-2">
            <div class="info-sekolah flex max-md:flex-col max-md:items-center gap-5 relative w-full">
                <img src="{{ asset('storage/sekolah/' . $data->logo) }}"
                    class="w-44 h-44 z-10 aspect-square bg-white rounded-circle border-4 border-darkblue-500" alt="">
                <div class="info w-full text-center">
                    <h1 class="text-5xl font-semibold py-2 border-b border-black w-full">{{ $data->nama }}</h1>
                </div>
                <div
                    class="w-full h-1/2 rounded-box text-white p-5 flex justify-end max-md:justify-start px-16 max-md:px-0 items-center absolute bottom-0 left-0 bg-darkblue-500">
                    <a href="{{ route('sekolah.edit', ['sekolah' => $data->id]) }}"
                        class="absolute top-0 right-0 px-3 py-2"><i
                            class="fa-solid fa-pen rounded-circle border border-white p-2"></i></a>
                    <div class="data w-10/12 max-md:w-full max-md:px-5 max-md:pt-12 max-sm:pt-0 max-sm:pb-0 max-md:pb-5">
                        <div class="contact flex max-md:flex-col max-md:gap-0 gap-10 text-xs">
                            <div class="email flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-envelope text-lg"></i>
                                <span><b>Email</b></span>
                                <span> | </span>
                                <span>{{ $data->email }}</span>
                            </div>
                            <div class="phone flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-phone text-lg"></i>
                                <span><b>No. Telepon</b></span>
                                <span>|</span>
                                <span>{{ $data->no_telp }}</span>
                            </div>
                        </div>
                        <div class="address flex items-center gap-2 text-xs">
                            <span><i class="fa-solid fa-school text-sm"></i></span>
                            <span><b>Alamat</b></span>
                            <span>|</span>
                            <span
                                class="capitalize truncate">{{ Str::lower($data->jalan . ', ' . $data->kelurahan . ', ' . $data->kecamatan . ', ' . $data->kabupaten_kota . ', ' . $data->provinsi) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data w-full h-full border flex flex-col border-black rounded-box">
                <div
                    class="flex justify-between bg-gray-300 gap-2 w-full rounded-box outline outline-gray-300 p-1 text-center max-sm:flex-col">
                    <a href="" class="link-hover w-full bg-darkblue-500 text-white p-1 rounded-box">Kelas Industri
                        ({{ $data->kelas->count() }})</a>
                    <a href="" class="link-hover w-full text-gray-500 p-1 rounded-box">Pengajar
                        ({{ $data->pengajar->count() }})</a>
                </div>
                <div class="w-full h-full flex flex-col justify-between relative">
                    @if ($data->kelas->count() > 0)
                        @foreach ($data->kelas as $kelas)
                        @endforeach
                    @else
                        <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                            <img src="{{ asset('img/404_kelas.png') }}" alt="">
                            <h1>Belum ada kelas!</h1>
                        </div>
                        <div class="w-full h-max flex justify-between px-5 py-1 items-center">
                            <a href=""
                                class="btn rounded-circle text-black bg-transparent border-none hover:bg-transparent"><i
                                    class="fa-solid fa-up-right-from-square text-xl"></i></a>
                            <a href="{{ route('kelas.create') }}" class="btn rounded-circle text-white text-xl"><i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
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
