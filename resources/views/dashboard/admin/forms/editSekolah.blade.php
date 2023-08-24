@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto">
        <form action="{{ route('sekolah.update', [$data->id]) }}" enctype="multipart/form-data" method="POST"
            class="flex flex-col w-72" data-theme="light">
            @csrf
            @method('PATCH')
            <input type="file" class="file-input file-input-bordered file-input-accent w-full max-w-xs" name="logo"
                value="{{ asset('storage/sekolah/' . $data->logo) }}" />
            <input type="text" placeholder="Nama Sekolah" class="input input-bordered w-full max-w-xs" name="nama"
                value="{{ $data->nama }}" />
            <textarea class="textarea textarea-bordered w-full" placeholder="Alamat Sekolah" name="alamat">{{ $data->alamat }}</textarea>
            <input type="tel" placeholder="Nomor Telepon Sekolah" class="input input-bordered w-full max-w-xs"
                name="no_telp" value="{{ $data->no_telp }}" />
            <input type="submit" class="btn btn-primary" value="edit">
        </form>
    </div>
@endsection
