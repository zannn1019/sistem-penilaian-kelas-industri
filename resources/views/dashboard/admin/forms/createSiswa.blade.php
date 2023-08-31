@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative "id="content">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('kelas.show', ['kela' => $data->id]) }}"
                class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li><a
                            href="{{ route('sekolah.show', ['sekolah' => $data->sekolah->id]) }}">{{ $data->sekolah->nama }}</a>
                    </li>
                    <li>
                        <a href="{{ route('kelas.show', $data->id) }}">
                            {{ $data->nama_kelas . ' ( ' . $data->tingkat . ' ' . $data->jurusan . ' ' . $data->kelas . ' )' }}
                        </a>
                    </li>
                    <li>Tambah Siswa</li>
                </ul>
            </div>
        </header>
        <div class="w-full h-full flex justify-center items-center">
            <form action="{{ route('siswa.store') }}" method="POST" class="w-4/6 flex flex-col gap-2" data-theme="light">
                @csrf
                <input type="hidden" name="id_sekolah" value="{{ $data->sekolah->id }}">
                <input type="hidden" name="id_kelas" value="{{ $data->id }}">
                <div class="input-range flex justify-center items-center border border-black p-5 rounded-lg ">
                    <input type="text" placeholder="Masukkan nama siswa" id="nama_siswa" name="nama" class="w-full "
                        maxlength="50" />
                    <span class="font-normal" id="indicator">0</span>
                    <span class="font-normal">/50</span>
                </div>
                <div class="border border-black p-5 rounded-lg">
                    <h1 class="text-lg font-semibold">Data Siswa</h1>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">NIS</span>
                            </label>
                            <input type="text" placeholder="Masukkan NIS siswa" name="nis"
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Nomor Telepon</span>
                            </label>
                            <input type="text" placeholder="Masukkan nomor telepon yang valid" name="no_telp"
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Tahun ajaran</span>
                            </label>
                            <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                                value="{{ date('Y') . '/' . date('Y') + 1 }}" disabled />
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Semester</span>
                            </label>
                            <select name="semester" id="semester" class="select select-bordered border-black " disabled>
                                <option value="1" selected>Ganjil</option>
                                <option value="2">Genap</option>
                            </select>
                        </div>
                        <div class="w-full col-span-2 text-xs flex items-center gap-2">
                            <input type="checkbox" class="checkbox checkbox-sm" id="checkbox-input" />
                            <label for="">Ubah tahun ajaran dan semester</label>
                        </div>
                    </div>
                </div>
                <input type="submit" value="selesai" class="btn w-fit self-end btn-info text-white">
            </form>
        </div>
    </div>
    {{-- <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto">
        <a href="{{ route('sekolah.index') }}">Back</a>
        <img src="{{ asset('/storage/jurusan/' . $data->sticker) }}" alt="" class="w-20">
        <span>{{ $data->sekolah->nama }}</span>
        <h1>{{ $data->tingkat . '-' . $data->jurusan . '-' . $data->nama }}</h1>
        <span>{{ $data->no_telp }}</span>
        <hr class="border-black">
        <h1 class="w-full text-center text-xl">Tambah Siswa</h1>
        <form action="{{ route('siswa.store') }}" method="POST" data-theme="light" class="flex flex-col gap-2"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_sekolah" value="{{ $data->sekolah->id }}">
            <input type="hidden" name="id_kelas" value="{{ $data->id }}">
            <input type="hidden" name="tahun_ajar" value="{{ date('Y') . '/' . date('Y') + 1 }}">
            <input type="hidden" name="semester" value="1">
            <input type="text" placeholder="nis" class="input input-bordered focus:outline-none w-full " name="nis" />
            <input type="text" placeholder="nama" class="input input-bordered focus:outline-none w-full " name="nama" />
            <input type="text" placeholder="no_telp" class="input input-bordered focus:outline-none w-full " name="no_telp" />
            <input type="submit" class="btn btn-primary" value="Simpan">
        </form>
        <hr class="border-black">
        <table class="table">
            <tr>
                <th>No</th>
                <th>Nis</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Aksi</th>
            </tr>
            @foreach ($data->siswa as $siswa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->no_telp }}</td>
                    <td>{{ $siswa->tahun_ajar }}</td>
                    <td>{{ $siswa->semester }}</td>
                    <td><a href="">Detail</a> | <a href="">Edit</a> | <a href="">Hapus</a></td>
                </tr>
            @endforeach
        </table>
    </div> --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#checkbox-input").change(function() {
                if ($(this).is(":checked")) {
                    $("#tahun_ajar").removeAttr('disabled');
                    $("#semester").removeAttr('disabled');
                } else {
                    $("#tahun_ajar").attr('disabled', true);
                    $("#semester").attr('disabled', true);
                }
            })
            $("#nama_siswa").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_siswa").keydown(function() {
                $("#indicator").text($(this).val().length)
            })
        });
    </script>
@endsection
