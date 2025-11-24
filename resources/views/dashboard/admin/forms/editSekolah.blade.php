@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.show', ['sekolah' => $data->id]) }}"
                class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li><a href="{{ route('sekolah.show', ['sekolah' => $data->id]) }}">{{ $data->nama }}</a></li>
                    <li>Edit Informasi Sekolah</li>
                </ul>
            </div>
        </header>
        <form class="w-full h-auto px-16 flex gap-2 max-md:flex-col max-md:px-5"
            action="{{ route('sekolah.update', ['sekolah' => $data->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="max-md:w-full max-md:flex max-md:justify-center">

                <div
                    class="input-logo bg-gray-100 w-36 aspect-square border border-black h-36 rounded-circle flex justify-center items-center relative">
                    <div
                        class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative hover:brightness-50 ">
                        <input type="file" name="logo" id="input-photo"
                            class="z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0">
                        <i class="fa-solid fa-plus "></i>
                        <img src="{{ asset('storage/sekolah/' . $data->logo) }}" alt=""
                            class="absolute top-0 left-0 w-full h-full pointer-events-none z-20" id="photo-preview">
                    </div>
                    <div
                        class="absolute max-md:hidden w-64 h-10 bg-gradient-to-r from-bluesky-500 to-bluesea-500 top-0 left-12 rounded-6xl border border-black text-white font-semibold text-sm flex items-center justify-end px-2">
                        Tambah logo sekolah</div>
                </div>
            </div>
            <div class="w-full h-full py-14 max-md:py-2 flex flex-col gap-2" data-theme="light">
                <input type="text" placeholder="Nama Sekolah" name="nama" value="{{ $data->nama }}"
                    class="input input-bordered focus:outline-none w-full text-xl h-16 text-black font-semibold border-black " />
                <div class="w-full border border-black rounded-xl p-3 flex gap-2 flex-col">
                    <h1 class="font-semibold pb-2">Alamat Sekolah</h1>
                    <div class="w-full grid grid-cols-2 gap-2 max-md:grid-cols-1">
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Provinsi</h1>
                            <select class="select select-bordered w-full" data-theme="light" id="provinsi" name="provinsi">
                                <option disabled selected>Provinsi</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kabupaten/Kota</h1>
                            <select class="select select-bordered w-full" data-theme="light" id="kabupaten-kota"
                                name="kabupaten_kota">
                                <option disabled selected>Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kecamatan</h1>
                            <select class="select select-bordered w-full  " data-theme="light" id="kecamatan"
                                name="kecamatan">
                                <option disabled selected>Kecamatan</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Kelurahan</h1>
                            <select class="select select-bordered w-full" data-theme="light" id="kelurahan"
                                name="kelurahan">
                                <option disabled selected>Kelurahan</option>
                            </select>
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Jalan</h1>
                            <input type="text" placeholder="Type here"
                                class="input input-bordered focus:outline-none w-full" name="jalan"
                                value="{{ $data->jalan }}" />
                        </div>
                    </div>
                    <hr class="border-black">
                    <div class="w-full grid gap-2 grid-cols-2 max-md:grid-cols-1">
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Email</h1>
                            <input type="text" placeholder="Type here" value="{{ $data->email }}"
                                class="input input-bordered focus:outline-none w-full" name="email" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Nomor Telepon</h1>
                            <input type="text" placeholder="Type here"
                                class="input input-bordered focus:outline-none w-full" name="no_telp"
                                value="{{ $data->no_telp }}" />
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
        $("#nama-sekolah").keyup(function() {
            $("#indicator").text($(this).val().length)
        })
        $("#nama-sekolah").keydown(function() {
            $("#indicator").text($(this).val().length)
        })
        $("#input-photo").on("change", function(e) {
            const file = URL.createObjectURL(e.target.files[0]);
            $("#photo-preview").attr("src", file);
        });

        
        $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(data) {
            $.each(data, function(index, provinsi) {
                $('#provinsi').append(
                    `<option value="${provinsi.name}" data-id="${provinsi.id}">${provinsi.name}</option>`
                );
            });
        });

        $('#provinsi').change(function() {
            let selectedProvinsi = $(this).find(':selected').data('id');
            
            $('#kabupaten-kota').empty();
            $('#kabupaten-kota').append(new Option('Pilih Kabupaten/Kota', ''));
            $('#kecamatan').empty().append(new Option('Pilih Kecamatan', '')); 
            $('#kelurahan').empty().append(new Option('Pilih Kelurahan', ''));
            
            if (selectedProvinsi) {
                $('#kabupaten-kota').removeAttr('disabled');
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${selectedProvinsi}.json`, function(data) {
                    $.each(data, function(index, kabupaten) {
                        $('#kabupaten-kota').append(
                            `<option value="${kabupaten.name}" data-id="${kabupaten.id}">${kabupaten.name}</option>`
                        );
                    });
                });
            } else {
                $('#kabupaten-kota').attr('disabled', 'disabled');
            }
        });

        $('#kabupaten-kota').change(function() {
            let selectedKabupaten = $(this).find(':selected').data('id');
            
            $('#kecamatan').empty();
            $('#kecamatan').append(new Option('Pilih Kecamatan', ''));
            $('#kelurahan').empty().append(new Option('Pilih Kelurahan', '')); 

            if (selectedKabupaten) {
                $('#kecamatan').removeAttr('disabled');
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${selectedKabupaten}.json`, function(data) {
                    $.each(data, function(index, kecamatan) {
                        $('#kecamatan').append(
                            `<option value="${kecamatan.name}" data-id="${kecamatan.id}">${kecamatan.name}</option>`
                        );
                    });
                });
            } else {
                $('#kecamatan').attr('disabled', 'disabled');
            }
        });

        $('#kecamatan').change(function() {
            let selectedKecamatan = $(this).find(':selected').data('id');
            
            $('#kelurahan').empty();
            $('#kelurahan').append(new Option('Pilih Kelurahan', ''));

            if (selectedKecamatan) {
                $('#kelurahan').removeAttr('disabled');
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${selectedKecamatan}.json`, function(data) {
                    $.each(data, function(index, kelurahan) {
                        $('#kelurahan').append(
                            `<option value="${kelurahan.name}" data-id="${kelurahan.id}">${kelurahan.name}</option>`
                        );
                    });
                });
            } else {
                $('#kelurahan').attr('disabled', 'disabled');
            }
        });
    });
</script>
@endsection
