@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto">
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
            <input type="text" placeholder="nis" class="input input-bordered w-full " name="nis" />
            <input type="text" placeholder="nama" class="input input-bordered w-full " name="nama" />
            <input type="text" placeholder="no_telp" class="input input-bordered w-full " name="no_telp" />
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
    </div>
@endsection
