@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative "id="content">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('kelas.show', $data->id) }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
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
            <form action="{{ route('siswa.store') }}" method="POST" class="w-4/6 max-sm:w-full flex flex-col gap-2"
                data-theme="light">
                @csrf
                <input type="hidden" name="id_sekolah" value="{{ $data->sekolah->id }}">
                <input type="hidden" name="id_kelas" value="{{ $data->id }}">
                <div class="input-range flex justify-center items-center border border-black p-5 rounded-lg ">
                    <input type="text" placeholder="Masukkan nama siswa" id="nama_siswa" name="nama" class="w-full "
                        maxlength="50" required minlength="3" />
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
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                                required minlength="9" pattern="[0-9]+" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Nomor Telepon</span>
                            </label>
                            <input type="text" placeholder="Masukkan nomor telepon yang valid" name="no_telp"
                                minlength="11" pattern="[0-9]+"
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs" />
                        </div>
                    </div>
                </div>
                <input type="submit" value="selesai" class="btn w-fit self-end btn-info text-white">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#nama_siswa").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_siswa").keydown(function() {
                $("#indicator").text($(this).val().length)
            })
        });
    </script>
@endsection
