@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-sm:text-lg text-black"></a>
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li>Sekolah Baru</li>
                </ul>
            </div>
        </header>
        <form class="w-full h-auto px-16 flex gap-2" action="{{ route('sekolah.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div
                class="input-logo bg-gray-100 w-36 aspect-square border border-black h-36 rounded-circle flex justify-center items-center relative">
                <div
                    class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative hover:brightness-50 ">
                    <input type="file" name="logo" id="input-photo"
                        class="z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0">
                    <i class="fa-solid fa-plus "></i>
                    <img src="" alt="" class="absolute top-0 left-0 w-full h-full pointer-events-none z-20"
                        id="photo-preview">
                </div>
                <div
                    class="absolute w-64 h-10 bg-gradient-to-r from-bluesky-500 to-bluesea-500 top-0 left-12 rounded-6xl border border-black text-white font-semibold text-sm flex items-center justify-end px-2">
                    Tambah logo sekolah</div>
            </div>
            <div class="w-full h-full py-14 flex flex-col gap-2" data-theme="light">
                <input type="text" placeholder="Nama Sekolah" name="nama"
                    class="input input-bordered w-full text-xl h-16 text-black font-semibold border-black focus:outline-none" />
                <div class="w-full border border-black rounded-xl p-3 flex gap-2 flex-col">
                    <h1 class="font-semibold pb-2">Alamat Sekolah</h1>
                    <div class="w-full grid grid-cols-2 gap-2">
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Provinsi</h1>
                            <select class="select select-bordered w-full" data-theme="light" id="provinsi" name="provinsi">
                                <option disabled selected>Provinsi</option>
                                @foreach ($data_provinsi as $provinsi)
                                    <option value="{{ $provinsi->name }}" data-id="{{ $provinsi->id }}">
                                        {{ $provinsi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kabupaten/Kota</h1>
                            <select class="select select-bordered w-full  " data-theme="light" id="kabupaten-kota"
                                name="kabupaten_kota" disabled>
                                <option disabled selected>Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kecamatan</h1>
                            <select class="select select-bordered w-full  " data-theme="light" id="kecamatan"
                                name="kecamatan" disabled>
                                <option disabled selected>Kecamatan</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kelurahan</h1>
                            <select class="select select-bordered w-full" data-theme="light" id="kelurahan" name="kelurahan"
                                disabled>
                                <option disabled selected>Kelurahan</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Jalan</h1>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full"
                                name="jalan" />
                        </div>
                    </div>
                    <hr class="border-black">
                    <div class="w-full grid gap-2 grid-cols-2">
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Email</h1>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full"
                                name="email" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Nomor Telepon</h1>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full"
                                name="no_telp" />
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end">
                    <input type="submit" value="Selesai" class="btn">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function populateSelectOptions(data, targetElement) {
                $(targetElement).html('');
                data.forEach(value => {
                    $(targetElement).append(
                        `<option value="${value.name}" data-id="${value.id}">${value.name}</option>`);
                });
            }
            $("#input-photo").on("change", function(e) {
                const file = URL.createObjectURL(e.target.files[0]);
                $("#photo-preview").attr("src", file);
            });

            $("#provinsi").change(function() {
                var selectedOption = $(this).find('option:selected');
                const id_prov = selectedOption.data('id');
                $("#kabupaten-kota").removeAttr('disabled');
                $.getJSON("http://127.0.0.1:8000/api/getData/regencies/" + id_prov, function(data) {
                    populateSelectOptions(data, "#kabupaten-kota")
                });
            });

            $("#kabupaten-kota").change(function() {
                var selectedOption = $(this).find('option:selected');
                const id_kabkot = selectedOption.data('id');
                $("#kecamatan").removeAttr('disabled');
                $.getJSON("http://127.0.0.1:8000/api/getData/districts/" + id_kabkot, function(data) {
                    populateSelectOptions(data, "#kecamatan")
                });
            });

            $("#kecamatan").change(function() {
                var selectedOption = $(this).find('option:selected');
                const id_kec = selectedOption.data('id');
                $("#kelurahan").removeAttr('disabled');
                $.getJSON("http://127.0.0.1:8000/api/getData/villages/" + id_kec, function(data) {
                    populateSelectOptions(data, "#kelurahan")
                });
            });
        });
    </script>
@endsection
